@extends('website.layouts.app')

@section('page_key', 'blog.html')
@section('title', 'المدونة — SANAD CX')
@section('meta_description', 'مقالات وأدلة عملية حول إدارة تجربة العملاء، وتشغيل مراكز الاتصال، وتحويل كل محادثة إلى فرصة نمو حقيقية لأعمالك.')
@section('og_title', 'المدونة — SANAD CX')
@section('og_description', 'مقالات وأدلة عملية حول إدارة تجربة العملاء، وتشغيل مراكز الاتصال، وتحويل كل محادثة إلى فرصة نمو حقيقية لأعمالك.')

@section('content')
<section class="sanad-blog-hero" aria-labelledby="sanad-blog-hero-heading">
 <div class="sanad-blog-hero__copy">
  <p class="sanad-blog-hero__badge">SANAD CX BLOG — مدونة سند</p>
  <h1 class="sanad-blog-hero__headline" id="sanad-blog-hero-heading">مدونة Sanad CX</h1>
  <p class="sanad-blog-hero__description">مقالات وأدلة عملية حول إدارة تجربة العملاء، وتشغيل مراكز الاتصال، وتحويل كل محادثة إلى فرصة نمو حقيقية لأعمالك.</p>
  <p class="sanad-blog-hero__cadence">
   <span class="sanad-blog-hero__cadence-text">مقالات جديدة كل أسبوع</span>
  </p>
 </div>
 @if($featured)
 <article class="sanad-blog-hero__featured">
  <div class="sanad-blog-hero__cover">
   <img class="sanad-blog-hero__cover-image" src="{{ $featured->image ? asset($featured->image) : asset('website/assets/image/webp/globeShape_auto.webp') }}" alt="" width="300" height="300" decoding="async">
   <span class="sanad-blog-hero__label">
    <span class="sanad-blog-hero__label-text">مقال مميز</span>
   </span>
  </div>
  <p class="sanad-blog-hero__meta">تجربة العملاء · قراءة</p>
  <h2 class="sanad-blog-hero__title">{{ $featured->title }}</h2>
  <p class="sanad-blog-hero__excerpt">{{ $featured->description }}</p>
  <a class="sanad-btn sanad-btn--md sanad-blog-hero__read" href="{{ route('website.blog.article', ['slug' => $featured->slug]) }}">اقرأ المقال</a>
 </article>
 @endif
</section>

@if($articles->isNotEmpty())
<section class="sanad-blog-articles" aria-labelledby="sanad-blog-articles-heading">
 <div class="sanad-blog-articles__header">
  <p class="sanad-blog-articles__eyebrow">أحدث المقالات</p>
  <h2 class="sanad-blog-articles__title" id="sanad-blog-articles-heading">رؤى عملية من فريق تشغيل Sanad CX</h2>
 </div>
 <div class="sanad-blog-articles__grid">
  @foreach($articles as $article)
  <article class="sanad-blog-card sanad-card-hoverable">
   <div class="sanad-blog-card__cover">
    <img class="sanad-blog-card__cover-image" src="{{ $article->image ? asset($article->image) : asset('website/assets/image/svg/blog-cover-calls.svg') }}" alt="" width="384" height="216" loading="lazy" decoding="async">
   </div>
   <div class="sanad-blog-card__body">
    <h3 class="sanad-blog-card__title">{{ $article->title }}</h3>
    <p class="sanad-blog-card__excerpt">{{ $article->description }}</p>
    <span class="sanad-blog-card__spacer" aria-hidden="true"></span>
    <a class="sanad-btn sanad-btn--md sanad-btn--outline sanad-blog-card__read" href="{{ route('website.blog.article', ['slug' => $article->slug]) }}">اقرأ المقال</a>
   </div>
   <div class="sanad-card-hover-overlay" aria-hidden="true"></div>
  </article>
  @endforeach
 </div>
</section>
@endif
@endsection
