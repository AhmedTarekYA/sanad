<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    public function home(): View
    {
        return view('website.pages.home');
    }

    public function about(): View
    {
        return view('website.pages.about');
    }

    public function services(): View
    {
        return view('website.pages.services');
    }

    public function howItWorks(): View
    {
        return view('website.pages.how-it-works');
    }

    public function blog(): View
    {
        return view('website.pages.blog');
    }

    public function blogArticle(): View
    {
        return view('website.pages.blog-article');
    }

    public function privacy(): View
    {
        return view('website.pages.privacy-policy');
    }

    public function terms(): View
    {
        return view('website.pages.terms');
    }

    public function notFound(): View
    {
        return view('website.errors.404');
    }
}
