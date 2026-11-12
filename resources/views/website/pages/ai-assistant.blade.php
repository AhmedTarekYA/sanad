@extends('website.layouts.app')

@section('page_key', 'ai-assistant.html')
@section('title', app()->getLocale() === 'ar' ? 'المساعد الذكي — SANAD CX AI' : 'AI Assistant — SANAD CX AI')
@section('meta_description', app()->getLocale() === 'ar' ? 'إضافة متصفح (Chrome Extension) ذكية تُدمج مباشرة فوق الواتساب ونظام الـ CRM لتزويد موظفيك بإجابات دقيقة وتقارير تحليلية لحظية.' : 'A smart browser extension (Chrome Extension) that integrates directly over WhatsApp and your CRM to provide your team with accurate answers and real-time analytical reports.')
@section('og_title', app()->getLocale() === 'ar' ? 'المساعد الذكي — SANAD CX AI' : 'AI Assistant — SANAD CX AI')
@section('og_description', app()->getLocale() === 'ar' ? 'المساعد الذكي (Sanad AI) — الذكاء الاصطناعي في خدمة فريقك.' : 'Double your sales speed and customer satisfaction with AI that works alongside your team moment by moment.')

@push('styles')
<link rel="stylesheet" href="{{ asset('website/assets/css/pages/ai-assistant.css') }}?v={{ @filemtime(public_path('website/assets/css/pages/ai-assistant.css')) ?: '2.0.1' }}">
@endpush

