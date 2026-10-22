<?php

namespace App\Http\Controllers;

use App\Models\Sanad\Setting;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::first();

        return view('landing', compact('settings'));
    }
}
