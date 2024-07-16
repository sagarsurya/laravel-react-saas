<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Resources\FeatureResource;
use App\Models\UsedFeature;

class Feature3Controller extends Controller
{
    public ?Feature $feature = null;

    public function __construct()
    {
        $this->feature = Feature::where("route_name", "feature3.index")
            ->where('active',true)
            ->firstOrFail();
    }

    public function index(){
        return inertia('Feature3/Index', [
            'feature' => new FeatureResource($this->feature),
            'answer' => session('answer')
        ]);
    }

    public function calculate(Request $request){
        $user = $request->user();

        if($user->available_credits < $this->feature->required_credits){
            return back();
        }

        $data = $request->validate([
            'number1' => ['required','numeric'],
            'number2' => ['required','numeric']
        ]);

        $number1 = (float)$data['number1'];
        $number2 = (float)$data['number2'];

        $calculateResult = $number1 * $number2;
        $data['result'] = $calculateResult;

        $user->decreaseCredits($this->feature->required_credits);

        UsedFeature::create([
            'feature_id' => $this->feature->id,
            'user_id' => $user->id,
            'credits' => $this->feature->required_credits,
            'data' => $data,
        ]);

        return to_route('feature3.index')->with('answer', $calculateResult);
    }
}