@section('content')
@php($isAr = app()->getLocale() === 'ar')
<div class="ai-page">
<section class="ai-hero" aria-labelledby="ai-hero-title">
<div class="ai-hero__in">
<p class="ai-badge">SANAD CX AI — {{ $isAr ? 'المساعد الذكي' : 'AI Assistant' }}</p>
<h1 id="ai-hero-title" class="ai-hero__title">{{ $isAr ? 'المساعد الذكي (Sanad AI) — الذكاء الاصطناعي في خدمة فريقك' : 'Sanad AI — Artificial intelligence at your team’s side' }}</h1>
<p class="ai-hero__lead">{{ $isAr ? 'إضافة متصفح (Chrome Extension) ذكية تُدمج مباشرة فوق الواتساب ونظام الـ CRM لتزويد موظفيك بإجابات دقيقة وتقارير تحليلية لحظية.' : 'A smart browser extension (Chrome Extension) that integrates directly over WhatsApp and your CRM to provide your team with accurate answers and real-time analytical reports.' }}</p>
<button type="button" class="ai-btn" data-consultation-open>{{ $isAr ? 'احجز استشارة مجانية' : 'Book a free consultation' }}</button>
<div class="ai-hcard ai-flow-node ai-hcard--1">
<svg viewBox="0 0 28 28" width="28" height="28" aria-hidden="true">
<rect x=".5" y=".5" width="27" height="27" rx="8" fill="rgba(30,64,175,.28)" stroke="rgba(45,113,240,.7)"/>
<path d="M8 14.5l4 4 8-8" fill="none" stroke="#f8f8f9" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<small>01 / {{ $isAr ? 'رسالة العميل' : 'Customer Message' }}</small>
<span>{{ $isAr ? 'محادثة العميل على WhatsApp Web' : 'Customer conversation on WhatsApp Web' }}</span>
</div>
<div class="ai-hcard ai-flow-node ai-hcard--2">
<svg viewBox="0 0 28 28" width="28" height="28" aria-hidden="true">
<rect x=".5" y=".5" width="27" height="27" rx="8" fill="rgba(30,64,175,.28)" stroke="rgba(45,113,240,.7)"/>
<path d="M8 14.5l4 4 8-8" fill="none" stroke="#f8f8f9" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<small>02 / {{ $isAr ? 'قاعدة المعرفة' : 'Knowledge Base' }}</small>
<span>{{ $isAr ? 'معلومات المنتجات والأسعار' : 'Product information and pricing' }}</span>
</div>
<div class="ai-hcard ai-flow-node ai-hcard--3">
<svg viewBox="0 0 28 28" width="28" height="28" aria-hidden="true">
<rect x=".5" y=".5" width="27" height="27" rx="8" fill="rgba(30,64,175,.28)" stroke="rgba(45,113,240,.7)"/>
<path d="M8 14.5l4 4 8-8" fill="none" stroke="#f8f8f9" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<small>03 / {{ $isAr ? 'اقتراح المساعد' : 'AI Suggestion' }}</small>
<span>{{ $isAr ? 'ردود دقيقة بجانب فريقك' : 'Accurate replies alongside your team' }}</span>
</div>
<div class="ai-art ai-dashboard-mockup" role="img" aria-label="{{ $isAr ? 'تصوّر توضيحي لمحرك SANAD AI' : 'Illustrative visualization of SANAD AI engine' }}">
<svg viewBox="0 0 424 327" width="424" height="327" aria-hidden="true" fill="none" overflow="visible">
<defs>
<filter id="aiBlur" x="-50%" y="-50%" width="200%" height="200%">
<feGaussianBlur stdDeviation="27.5"/>
</filter>
</defs>
<circle cx="212" cy="170" r="164" fill="#1e40af" fill-opacity=".18" filter="url(#aiBlur)"/>
<circle cx="212" cy="169" r="155" stroke="#30bd7d" stroke-opacity=".42" stroke-width="1.1" stroke-dasharray="3.3 7.7"/>
<circle cx="211.5" cy="169.5" r="125.5" fill="#0e1e30" stroke="#33cc91" stroke-opacity=".8" stroke-width="1.1"/>
<image href="{{ asset('website/assets/image/home/ai-orb.png') }}" width="424" height="327"/>
<path transform="translate(102 216.1)" d="M0 31.3C44-9.3 73.7 61 121 25.8S187-4.9 220 17M0 36.8C44-3.8 73.7 66.5 121 31.3S187 .5 220 22.5M0 42.3C44 1.6 73.7 72 121 36.8S187 6 220 28M0 47.8C44 7.1 73.7 77.5 121 42.3S187 11.5 220 33.5M0 53.3C44 12.6 73.7 83 121 47.8S187 17 220 39" stroke="#1fc98c" stroke-opacity=".65" stroke-width="1.1" stroke-dasharray="1.1 3.3"/>
</svg>
<span class="ai-art__name" dir="ltr">SANAD AI</span>
<span class="ai-tag ai-tag--l" style="left:16px;top:44px">
<i>
</i>
<b>{{ $isAr ? 'الردود' : 'Replies' }}</b>
</span>
<span class="ai-tag ai-tag--l" style="left:1px;top:130px">
<i>
</i>
<b>{{ $isAr ? 'المحادثات' : 'Chats' }}</b>
</span>
<span class="ai-tag ai-tag--l" style="left:16px;top:216px">
<i>
</i>
<b>{{ $isAr ? 'العملاء' : 'Customers' }}</b>
</span>
<span class="ai-tag ai-tag--r" style="left:315px;top:44px">
<i>
</i>
<b>{{ $isAr ? 'التحليلات' : 'Analytics' }}</b>
</span>
<span class="ai-tag ai-tag--r" style="left:331px;top:130px">
<i>
</i>
<b>{{ $isAr ? 'الأداء' : 'Performance' }}</b>
</span>
<span class="ai-tag ai-tag--r" style="left:315px;top:216px">
<i>
</i>
<b>{{ $isAr ? 'المبيعات' : 'Sales' }}</b>
</span>
</div>
<p class="ai-hero__cap">{{ $isAr ? 'تصوّر توضيحي لطريقة عمل المساعد' : 'Illustrative visualization of how the assistant works' }}</p>
</div>
</section>
<section class="ai-sec ai-eco ai-ecosystem" aria-labelledby="ai-eco-title">
<h2 id="ai-eco-title">{{ $isAr ? 'تتكامل بسلاسة مع الأنظمة التي تستخدمها يومياً' : 'Seamlessly integrates with the systems you use daily' }}</h2>
<div class="ai-eco__hub" dir="ltr">SANAD CX AI</div>
<svg class="ai-eco__streams" viewBox="0 0 1200 200" preserveAspectRatio="none" fill="none" aria-hidden="true">
<path class="data-stream-line" d="M110 190V70H600V0M354 190V70H600M598 150V0M842 190V70H600M1086 150V70H600" />
</svg>
<div class="ai-eco__node ai-eco__node--0" dir="ltr">WhatsApp Web</div>
<div class="ai-eco__node ai-eco__node--1" dir="ltr">Zoho CRM</div>
<div class="ai-eco__node ai-eco__node--2" dir="ltr">HubSpot</div>
<div class="ai-eco__node ai-eco__node--3" dir="ltr">Salesforce</div>
<div class="ai-eco__node ai-eco__node--4" dir="ltr">Zendesk</div>
</section>
<section class="ai-sec ai-shift" aria-labelledby="ai-shift-title">
<h2 id="ai-shift-title">{{ $isAr ? 'الفارق الذي تحدثه إضافة Sanad CX AI في عملياتك:' : 'The difference Sanad CX AI makes in your operations:' }}</h2>
@if($isAr)
<article class="ai-canvas ai-canvas--before ai-shift__card">
<h3>قبل استخدام Sanad CX AI</h3>
<p class="ai-canvas__q chat-incoming">هل يمكن توضيح تفاصيل الخدمة؟</p>
<p class="ai-canvas__a ai-reply-text">جارٍ مراجعة المعلومات…</p>
<ul>
<li>بطء في الرد وتأخر في إغلاق الصفقات</li>
<li>تباين جودة الأداء واختلاف إجابات الموظفين</li>
<li>صعوبة معرفة مدى رضا العميل أثناء الشات</li>
<li>غياب التحليلات الدقيقة عن أسباب ضياع الفرص</li>
</ul>
<small>مثال توضيحي</small>
</article>
<article class="ai-canvas ai-canvas--after ai-shift__card ai-shift__card--after">
<h3>بعد استخدام Sanad CX AI</h3>
<p class="ai-canvas__q chat-incoming">هل يمكن توضيح تفاصيل الخدمة؟</p>
<p class="ai-canvas__a ai-reply-text">يمكنك الاطلاع على تفاصيل الخدمة والأسعار من قاعدة المعرفة.</p><span class="ai-copilot-badge">اقتراح فوري · Sanad AI</span>
<ul>
<li>ردود مقترحة عالية الدقة خلال ثوانٍ معدودة</li>
<li>توحيد لغة الخطاب والتزام تام بقواعد الشركة</li>
<li>كشف تلقائي لنبرة ومشاعر العميل (Sentiment)</li>
<li>داشبورد متكاملة توضح أبرز اعتراضات العملاء وأداء الفريق</li>
</ul>
<small>مثال توضيحي</small>
</article>
@else
<article class="ai-canvas ai-canvas--before ai-shift__card">
<h3>Before Sanad CX AI</h3>
<p class="ai-canvas__q chat-incoming">Can you clarify the service details?</p>
<p class="ai-canvas__a ai-reply-text">Reviewing information…</p>
<ul>
<li>Slow responses and delayed deal closing</li>
<li>Inconsistent performance and varying agent answers</li>
<li>Difficulty knowing customer satisfaction during chat</li>
<li>Lack of precise analytics on why opportunities are lost</li>
</ul>
<small>Illustrative example</small>
</article>
<article class="ai-canvas ai-canvas--after ai-shift__card ai-shift__card--after">
<h3>After Sanad CX AI</h3>
<p class="ai-canvas__q chat-incoming">Can you clarify the service details?</p>
<p class="ai-canvas__a ai-reply-text">Here are the service details and prices from your knowledge base.</p>
<span class="ai-copilot-badge">Instant suggestion ? Sanad AI</span>
<ul>
<li>Highly accurate suggested replies within seconds</li>
<li>Unified communication language and full compliance with company policies</li>
<li>Automatic detection of customer tone and sentiment</li>
<li>Integrated dashboard showing top customer objections and team performance</li>
</ul>
<small>Illustrative example</small>
</article>
@endif
</section>
<section class="ai-sec ai-steps ai-walkthrough" aria-labelledby="ai-steps-title">
    <h2 id="ai-steps-title">{{ $isAr ? 'فعّل مساعد فريقك في أربع مراحل' : 'Activate your co-pilot in four stages' }}</h2>
    <div class="ai-walkthrough__steps" role="group" aria-label="{{ $isAr ? 'مراحل عمل المساعد' : 'Co-pilot stages' }}">
        <article class="ai-step ai-walkthrough__step is-active">
            <button type="button" data-copilot-step="0" aria-pressed="true" aria-controls="copilot-stage-0">
