<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\JobOffer;
use App\Models\JobApplication;
use App\Models\Slider;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'     => Product::count(),
            'jobs'         => JobOffer::where('is_active', true)->count(),
            'applications' => JobApplication::count(),
            'pending'      => JobApplication::where('status', 'pending')->count(),
            'sliders'      => Slider::count(),
        ];

        $recentApplications = JobApplication::with('jobOffer')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentApplications'));
    }
}
