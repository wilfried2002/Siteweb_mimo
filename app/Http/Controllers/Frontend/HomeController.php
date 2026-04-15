<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Slider;
use App\Models\JobOffer;

class HomeController extends Controller
{
    public function index()
    {
        $sliders  = Slider::active()->get();
        $products = Product::active()->featured()->latest()->take(6)->get();
        $jobs     = JobOffer::active()->latest()->take(3)->get();

        return view('frontend.home', compact('sliders', 'products', 'jobs'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function services()
    {
        return view('frontend.services');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