<span class="ai-step__number">01</span>
<h3>{{ $isAr ? 'فهم اللهجة' : 'Understand the dialect' }}</h3>
</button>
            <p>{{ $isAr ? 'يفهم سياق المحادثة ولهجة العميل.' : 'Understand the conversation context and customer dialect.' }}</p>
        </article>
        <article class="ai-step ai-walkthrough__step">
            <button type="button" data-copilot-step="1" aria-pressed="false" aria-controls="copilot-stage-1">
<span class="ai-step__number">02</span>
<h3>{{ $isAr ? 'اقتراح الرد' : 'Suggest a reply' }}</h3>
</button>
            <p>{{ $isAr ? 'يقترح إجابة من قاعدة المعرفة ليراجعها الموظف.' : 'Suggest an answer from your knowledge base for the agent to review.' }}</p>
        </article>
        <article class="ai-step ai-walkthrough__step">
            <button type="button" data-copilot-step="2" aria-pressed="false" aria-controls="copilot-stage-2">
<span class="ai-step__number">03</span>
<h3>{{ $isAr ? 'أتمتة الإجراء' : 'Automate the action' }}</h3>
</button>
            <p>{{ $isAr ? 'يساعد الموظف في تنفيذ الإجراء المناسب.' : 'Help the agent carry out the appropriate action.' }}</p>
        </article>
        <article class="ai-step ai-walkthrough__step">
            <button type="button" data-copilot-step="3" aria-pressed="false" aria-controls="copilot-stage-3">
