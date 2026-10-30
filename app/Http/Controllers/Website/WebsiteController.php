<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Sanad\Blog;
use App\Models\Sanad\ClientReview;
use App\Models\Sanad\Faq;
use App\Models\Sanad\WhyChooseUs;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    public function home(): View
    {
        $whyChooseUs = WhyChooseUs::with(['translations', 'features.translations'])
            ->orderBy('sort_order')
            ->get();

        $clientReviewSlides = ClientReview::with('translations')
            ->get()
            ->chunk(2);

        $faqs = Faq::with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('website.pages.home', compact('whyChooseUs', 'clientReviewSlides', 'faqs'));
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
        $featured = Blog::where('is_featured', true)->with('translations')->first();
        $articles = Blog::where('is_featured', false)->with('translations')->get();

        return view('website.pages.blog', compact('featured', 'articles'));
    }

    public function blogArticle(string $slug): View
    {
        $article = Blog::whereTranslation('slug', $slug)->with('translations')->firstOrFail();
        $related = Blog::where('id', '!=', $article->id)->with('translations')->limit(3)->get();

        return view('website.pages.blog-article', compact('article', 'related'));
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
