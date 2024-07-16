<?php

namespace App\Http\Controllers;

use App\Models\UsedFeature;
use Illuminate\Http\Request;
use App\Http\Resources\UsedFeatureResource;

class DashboardController extends Controller
{
    public function index(){
        $usedFeatures = UsedFeature::query()
        ->with(['feature'])
        ->where('user_id', auth()->user()->id)
        ->latest()
        ->paginate();

        return inertia('Dashboard', [
            'usedFeatures' => UsedFeatureResource::collection($usedFeatures),
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }
}