<span class="ai-step__number">04</span>
<h3>{{ $isAr ? 'تحديث الـ CRM' : 'Update the CRM' }}</h3>
</button>
            <p>{{ $isAr ? 'يلخص المحادثة ويجهز تحديث سجل العميل.' : 'Summarize the conversation and prepare the customer record update.' }}</p>
        </article>
    </div>
    <p class="ai-steps__label">{{ $isAr ? 'معاينة توضيحية للمساعد داخل المحادثة' : 'An illustrative co-pilot conversation' }}</p>
    <div class="ai-demo copilot-visual">
        <div class="ai-demo__toolbar">
<span dir="ltr">SANAD CX / AI</span>
<span>{{ $isAr ? 'مثال توضيحي' : 'Illustrative example' }}</span>
</div>
        <h3 data-copilot-caption>{{ $isAr ? 'فهم اللهجة' : 'Understand the dialect' }}</h3>
        <div class="copilot-stage">
            <section class="copilot-extension" id="copilot-stage-0" aria-label="{{ $isAr ? 'فهم اللهجة' : 'Understand the dialect' }}">
                <span class="ai-demo__logo" aria-hidden="true">AI</span>
                <p class="copilot-extension__label" dir="ltr">SANAD CX AI / 01</p>
                <p>{{ $isAr ? 'متى يوصل طلبي؟' : 'When will my order arrive?' }}</p>
            </section>
            <section class="copilot-extension" id="copilot-stage-1" aria-label="{{ $isAr ? 'اقتراح الرد' : 'Suggest a reply' }}" hidden>
                <span class="ai-demo__logo" aria-hidden="true">AI</span>
                <p class="copilot-extension__label" dir="ltr">SANAD CX AI / 02</p>
                <p>{{ $isAr ? 'طلبك قيد الشحن. إليك رابط تتبع الشحنة.' : 'Your order is on its way. Here is your tracking link.' }}</p>
            </section>
            <section class="copilot-extension" id="copilot-stage-2" aria-label="{{ $isAr ? 'أتمتة الإجراء' : 'Automate the action' }}" hidden>
                <span class="ai-demo__logo" aria-hidden="true">AI</span>
                <p class="copilot-extension__label" dir="ltr">SANAD CX AI / 03</p>
                <p>{{ $isAr ? 'الإجراء المقترح: إرسال رابط التتبع.' : 'Suggested action: send the tracking link.' }}</p>
            </section>
            <section class="copilot-extension" id="copilot-stage-3" aria-label="{{ $isAr ? 'تحديث الـ CRM' : 'Update the CRM' }}" hidden>
                <span class="ai-demo__logo" aria-hidden="true">AI</span>
                <p class="copilot-extension__label" dir="ltr">SANAD CX AI / 04</p>
                <p>{{ $isAr ? 'ملخص جاهز للمراجعة: استفسار عن الشحن، تمت مشاركة رابط التتبع.' : 'Ready for review: shipping inquiry, tracking link shared.' }}</p>
            </section>
        </div>
        <div class="ai-demo__prog" aria-hidden="true">
