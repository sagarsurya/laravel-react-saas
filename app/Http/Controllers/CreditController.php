<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Resources\PackageResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    public function index(){
        $packages = Package::all();
        $features = Feature::where('active', true)->get();


        return inertia('Credit/Index', [
            'packages' => PackageResource::collection($packages),
            'features' => FeatureResource::collection($features),
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    public function buyCredits(Package $package){
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $package->name . ' - '. $package->credits . ' credits',
                        ],
                        'unit_amount' => $package->price * 100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('credits.success', [], true),
            'cancel_url' => route('credits.cancel', [], true),
        ]);

        Transaction::create([
            'status' => 'pending',
            'price' => $package->price,
            'credits' => $package->credits,
            'session_id' => $checkout_session->id,
            'user_id' => Auth::id(),
            'package_id' => $package->id,
        ]);

        return redirect($checkout_session->url);
    }

    public function success(){
        return to_route('credits.index')
            ->with('success', 'You have successfully bought new credits');
    }

    public function cancel(){
        return to_route('credits.index')
            ->with('error', 'There was an error in payment process. Please try again');
    }

    public function webhook(){

        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch(\UnexpectedValueException $e){
            return response('', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e){
            return response('', 400);
        }

        //Handle the event
        switch($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $transation = Transaction::where('session_id', $session->id)->first();
                if($transation && $transation->status === 'pending'){
                    $transation->status = 'paid';
                    $transation->save();
                    $transation->user->available_credits += $transation->credits;
                    $transation->user->save();
                }
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        return response();
    }
}
