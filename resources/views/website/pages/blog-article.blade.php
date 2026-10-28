@extends('website.layouts.app')

@section('page_key', 'blog-article.html')
@section('title', $article->title . ' — SANAD CX')
@section('meta_description', $article->description)
@section('og_title', $article->title . ' — SANAD CX')
@section('og_description', $article->description)

@section('content')
<section class="sanad-article-hero" id="sanad-article-hero" aria-labelledby="sanad-article-hero-title">
 <div class="sanad-article-hero__row">
  <div class="sanad-article-hero__copy">
   <a class="sanad-article-hero__back" href="{{ route('website.blog') }}">→ العودة إلى المدونة</a>
   <p class="sanad-article-hero__badge">CUSTOMER EXPERIENCE — تجربة العملاء</p>
   <h1 class="sanad-article-hero__title" id="sanad-article-hero-title">{{ $article->title }}</h1>
   <p class="sanad-article-hero__description">{{ $article->description }}</p>
   @if($article->created_at)
   <div class="sanad-article-hero__meta">
    <p class="sanad-article-hero__meta-text">{{ $article->created_at->translatedFormat('j F Y') }} · قراءة</p>
   </div>
   @endif
  </div>
  <div class="sanad-article-hero__cover">
   <span class="sanad-article-hero__ring sanad-article-hero__ring--one" aria-hidden="true"></span>
   <span class="sanad-article-hero__ring sanad-article-hero__ring--two" aria-hidden="true"></span>
   <span class="sanad-article-hero__ring sanad-article-hero__ring--three" aria-hidden="true"></span>
   <span class="sanad-article-hero__cover-badge">
    <span class="sanad-article-hero__cover-icon">
     <img class="sanad-article-hero__cover-icon-image" src="{{ asset('website/assets/image/svg/phoneOperationsIcon_24x24.svg') }}" alt="" width="47.69" height="46.13" decoding="async">
    </span>
   </span>
  </div>
 </div>
</section>

<section class="sanad-article-body" aria-label="{{ $article->title }}">
 <div class="sanad-article-body__content">
  {!! $article->content !!}
 </div>
 <div class="sanad-article-body__cta">
  <p class="sanad-article-body__cta-title">هل تريد تطبيق هذه الخطوات في شركتك؟</p>
  <p class="sanad-article-body__cta-description">احجز استشارة مجانية مع فريقنا التشغيلي لتحليل قنواتك الحالية ووضع خطة لتسريع الاستجابة.</p>
  <button type="button" class="sanad-btn sanad-btn--md sanad-article-body__cta-button" data-consultation-open>احصل على استشارة مجانية</button>
 </div>
</section>

@if($related->isNotEmpty())
<section class="sanad-article-related" aria-labelledby="sanad-article-related-title">
 <div class="sanad-article-related__header">
  <p class="sanad-article-related__eyebrow">اقرأ أيضاً</p>
  <h2 class="sanad-article-related__title" id="sanad-article-related-title">مقالات ذات صلة</h2>
 </div>
 <ul class="sanad-article-related__list">
  @foreach($related as $relatedArticle)
  <li class="sanad-article-related__item">
   <article class="sanad-article-card sanad-card-hoverable">
    <div class="sanad-article-card__cover">
     <span class="sanad-article-card__ring sanad-article-card__ring--one" aria-hidden="true"></span>
     <span class="sanad-article-card__ring sanad-article-card__ring--two" aria-hidden="true"></span>
     <span class="sanad-article-card__ring sanad-article-card__ring--three" aria-hidden="true"></span>
     <span class="sanad-article-card__cover-badge">
      <span class="sanad-article-card__cover-icon">
       <img class="sanad-article-card__cover-icon-image sanad-article-card__cover-icon-image--support" src="{{ asset('website/assets/image/svg/customerSupportIcon_24x24.svg') }}" alt="" width="26.67" height="26.67" decoding="async">
      </span>
     </span>
    </div>
    <div class="sanad-article-card__body">
     <h3 class="sanad-article-card__title">{{ $relatedArticle->title }}</h3>
     <p class="sanad-article-card__excerpt">{{ $relatedArticle->description }}</p>
     <span class="sanad-article-card__action-spacer" aria-hidden="true"></span>
     <a class="sanad-btn sanad-btn--md sanad-btn--outline sanad-article-card__cta" href="{{ route('website.blog.article', ['slug' => $relatedArticle->slug]) }}">اقرأ المقال</a>
    </div>
    <div class="sanad-card-hover-overlay" aria-hidden="true"></div>
   </article>
  </li>
  @endforeach
 </ul>
</section>
@endif
@endsection