<i class="is-active">
</i>
<i>
</i>
<i>
</i>
<i>
</i>
</div>
        <span class="ai-demo__n" dir="ltr" data-copilot-number>01 / 04</span>
    </div>
    <button type="button" class="ai-btn ai-steps__btn" data-consultation-open>{{ $isAr ? 'احجز استشارة مجانية' : 'Book a free consultation' }}</button>
</section>

<section class="ai-sec ai-ops" aria-labelledby="ai-ops-title">
<h2 id="ai-ops-title">{{ $isAr ? 'تحكّم كامل ورؤية شاملة لمدراء الكول سنتر والمبيعات:' : 'Full control and comprehensive visibility for call center and sales managers:' }}</h2>
<article class="ai-box ai-kpi">
<h3>{{ $isAr ? 'مؤشرات الأداء اللحظية' : 'Real-Time Performance Indicators' }} (Agent KPIs)</h3>
<p>{{ $isAr ? 'متابعة سرعة الرد ونسبة التزام الموظف باقتراحات الذكاء الاصطناعي.' : 'Track response speed and agent compliance rate with AI suggestions.' }}</p>
<div class="ai-kpi__chart" aria-hidden="true">
<span style="top:270px">
</span>
<span style="top:334px">
</span>
<span style="top:398px">
</span>
<span style="top:462px">
</span>
<span style="top:526px">
</span>
<i class="telemetry-bar " style="height:72px;--i:0">
</i>
<i class="telemetry-bar " style="height:94px;--i:1">
</i>
<i class="telemetry-bar " style="height:68px;--i:2">
</i>
<i class="telemetry-bar " style="height:130px;--i:3">
</i>
<i class="telemetry-bar " style="height:118px;--i:4">
</i>
<i class="telemetry-bar " style="height:160px;--i:5">
</i>
<i class="telemetry-bar " style="height:145px;--i:6">
</i>
<i class="telemetry-bar " style="height:205px;--i:7">
</i>
<i class="telemetry-bar " style="height:184px;--i:8">
</i>
<i class="telemetry-bar g" style="height:240px;--i:9">
</i>
<i class="telemetry-bar g" style="height:218px;--i:10">
</i>
<i class="telemetry-bar g" style="height:272px;--i:11">
</i>
</div>
<small>{{ $isAr ? 'تصوّر توضيحي للتحليلات' : 'Illustrative analytics visualization' }}</small>
</article>
<article class="ai-box ai-sent">
<h3>{{ $isAr ? 'تحليل المشاعر العامة' : 'Overall Sentiment Analysis' }}</h3>
<p>{{ $isAr ? 'إحصائيات دقيقة لنسبة العملاء السعداء مقابل الغاضبين.' : 'Precise statistics on the ratio of happy versus frustrated customers.' }}</p>
<div class="ai-sent__bar" aria-hidden="true">
<i>
</i>
</div>
<div class="ai-sent__leg">
<span>
<i class="g">
</i>{{ $isAr ? 'سعداء' : 'Happy' }}</span>
<span>
<i>
</i>{{ $isAr ? 'غاضبون' : 'Frustrated' }}</span>
</div>
</article>
<article class="ai-box ai-obj">
<h3>{{ $isAr ? 'تقرير الاعتراضات الشائعة' : 'Top Objections Report' }} (Top Objections)</h3>
<p>{{ $isAr ? 'معرفة الأسباب الحقيقية لتردد العملاء (السعر، الشحن، التوصيل) لتطوير خطتك التسويقية.' : 'Discover the real reasons behind customer hesitation (price, shipping, delivery) to improve your marketing strategy.' }}</p>
<div class="ai-obj__l" aria-hidden="true">
<i>
</i>
<i>
</i>
<i>
</i>
</div>
</article>
</section>
<section class="ai-sec ai-plans ai-pricing-section" aria-labelledby="ai-plans-title">
<h2 id="ai-plans-title">{{ $isAr ? 'باقات مرنة تناسب حجم فريقك:' : 'Flexible plans that fit your team size:' }}</h2>
<div class="ai-panel">
<article class="ai-plan ai-pricing__card ai-plan--s">
<p class="ai-plan__price">$49 / {{ $isAr ? 'شهرياً' : 'month' }}</p>
<p class="ai-plan__annual">$490 / {{ $isAr ? 'سنوياً' : 'year' }}</p>
<h3 class="ai-plan__name" dir=ltr>Starter</h3>
<span class="ai-plan__rule">
</span>
<p class="ai-plan__sub">{{ $isAr ? 'حتى 3 موظفين' : 'Up to 3 agents' }}</p>
<p class="ai-plan__feat">{{ $isAr ? '3,000 اقتراح ذكي شهرياً' : '3,000 smart suggestions/month' }}</p>
<svg class="ai-ok" viewBox="0 0 20 20" width="20" height="20" aria-hidden="true">
<circle cx="10" cy="10" r="9.5" fill="none" stroke="currentColor" opacity=".35"/>
<path d="M6 10.4l2.8 2.8L14 7.8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<svg class="ai-ok" viewBox="0 0 20 20" width="20" height="20" aria-hidden="true">
<circle cx="10" cy="10" r="9.5" fill="none" stroke="currentColor" opacity=".35"/>
<path d="M6 10.4l2.8 2.8L14 7.8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<button type="button" class="ai-btn" data-consultation-open>{{ $isAr ? 'احجز استشارة مجانية' : 'Book a free consultation' }}</button>
</article>
<article class="ai-plan ai-pricing__card ai-pricing--featured ai-plan--p">
<span class="ai-plan__badge">{{ $isAr ? 'الأكثر طلباً' : 'Most Popular' }}</span>
<p class="ai-plan__price">$149 / {{ $isAr ? 'شهرياً' : 'month' }}</p>
<p class="ai-plan__annual">$1490 / {{ $isAr ? 'سنوياً' : 'year' }}</p>
<h3 class="ai-plan__name" dir=ltr>Pro</h3>
<span class="ai-plan__rule">
</span>
<p class="ai-plan__sub">{{ $isAr ? 'حتى 10 موظفين' : 'Up to 10 agents' }}</p>
<p class="ai-plan__feat">{{ $isAr ? '12,000 اقتراح ذكي شهرياً' : '12,000 smart suggestions/month' }}</p>
<svg class="ai-ok" viewBox="0 0 20 20" width="20" height="20" aria-hidden="true">
<circle cx="10" cy="10" r="9.5" fill="none" stroke="currentColor" opacity=".35"/>
<path d="M6 10.4l2.8 2.8L14 7.8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<svg class="ai-ok" viewBox="0 0 20 20" width="20" height="20" aria-hidden="true">
<circle cx="10" cy="10" r="9.5" fill="none" stroke="currentColor" opacity=".35"/>
<path d="M6 10.4l2.8 2.8L14 7.8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<button type="button" class="ai-btn" data-consultation-open>{{ $isAr ? 'احجز استشارة مجانية' : 'Book a free consultation' }}</button>
</article>
<article class="ai-plan ai-pricing__card ai-plan--b">
<p class="ai-plan__price">$349 / {{ $isAr ? 'شهرياً' : 'month' }}</p>
<p class="ai-plan__annual">$3490 / {{ $isAr ? 'سنوياً' : 'year' }}</p>
<h3 class="ai-plan__name">Business {{ $isAr ? '(الأكثر توفيراً)' : '(Best Value)' }}</h3>
<span class="ai-plan__rule">
</span>
<p class="ai-plan__sub">{{ $isAr ? 'حتى 25 موظف' : 'Up to 25 agents' }}</p>
<p class="ai-plan__feat">{{ $isAr ? '35,000 اقتراح ذكي شهرياً' : '35,000 smart suggestions/month' }}</p>
<svg class="ai-ok" viewBox="0 0 20 20" width="20" height="20" aria-hidden="true">
<circle cx="10" cy="10" r="9.5" fill="none" stroke="currentColor" opacity=".35"/>
<path d="M6 10.4l2.8 2.8L14 7.8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<svg class="ai-ok" viewBox="0 0 20 20" width="20" height="20" aria-hidden="true">
<circle cx="10" cy="10" r="9.5" fill="none" stroke="currentColor" opacity=".35"/>
<path d="M6 10.4l2.8 2.8L14 7.8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<button type="button" class="ai-btn" data-consultation-open>{{ $isAr ? 'احجز استشارة مجانية' : 'Book a free consultation' }}</button>
</article>
</div>
<p class="ai-plans__note">{{ $isAr ? 'هل تحتاج باقة خاصة لكول سنتر كبير؟' : 'Need a custom plan for a large call center?' }} <button type="button" data-consultation-open>{{ $isAr ? 'تواصل مع فريق المبيعات' : 'Contact the sales team' }}</button>
</p>
</section>
<section class="ai-sec ai-faq" id="faq" aria-labelledby="ai-faq-title">
<h2 id="ai-faq-title">{{ $isAr ? 'الأسئلة الشائعة' : 'Frequently Asked Questions' }}</h2>
<div class="ai-faq__list">
@if($isAr)
<details class="ai-faq__row">
<summary>هل أحتاج لمطورين لتثبيت الأداة؟</summary>
<p>لا، التثبيت يتم بنقرة زر واحدة من متجر كروم ويتم الإعداد خلال دقائق.</p>
</details>
<details class="ai-faq__row">
<summary>هل تعمل الأداة مع اللهجة المحلية ؟</summary>
<p>نعم، تم تدريب النموذج على فهم مختلف اللهجات العربية واللغة الإنجليزية بدقة عالية.</p>
</details>
<details class="ai-faq__row">
<summary>هل بيانات محادثاتنا آمنة؟</summary>
<p>نلتزم بأعلى معايير التشفير والخصوصية، ولا يتم مشاركة بيانات عملائك مع أي طرف ثالث.</p>
</details>
@else
<details class="ai-faq__row">
<summary>Do I need developers to install the tool?</summary>
<p>No, installation is done with a single click from the Chrome Web Store and setup takes just minutes.</p>
</details>
<details class="ai-faq__row">
<summary>Does the tool work with local dialects?</summary>
<p>Yes, the model has been trained to understand various Arabic dialects and English with high accuracy.</p>
</details>
<details class="ai-faq__row">
<summary>Is our conversation data secure?</summary>
<p>We adhere to the highest standards of encryption and privacy, and your customer data is never shared with any third party.</p>
</details>
@endif
</div>
</section>
<section class="ai-final" aria-labelledby="ai-final-title">
<h2 id="ai-final-title">SANAD CX AI — {{ $isAr ? 'المساعد الذكي' : 'AI Assistant' }}</h2>
<button type="button" class="ai-btn" data-consultation-open>{{ $isAr ? 'احجز استشارة مجانية' : 'Book a free consultation' }}</button>
</section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('.ai-walkthrough');
    if (!section) return;
    const controls = [...section.querySelectorAll('[data-copilot-step]')];
    const stages = [...section.querySelectorAll('.copilot-extension')];
    const select = index => {
        controls.forEach((control, position) => {
            control.setAttribute('aria-pressed', String(position === index));
            control.closest('.ai-step').classList.toggle('is-active', position === index);
            stages[position].hidden = position !== index;
        });
        section.querySelector('[data-copilot-caption]').textContent = controls[index].querySelector('h3').textContent;
        section.querySelector('[data-copilot-number]').textContent = `0${index + 1} / 04`;
        section.querySelectorAll('.ai-demo__prog i').forEach((dot, position) => dot.classList.toggle('is-active', position === index));
    };
    controls.forEach((control, index) => control.addEventListener('click', () => select(index)));
    section.addEventListener('sanad:copilot-stage', event => select(event.detail));
});
</script>
@endpush
