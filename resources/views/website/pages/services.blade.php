@extends('website.layouts.app')

@section('page_key', 'services.html')
@section('title', 'خدماتنا — SANAD CX')
@section('meta_description', 'نقدم خدمات تعهيد احترافية لتغطية المكالمات، المحادثات الفورية، والمبيعات بالتشغيل المباشر (Plug &amp; Play) على أنظمتك الحالية فوراً ودون أي رسوم تأسيس.')
@section('og_title', 'خدماتنا — SANAD CX')
@section('og_description', 'نقدم خدمات تعهيد احترافية لتغطية المكالمات، المحادثات الفورية، والمبيعات بالتشغيل المباشر (Plug &amp; Play) على أنظمتك الحالية فوراً ودون أي رسوم تأسيس.')

@push('styles')
<link rel="stylesheet" href="{{ asset('website/assets/css/pages/services.css') }}?v={{ filemtime(public_path('website/assets/css/pages/services.css')) }}">
@endpush

@section('content')
<section class="sanad-services-hero" aria-labelledby="sanad-services-hero-heading">
<div class="sanad-services-hero__content">
<div class="sanad-services-hero__message">
<p class="sanad-services-hero__badge">MANAGED CX &amp; SALES OPERATIONS — حلول تشغيلية متكاملة</p>
<h1 class="sanad-services-hero__headline" id="sanad-services-hero-heading">حلول تشغيلية متكاملة لنمو أعمالك</h1>
<p class="sanad-services-hero__description">نحن لا نُدير المحادثات والاتصالات فحسب؛ نحن نتحكم في شريان التواصل والمبيعات لشركتك عبر كوادر بشرية مُدرّبة، حلول تكنولوجيا ذكية، ونظام تشغيل سلس يبدأ خلال 48 ساعة على أنظمتك المباشرة.</p>
</div>
<div class="sanad-services-hero__actions">
<button type="button" class="sanad-btn sanad-services-hero__cta" data-consultation-open>استكشف الحل المناسب لشركتك</button>
<button type="button" class="sanad-btn sanad-btn--outline sanad-services-hero__cta-outline" data-consultation-open>احسب حزمتك المناسبة</button>
</div>
</div>
<div class="sanad-services-hero__panel">
<div class="sanad-services-hero__brand" dir="ltr">
<div class="sanad-services-hero__brand-text">
<p class="sanad-services-hero__brand-word">
<span class="sanad-services-hero__brand-sanad">SANAD</span>
<span class="sanad-services-hero__brand-cx">CX</span>
</p>
<p class="sanad-services-hero__brand-tagline">GROWTH PARTNER</p>
</div>
<span class="sanad-services-hero__brand-mark">
<img class="sanad-services-hero__brand-mark-image" src="{{ asset('website/assets/image/svg/brand-mark-figma.svg') }}" alt="" width="81.4546" height="96" decoding="async">
</span>
</div>
<p class="sanad-services-hero__count">4 خدمات تشغيلية متكاملة</p>
<ul class="sanad-services-hero__tiles">
<li class="sanad-services-hero__tile">
<img class="sanad-services-hero__tile-icon" src="{{ asset('website/assets/image/svg/voiceOperationsIcon_28x28.svg') }}" alt="" width="28" height="28" decoding="async">
<span class="sanad-services-hero__tile-label">الاتصالات الصوتية</span>
</li>
<li class="sanad-services-hero__tile">
<img class="sanad-services-hero__tile-icon" src="{{ asset('website/assets/image/svg/whatsappChatIcon_28x28.svg') }}" alt="" width="28" height="28" decoding="async">
<span class="sanad-services-hero__tile-label">الواتساب والمحادثات</span>
</li>
<li class="sanad-services-hero__tile">
<img class="sanad-services-hero__tile-icon" src="{{ asset('website/assets/image/svg/telesalesIcon_28x28.svg') }}" alt="" width="28" height="28" decoding="async">
<span class="sanad-services-hero__tile-label">المبيعات وإغلاق الصفقات</span>
</li>
<li class="sanad-services-hero__tile">
<img class="sanad-services-hero__tile-icon" src="{{ asset('website/assets/image/svg/cxQualityIcon_28x28.svg') }}" alt="" width="28" height="28" decoding="async">
<span class="sanad-services-hero__tile-label">الجودة وتحليلات CX</span>
</li>
</ul>
</div>
</section>
<section class="sanad-services-detail" data-node-id="150:20097" id="sanad-detailed-services" aria-labelledby="sanad-services-detail-heading">
<div class="sanad-services-detail__header" data-node-id="150:20098">
<p class="sanad-services-detail__eyebrow" data-node-id="150:20099">OUR SERVICES — خدماتنا التفصيلية</p>
<h2 class="sanad-services-detail__heading" data-node-id="150:20100" id="sanad-services-detail-heading">أربع خدمات تشغيلية متكاملة على أنظمتك الحالية</h2>
</div>
<div class="sanad-services-detail__progress" aria-hidden="true"></div>
<article class="sanad-services-detail__card sanad-card-hoverable" data-node-id="150:20104" id="sanad-service-voice-operations" aria-labelledby="sanad-service-voice-operations-title">
<div class="sanad-services-detail__content" data-node-id="150:20105">
<div class="sanad-services-detail__meta" data-node-id="150:20107">
<span class="sanad-services-detail__icon" data-node-id="150:20109">
<img class="sanad-services-detail__icon-image sanad-services-detail__icon-image--light" data-node-id="150:20110" src="{{ asset('website/assets/image/svg/voiceOperationsIcon_32x32_srv-light.svg') }}" alt="" width="32" height="32" decoding="async">
<img class="sanad-services-detail__icon-image sanad-services-detail__icon-image--dark" src="{{ asset('website/assets/image/svg/voiceOperationsIcon_32x32_srv-dark.svg') }}" alt="" width="32" height="32" decoding="async">
</span>
<span class="sanad-services-detail__number" dir="ltr" data-node-id="150:20108">01</span>
</div>
<p class="sanad-services-detail__english" dir="ltr" data-node-id="150:20112">Voice &amp; Voice Operations</p>
<h3 class="sanad-services-detail__title" data-node-id="150:20113" id="sanad-service-voice-operations-title">إدارة الاتصالات الواردة والصادرة</h3>
<p class="sanad-services-detail__subtitle" data-node-id="150:20114">المشكلة التي نحلها: ضياع المكالمات الواردة وانخفاض الثقة بسبب غياب الرد الاحترافي السريع.</p>
<span class="sanad-services-detail__divider" data-node-id="150:20115" aria-hidden="true">
</span>
<ul class="sanad-services-detail__details" data-node-id="150:20116">
<li class="sanad-services-detail__detail" data-node-id="150:20117">
<img class="sanad-services-detail__check" data-node-id="150:20119" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20118">الرد الفوري على المكالمات الواردة بمتوسط استجابة أقل من 60 ثانية.</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20121">
<img class="sanad-services-detail__check" data-node-id="150:20123" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20122">تقديم الدعم الفني، معالجة الشكاوى والاستفسارات بأسلوب استشاري راقٍ.</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20125">
<img class="sanad-services-detail__check" data-node-id="150:20127" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20126">إجراء مكالمات التأكيد، الاستبيانات، والمتابعة الهاتفية مع العملاء.</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20129">
<img class="sanad-services-detail__check" data-node-id="150:20131" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20130">تغطية مرنة <bdi dir="ltr">24/7</bdi> لضمان عدم ضياع أي مكالمة أو فرصة بيعية.</span>
</li>
</ul>
</div>
<div class="sanad-services-detail__panel" data-node-id="150:20106">
<p class="sanad-services-detail__panel-label" data-node-id="150:20133">الأنظمة المتوافقة</p>
<h4 class="sanad-services-detail__panel-title" data-node-id="150:20134">السنترالات السحابية الخاصة بالعميل</h4>
<ul class="sanad-services-detail__tags" data-node-id="150:20135">
<li class="sanad-services-detail__tag" data-node-id="150:20136">
<span dir="ltr" data-node-id="150:20137">Cloud PBX</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20138">
<span dir="ltr" data-node-id="150:20139">Avaya</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20140">
<span dir="ltr" data-node-id="150:20141">Cisco</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20142">
<span dir="ltr" data-node-id="150:20143">Talkdesk</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20144">
<span data-node-id="150:20145">وغيرها</span>
</li>
</ul>
</div>
<div class="sanad-card-hover-overlay" aria-hidden="true">
</div>
</article>
<article class="sanad-services-detail__card sanad-card-hoverable" data-node-id="150:20146" id="sanad-service-whatsapp-chat" aria-labelledby="sanad-service-whatsapp-chat-title">
<div class="sanad-services-detail__panel" data-node-id="150:20148">
<p class="sanad-services-detail__panel-label" data-node-id="150:20176">الأنظمة المتوافقة</p>
<h4 class="sanad-services-detail__panel-title" data-node-id="150:20177">منصات المحادثات والمتاجر</h4>
<ul class="sanad-services-detail__tags" data-node-id="150:20178">
<li class="sanad-services-detail__tag" data-node-id="150:20179">
<span dir="ltr" data-node-id="150:20180">WhatsApp Business API</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20181">
<span dir="ltr" data-node-id="150:20182">Zendesk</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20183">
<span dir="ltr" data-node-id="150:20184">Freshchat</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20185">
<span dir="ltr" data-node-id="150:20186">Crisp</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20187">
<span dir="ltr" data-node-id="150:20188">Salla</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20189">
<span dir="ltr" data-node-id="150:20190">Zid</span>
</li>
</ul>
</div>
<div class="sanad-services-detail__content" data-node-id="150:20147">
<div class="sanad-services-detail__meta" data-node-id="150:20149">
<span class="sanad-services-detail__icon" data-node-id="150:20151">
<img class="sanad-services-detail__icon-image sanad-services-detail__icon-image--light" data-node-id="150:20152" src="{{ asset('website/assets/image/svg/whatsappChatIcon_32x32_srv-light.svg') }}" alt="" width="32" height="32" decoding="async">
<img class="sanad-services-detail__icon-image sanad-services-detail__icon-image--dark" src="{{ asset('website/assets/image/svg/whatsappChatIcon_32x32_srv-dark.svg') }}" alt="" width="32" height="32" decoding="async">
</span>
<span class="sanad-services-detail__number" dir="ltr" data-node-id="150:20150">02</span>
</div>
<p class="sanad-services-detail__english" dir="ltr" data-node-id="150:20155">WhatsApp &amp; Chat CX</p>
<h3 class="sanad-services-detail__title" data-node-id="150:20156" id="sanad-service-whatsapp-chat-title">إدارة محادثات الواتساب والمتاجر الإلكترونية</h3>
<p class="sanad-services-detail__subtitle" data-node-id="150:20157">المشكلة التي نحلها: تراكم الرسائل في المواسم وضغط الحملات الإعلانية مما يؤدي لخسارة عملاء جادين وسلات متروكة.</p>
<span class="sanad-services-detail__divider" data-node-id="150:20158" aria-hidden="true">
</span>
<ul class="sanad-services-detail__details" data-node-id="150:20159">
<li class="sanad-services-detail__detail" data-node-id="150:20160">
<img class="sanad-services-detail__check" data-node-id="150:20162" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20161">إدارة حسابات الواتساب والتجارة الإلكترونية واللايف شات على موقعك.</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20164">
<img class="sanad-services-detail__check" data-node-id="150:20166" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20165">تأكيد الطلبات، تتبع الشحنات، وحجز المواعيد بشكل لحظي.</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20168">
<img class="sanad-services-detail__check" data-node-id="150:20170" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20169">الرد على الاستفسارات المعقدة وسيناريوهات الأسئلة الشائعة (FAQs) بدعم من المساعد الذكي (Sanad AI).</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20172">
<img class="sanad-services-detail__check" data-node-id="150:20174" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20173">الحفاظ على نبرة صوت موحدة وتفاعلية تعزز ارتباط العملاء بالبراند.</span>
</li>
</ul>
</div>
<div class="sanad-card-hover-overlay" aria-hidden="true">
</div>
</article>
<article class="sanad-services-detail__card sanad-card-hoverable" data-node-id="150:20191" id="sanad-service-telesales-conversion" aria-labelledby="sanad-service-telesales-conversion-title">
<div class="sanad-services-detail__content" data-node-id="150:20192">
<div class="sanad-services-detail__meta" data-node-id="150:20194">
<span class="sanad-services-detail__icon" data-node-id="150:20196">
<img class="sanad-services-detail__icon-image sanad-services-detail__icon-image--light" data-node-id="150:20197" src="{{ asset('website/assets/image/svg/telesalesConversionIcon_32x32_srv-light.svg') }}" alt="" width="32" height="32" decoding="async">
<img class="sanad-services-detail__icon-image sanad-services-detail__icon-image--dark" src="{{ asset('website/assets/image/svg/telesalesConversionIcon_32x32_srv-dark.svg') }}" alt="" width="32" height="32" decoding="async">
</span>
<span class="sanad-services-detail__number" dir="ltr" data-node-id="150:20195">03</span>
</div>
<p class="sanad-services-detail__english" dir="ltr" data-node-id="150:20199">Telesales &amp; Conversion</p>
<h3 class="sanad-services-detail__title" data-node-id="150:20200" id="sanad-service-telesales-conversion-title">المبيعات وإغلاق الصفقات</h3>
<p class="sanad-services-detail__subtitle" data-node-id="150:20201">المشكلة التي نحلها: ضياع العملاء المحتملين (Leads) القادمين من الحملات بسبب تأخر المتابعة أو غياب مهارات الإغلاق.</p>
<span class="sanad-services-detail__divider" data-node-id="150:20202" aria-hidden="true">
</span>
<ul class="sanad-services-detail__details" data-node-id="150:20203">
<li class="sanad-services-detail__detail" data-node-id="150:20204">
<img class="sanad-services-detail__check" data-node-id="150:20206" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20205">المتابعة السريعة مع العملاء المحتملين القادمين من الحملات الإعلانية.</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20208">
<img class="sanad-services-detail__check" data-node-id="150:20210" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20209">إغلاق الصفقات (<bdi dir="ltr">Closing</bdi>) المباشر ورفع متوسط قيمة السلة (<bdi dir="ltr">Upselling &amp; Cross-selling</bdi>).</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20212">
<img class="sanad-services-detail__check" data-node-id="150:20214" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20213">إعادة تنشيط العملاء السابقين والسلات المتروكة (<bdi dir="ltr">Abandoned Carts</bdi>).</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20216">
<img class="sanad-services-detail__check" data-node-id="150:20218" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20217">النتيجة المباشرة لعملك: رفع معدل تحويل المبيعات (Conversion Rate) بمتوسط يصل إلى +35%.</span>
</li>
</ul>
</div>
<div class="sanad-services-detail__panel" data-node-id="150:20193">
<p class="sanad-services-detail__panel-label" data-node-id="150:20220">الأنظمة المتوافقة</p>
<h4 class="sanad-services-detail__panel-title" data-node-id="150:20221">أنظمة إدارة علاقات العملاء الخاصة بك</h4>
<ul class="sanad-services-detail__tags" data-node-id="150:20222">
<li class="sanad-services-detail__tag" data-node-id="150:20223">
<span dir="ltr" data-node-id="150:20224">HubSpot</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20225">
<span dir="ltr" data-node-id="150:20226">Zoho</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20227">
<span dir="ltr" data-node-id="150:20228">Salesforce</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20229">
<span dir="ltr" data-node-id="150:20230">Custom CRM</span>
</li>
</ul>
</div>
<div class="sanad-card-hover-overlay" aria-hidden="true">
</div>
</article>
<article class="sanad-services-detail__card sanad-card-hoverable" data-node-id="150:20231" id="sanad-service-cx-quality" aria-labelledby="sanad-service-cx-quality-title">
<div class="sanad-services-detail__panel" data-node-id="150:20233">
<p class="sanad-services-detail__panel-label" data-node-id="150:20261">مؤشرات نقيسها</p>
<h4 class="sanad-services-detail__panel-title" data-node-id="150:20262">معايير الجودة ورضا العملاء</h4>
<ul class="sanad-services-detail__tags" data-node-id="150:20263">
<li class="sanad-services-detail__tag" data-node-id="150:20264">
<span dir="ltr" data-node-id="150:20265">QA 95%+</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20266">
<span dir="ltr" data-node-id="150:20267">CSAT</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20268">
<span dir="ltr" data-node-id="150:20269">NPS</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20270">
<span dir="ltr" data-node-id="150:20271">FCR</span>
</li>
<li class="sanad-services-detail__tag" data-node-id="150:20272">
<span data-node-id="150:20273">تقارير أسبوعية</span>
</li>
</ul>
</div>
<div class="sanad-services-detail__content" data-node-id="150:20232">
<div class="sanad-services-detail__meta" data-node-id="150:20234">
<span class="sanad-services-detail__icon" data-node-id="150:20236">
<img class="sanad-services-detail__icon-image sanad-services-detail__icon-image--light" data-node-id="150:20237" src="{{ asset('website/assets/image/svg/cxQualityAnalyticsIcon_32x32_srv-light.svg') }}" alt="" width="32" height="32" decoding="async">
<img class="sanad-services-detail__icon-image sanad-services-detail__icon-image--dark" src="{{ asset('website/assets/image/svg/cxQualityAnalyticsIcon_32x32_srv-dark.svg') }}" alt="" width="32" height="32" decoding="async">
</span>
<span class="sanad-services-detail__number" dir="ltr" data-node-id="150:20235">04</span>
</div>
<p class="sanad-services-detail__english" dir="ltr" data-node-id="150:20240">Reservations &amp; Quality Assurance</p>
<h3 class="sanad-services-detail__title" data-node-id="150:20241" id="sanad-service-cx-quality-title">الرعاية الصحية، الحجوزات، وجهود الجودة</h3>
<p class="sanad-services-detail__subtitle" data-node-id="150:20242">المشكلة التي نحلها: صعوبة تنظيم المواعيد في القطاعات الخدمية وضياع فرص ولاء العملاء (LTV).</p>
<span class="sanad-services-detail__divider" data-node-id="150:20243" aria-hidden="true">
</span>
<ul class="sanad-services-detail__details" data-node-id="150:20244">
<li class="sanad-services-detail__detail" data-node-id="150:20245">
<img class="sanad-services-detail__check" data-node-id="150:20247" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20246">تقييم جودة المكالمات والمحادثات دورياً طبقاً لمعايير (<bdi dir="ltr">Quality Assurance</bdi>).</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20249">
<img class="sanad-services-detail__check" data-node-id="150:20251" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20250">قياس وتقييم مؤشرات رضا العملاء (<bdi dir="ltr">CSAT, NPS, FCR</bdi>).</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20253">
<img class="sanad-services-detail__check" data-node-id="150:20255" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20254">تقديم تقارير تفصيلية وأسبوعية تبرز فرص التحسين ونقاط القوة.</span>
</li>
<li class="sanad-services-detail__detail" data-node-id="150:20257">
<img class="sanad-services-detail__check" data-node-id="150:20259" src="{{ asset('website/assets/image/svg/includedFeatureCheckIcon_24x24.svg') }}" alt="" width="24" height="24" decoding="async">
<span class="sanad-services-detail__detail-text" data-node-id="150:20258">حماية سمعة العلامة التجارية ومنع تكرار الأخطاء التشغيلية.</span>
</li>
</ul>
</div>
<div class="sanad-card-hover-overlay" aria-hidden="true">
</div>
</article>
</section>
<section class="sanad-differ" id="how-we-differ" data-gsap-section="services-differ" data-node-id="349:5604" aria-labelledby="sanad-differ-title">
<div class="sanad-differ__container">
   <h2 class="sanad-differ__title" id="sanad-differ-title">كيف تميزنا حلول سند CX؟</h2>
   <div class="sanad-differ__grid">
       <article class="sanad-differ__card differ-card sanad-card-hoverable">
           <img class="sanad-differ__icon sanad-differ__icon--light" src="{{ asset('website/assets/image/svg/reliabilityValueIcon_36x36_about-light.svg') }}" width="36" height="36" alt="" loading="lazy">
<img class="sanad-differ__icon sanad-differ__icon--dark" src="{{ asset('website/assets/image/svg/reliabilityValueIcon_36x36_about-dark.svg') }}" width="36" height="36" alt="" loading="lazy">
<span class="sanad-differ__badge" lang="en" dir="ltr">Plug &amp; Play</span>
           <h3 class="sanad-differ__card-title">تشغيل بأسلوب Plug &amp; Play</h3>
           <p class="sanad-differ__card-desc">لا نطلب منك تغيير السنترال أو شراء سيرفرات؛ نعمل مباشرة عبر حسابات مستخدمين (Users) على أنظمتك الحالية.</p>
       </article>
       <article class="sanad-differ__card differ-card sanad-card-hoverable">
           <img class="sanad-differ__icon sanad-differ__icon--light" src="{{ asset('website/assets/image/svg/plugAndPlayIntegrationValueIcon_36x36_about-light.svg') }}" width="36" height="36" alt="" loading="lazy">
<img class="sanad-differ__icon sanad-differ__icon--dark" src="{{ asset('website/assets/image/svg/plugAndPlayIntegrationValueIcon_36x36_about-dark.svg') }}" width="36" height="36" alt="" loading="lazy">
<span class="sanad-differ__badge" lang="en" dir="ltr">Sanad AI</span>
           <h3 class="sanad-differ__card-title">مدعومين بالذكاء الاصطناعي</h3>
           <p class="sanad-differ__card-desc">تزويد فرقنا التشغيلية باقتراحات وتحليلات لحظية لنبرة العميل تسهم في سرعة ودقة الرد.</p>
       </article>
       <article class="sanad-differ__card differ-card sanad-card-hoverable">
           <img class="sanad-differ__icon sanad-differ__icon--light" src="{{ asset('website/assets/image/svg/operationalRigorValueIcon_36x36_about-light.svg') }}" width="36" height="36" alt="" loading="lazy">
<img class="sanad-differ__icon sanad-differ__icon--dark" src="{{ asset('website/assets/image/svg/operationalRigorValueIcon_36x36_about-dark.svg') }}" width="36" height="36" alt="" loading="lazy">
<span class="sanad-differ__badge" lang="en" dir="ltr">NDA</span>
           <h3 class="sanad-differ__card-title">ملكية أمان وبيانات مطلقة</h3>
           <p class="sanad-differ__card-desc">بيانات عملائك تظل مسجلة على سيرفراتك ونضمن عدم تسريبها بموجب اتفاقيات NDA رسمية.</p>
       </article>
       <article class="sanad-differ__card differ-card sanad-card-hoverable">
           <img class="sanad-differ__icon sanad-differ__icon--light" src="{{ asset('website/assets/image/svg/dataOwnershipValueIcon_36x36_about-light.svg') }}" width="36" height="36" alt="" loading="lazy">
<img class="sanad-differ__icon sanad-differ__icon--dark" src="{{ asset('website/assets/image/svg/dataOwnershipValueIcon_36x36_about-dark.svg') }}" width="36" height="36" alt="" loading="lazy">
<span class="sanad-differ__badge" lang="en" dir="ltr">KPIs</span>
           <h3 class="sanad-differ__card-title">تقارير أداء أسبوعية</h3>
           <p class="sanad-differ__card-desc">تقارير أسبوعية تعكس عدد المكالمات، زمن الرد، تحويلات المبيعات، ومؤشرات الجودة.</p>
       </article>
   </div>
</div>
</section>
<section class="sanad-roi" aria-labelledby="sanad-roi-title" data-node-id="150:19875">
<h2 class="sanad-roi__title" id="sanad-roi-title" data-node-id="150:19876">مصفوفة الأثر المالي وضمانات الجودة</h2>
<div class="sanad-roi__row sanad-roi__row--metrics">
<article class="sanad-roi__card sanad-roi__card--metric sanad-roi__card--cost sanad-card-hoverable" data-node-id="150:19877">
<img class="sanad-roi__card-icon" src="{{ asset('website/assets/image/svg/costReductionIcon_32x32.svg') }}" alt="" width="32" height="32" decoding="async" data-node-id="150:20280">
<p class="sanad-roi__card-value" dir="ltr" data-node-id="150:19880">-40%</p>
<p class="sanad-roi__card-unit" data-node-id="150:19881">من التكاليف</p>
<h3 class="sanad-roi__card-title" data-node-id="150:19882">تخفيض التكاليف</h3>
<p class="sanad-roi__card-description" data-node-id="150:19883">خفض ما يصل إلى 40% من التكاليف التشغيلية والإدارية (بدون تأمين صحي أو توظيف داخلي).</p>
<div class="sanad-card-hover-overlay" aria-hidden="true" data-node-id="158:23744">
</div>
</article>
<article class="sanad-roi__card sanad-roi__card--metric sanad-roi__card--sales sanad-card-hoverable" data-node-id="150:19884">
<img class="sanad-roi__card-icon" src="{{ asset('website/assets/image/svg/salesConversionIcon_32x32.svg') }}" alt="" width="32" height="32" decoding="async" data-node-id="150:19885">
<p class="sanad-roi__card-value" dir="ltr" data-node-id="150:19887">+35%</p>
<h3 class="sanad-roi__card-title" data-node-id="150:19888">زيادة تحويل المبيعات</h3>
<p class="sanad-roi__card-description" data-node-id="150:19889">تحقيق زيادة في معدل تحويل المبيعات تصل إلى <bdi dir="ltr">+35%</bdi>.</p>
<div class="sanad-card-hover-overlay" aria-hidden="true" data-node-id="158:23745">
</div>
</article>
<article class="sanad-roi__card sanad-roi__card--metric sanad-roi__card--zero sanad-card-hoverable" data-node-id="150:19890">
<img class="sanad-roi__card-icon" src="{{ asset('website/assets/image/svg/zeroSetupFeesIcon_32x32.svg') }}" alt="" width="32" height="32" decoding="async" data-node-id="150:19891">
<p class="sanad-roi__card-value" data-node-id="150:19895">0</p>
<h3 class="sanad-roi__card-title" data-node-id="150:19896">صفر تكاليف تأسيس</h3>
<p class="sanad-roi__card-label" lang="en" dir="ltr" data-node-id="150:19897">Zero Setup Fees</p>
<p class="sanad-roi__card-description" data-node-id="150:19898">البدء الفوري على أنظمتك بدون رسوم سيرفرات أو بنية تحتية.</p>
<div class="sanad-card-hover-overlay" aria-hidden="true" data-node-id="158:23746">
</div>
</article>
</div>
<div class="sanad-roi__row sanad-roi__row--guarantees">
<article class="sanad-roi__card sanad-roi__card--guarantee sanad-roi__card--qa sanad-card-hoverable" data-node-id="150:19899">
<svg class="sanad-roi__ring" viewBox="0 0 48 48" width="48" height="48" aria-hidden="true"><circle class="sla-ring" cx="24" cy="24" r="22" fill="none" stroke="currentColor" stroke-width="1.5" /></svg>
<img class="sanad-roi__card-icon" src="{{ asset('website/assets/image/svg/qaGuaranteeIcon_32x32.svg') }}" alt="" width="32" height="32" decoding="async" data-node-id="150:19900">
<p class="sanad-roi__card-value" dir="ltr" data-node-id="150:19903">95%+</p>
<h3 class="sanad-roi__card-title" data-node-id="150:19904">ضمان جودة الأداء</h3>
<p class="sanad-roi__card-label" lang="en" dir="ltr" data-node-id="150:20274">QA Guarantee</p>
<p class="sanad-roi__card-description" data-node-id="150:19905">نلتزم بتحقيق نسبة جودة أداء تزيد عن <bdi dir="ltr">95%+</bdi> لجميع التفاعلات مع تقارير أسبوعية تفصيلية.</p>
<div class="sanad-card-hover-overlay" aria-hidden="true" data-node-id="158:23747">
</div>
</article>
<article class="sanad-roi__card sanad-roi__card--guarantee sanad-roi__card--sla sanad-card-hoverable" data-node-id="150:19906">
<svg class="sanad-roi__ring" viewBox="0 0 48 48" width="48" height="48" aria-hidden="true"><circle class="sla-ring" cx="24" cy="24" r="22" fill="none" stroke="currentColor" stroke-width="1.5" /></svg>
<img class="sanad-roi__card-icon" src="{{ asset('website/assets/image/svg/slaBenchmarkIcon_32x32.svg') }}" alt="" width="32" height="32" decoding="async" data-node-id="150:20276">
<p class="sanad-roi__card-value" dir="ltr" data-node-id="150:20275">&lt; 60 ثانية</p>
<h3 class="sanad-roi__card-title" data-node-id="150:19910">السرعة القياسية</h3>
<p class="sanad-roi__card-label" lang="en" dir="ltr" data-node-id="150:19911">SLA Benchmark</p>
<p class="sanad-roi__card-description" data-node-id="150:19912">استجابة فورية خلال أقل من 60 ثانية للمكالمات والرسائل لضمان أعلى معدلات الرضا.</p>
<div class="sanad-card-hover-overlay" aria-hidden="true" data-node-id="158:23748">
</div>
</article>
</div>
<button type="button" class="sanad-btn sanad-roi__cta" data-consultation-open data-node-id="150:20278">احصل على تحليل مجاني لفرص المبيعات والوفورات التشغيلية</button>
</section>
<section class="sanad-industries" aria-labelledby="sanad-industries-title" data-node-id="150:20282">
<div class="sanad-industries__header" data-node-id="150:20283">
<p class="sanad-industries__eyebrow" data-node-id="150:20284">INDUSTRY SOLUTIONS — حلول القطاعات</p>
<h2 class="sanad-industries__title" id="sanad-industries-title" data-node-id="150:20285">حلول مخصصة للقطاعات</h2>
</div>
<div class="sanad-industries__list" data-node-id="150:20286">
<article class="sanad-industries__card sanad-card-hoverable" data-node-id="150:20329">
<span class="sanad-industries__icon-box" data-node-id="150:20330">
<img class="sanad-industries__icon sanad-industries__icon--light" src="{{ asset('website/assets/image/svg/eCommerceIcon_32x32_srv-light.svg') }}" alt="" width="32" height="32" decoding="async" data-node-id="150:20331">
<img class="sanad-industries__icon sanad-industries__icon--dark" src="{{ asset('website/assets/image/svg/eCommerceIcon_32x32_srv-dark.svg') }}" alt="" width="32" height="32" decoding="async" aria-hidden="true">
</span>
<h3 class="sanad-industries__card-title" data-node-id="150:20333">المتاجر الإلكترونية</h3>
<p class="sanad-industries__card-subtitle" data-node-id="150:20334">E-Commerce</p>
<span class="sanad-industries__divider" data-node-id="150:20335" aria-hidden="true">
</span>
<ul class="sanad-industries__use-cases" data-node-id="150:20336">
<li class="sanad-industries__use-case" data-node-id="150:20337">
<span class="sanad-industries__check" data-node-id="150:20339" aria-hidden="true">
<svg class="sanad-industries__check-mark" viewBox="0 0 24 24" width="24" height="24" focusable="false" aria-hidden="true">
<path class="sanad-industries__check-path" data-node-id="150:20340" d="M7 12L10.5 15.5L17 8.5" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
</path>
</svg>
</span>
<span class="sanad-industries__use-case-text" data-node-id="150:20338">تأكيد الطلبات.</span>
</li>
<li class="sanad-industries__use-case" data-node-id="150:20341">
<span class="sanad-industries__check" data-node-id="150:20343" aria-hidden="true">
<svg class="sanad-industries__check-mark" viewBox="0 0 24 24" width="24" height="24" focusable="false" aria-hidden="true">
<path class="sanad-industries__check-path" data-node-id="150:20344" d="M7 12L10.5 15.5L17 8.5" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
</path>
</svg>
</span>
<span class="sanad-industries__use-case-text" data-node-id="150:20342">متابعة الشحن.</span>
</li>
<li class="sanad-industries__use-case" data-node-id="150:20345">
<span class="sanad-industries__check" data-node-id="150:20347" aria-hidden="true">
<svg class="sanad-industries__check-mark" viewBox="0 0 24 24" width="24" height="24" focusable="false" aria-hidden="true">
<path class="sanad-industries__check-path" data-node-id="150:20348" d="M7 12L10.5 15.5L17 8.5" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
</path>
</svg>
</span>
<span class="sanad-industries__use-case-text" data-node-id="150:20346">معالجة السلات المتروكة.</span>
</li>
</ul>
<div class="sanad-card-hover-overlay" aria-hidden="true" data-node-id="158:23755">
</div>
</article>
<article class="sanad-industries__card sanad-card-hoverable" data-node-id="150:20311">
<span class="sanad-industries__icon-box" data-node-id="150:20312">
<img class="sanad-industries__icon sanad-industries__icon--light" src="{{ asset('website/assets/image/svg/healthcareIcon_32x32_srv-light.svg') }}" alt="" width="32" height="32" decoding="async" data-node-id="150:20287">
<img class="sanad-industries__icon sanad-industries__icon--dark" src="{{ asset('website/assets/image/svg/healthcareIcon_32x32_srv-dark.svg') }}" alt="" width="32" height="32" decoding="async" aria-hidden="true">
</span>
<h3 class="sanad-industries__card-title" data-node-id="150:20313">الرعاية الصحية والعيادات</h3>
<p class="sanad-industries__card-subtitle" data-node-id="150:20314">Healthcare</p>
<span class="sanad-industries__divider" data-node-id="150:20315" aria-hidden="true">
</span>
<ul class="sanad-industries__use-cases" data-node-id="150:20316">
<li class="sanad-industries__use-case" data-node-id="150:20317">
<span class="sanad-industries__check" data-node-id="150:20319" aria-hidden="true">
<svg class="sanad-industries__check-mark" viewBox="0 0 24 24" width="24" height="24" focusable="false" aria-hidden="true">
<path class="sanad-industries__check-path" data-node-id="150:20320" d="M7 12L10.5 15.5L17 8.5" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
</path>
</svg>
</span>
<span class="sanad-industries__use-case-text" data-node-id="150:20318">حجز المواعيد.</span>
</li>
<li class="sanad-industries__use-case" data-node-id="150:20321">
<span class="sanad-industries__check" data-node-id="150:20323" aria-hidden="true">
<svg class="sanad-industries__check-mark" viewBox="0 0 24 24" width="24" height="24" focusable="false" aria-hidden="true">
<path class="sanad-industries__check-path" data-node-id="150:20324" d="M7 12L10.5 15.5L17 8.5" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
</path>
</svg>
</span>
<span class="sanad-industries__use-case-text" data-node-id="150:20322">التذكير بالمواعيد.</span>
</li>
<li class="sanad-industries__use-case" data-node-id="150:20325">إرشادات المراجعين بكفاءة وأمان.</li>
</ul>
<div class="sanad-card-hover-overlay" aria-hidden="true" data-node-id="158:23754">
</div>
</article>
<article class="sanad-industries__card sanad-card-hoverable" data-node-id="150:20289">
<span class="sanad-industries__icon-box" data-node-id="150:20290">
<img class="sanad-industries__icon sanad-industries__icon--light" src="{{ asset('website/assets/image/svg/realEstateB2bIcon_32x32_srv-light.svg') }}" alt="" width="32" height="32" decoding="async" data-node-id="150:20291">
<img class="sanad-industries__icon sanad-industries__icon--dark" src="{{ asset('website/assets/image/svg/realEstateB2bIcon_32x32_srv-dark.svg') }}" alt="" width="32" height="32" decoding="async" aria-hidden="true">
</span>
<h3 class="sanad-industries__card-title" data-node-id="150:20295">الشركات العقارية والخدمية</h3>
<p class="sanad-industries__card-subtitle" data-node-id="150:20296">Real Estate &amp; B2B</p>
<span class="sanad-industries__divider" data-node-id="150:20297" aria-hidden="true">
</span>
<ul class="sanad-industries__use-cases" data-node-id="150:20298">
<li class="sanad-industries__use-case" data-node-id="150:20299">
<span class="sanad-industries__check" data-node-id="150:20301" aria-hidden="true">
<svg class="sanad-industries__check-mark" viewBox="0 0 24 24" width="24" height="24" focusable="false" aria-hidden="true">
<path class="sanad-industries__check-path" data-node-id="150:20302" d="M7 12L10.5 15.5L17 8.5" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
</path>
</svg>
</span>
<span class="sanad-industries__use-case-text" data-node-id="150:20300">تأهيل الـ Leads.</span>
</li>
<li class="sanad-industries__use-case" data-node-id="150:20303">
<span class="sanad-industries__check" data-node-id="150:20305" aria-hidden="true">
<svg class="sanad-industries__check-mark" viewBox="0 0 24 24" width="24" height="24" focusable="false" aria-hidden="true">
<path class="sanad-industries__check-path" data-node-id="150:20306" d="M7 12L10.5 15.5L17 8.5" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
</path>
</svg>
</span>
<span class="sanad-industries__use-case-text" data-node-id="150:20304">تحديد المواعيد.</span>
</li>
<li class="sanad-industries__use-case" data-node-id="150:20307">فريق مبيعات هاتفي مخصص للعقود الكبرى.</li>
</ul>
<div class="sanad-card-hover-overlay" aria-hidden="true" data-node-id="158:23753">
</div>
</article>
</div>
</section>
<section class="sanad-service-form" aria-labelledby="sanad-service-form-heading" data-node-id="150:19968">
<div class="sanad-service-form__container" data-node-id="150:19969">
<div class="sanad-service-form__layout" data-node-id="150:19970">
<div class="sanad-service-form__header" data-node-id="150:19971">
<h2 class="sanad-service-form__title" id="sanad-service-form-heading" data-node-id="150:19972">جاهز لتطوير تجربة عملائك واختيار الحزمة المناسبة؟</h2>
<p class="sanad-service-form__description" data-node-id="150:19973">اترك بياناتك وسيتواصل معك أحد خبراء التشغيل في <bdi class="sanad-service-form__latin" dir="ltr">Sanad CX.</bdi>
</p>
</div>
<div class="sanad-service-form__form-container" data-node-id="150:19974">
<form class="sanad-service-form__form" action="{{ route('website.consultation.store') }}" method="post" data-service-request>
    @csrf
    <div class="sanad-service-form__group">
        <div class="sanad-input sanad-service-form__field">
            <label class="sanad-input__label" for="service-full-name">الاسم الكريم</label>
            <div class="sanad-input__field">
<input class="sanad-input__control" id="service-full-name" name="full_name" type="text" autocomplete="name" maxlength="255" aria-describedby="service-full-name-error" required>
</div>
            <span class="sanad-input__status" id="service-full-name-error" data-service-error="full_name" aria-live="polite">
</span>
        </div>
        <div class="sanad-input sanad-service-form__field">
            <label class="sanad-input__label" for="service-company-name">اسم الشركة / البراند</label>
            <div class="sanad-input__field">
<input class="sanad-input__control" id="service-company-name" name="company_name" type="text" autocomplete="organization" maxlength="255" aria-describedby="service-company-name-error" required>
</div>
            <span class="sanad-input__status" id="service-company-name-error" data-service-error="company_name" aria-live="polite">
</span>
        </div>
        <div class="sanad-input sanad-service-form__field">
            <label class="sanad-input__label" for="service-mobile">رقم الموبايل / الواتساب</label>
            <div class="sanad-input__field">
<input class="sanad-input__control" id="service-mobile" name="mobile_whatsapp" type="tel" autocomplete="tel" maxlength="32" aria-describedby="service-mobile-error" required inputmode="tel" dir="ltr" data-consultation-phone pattern="\+?[0-9](?:[ \(\)\-]*[0-9]){6,14}">
</div>
            <span class="sanad-input__status" id="service-mobile-error" data-service-error="mobile_whatsapp" aria-live="polite">
</span>
        </div>
    </div>
    <div class="sanad-input sanad-service-form__field">
        <label class="sanad-input__label" for="service-volume">حجم التواصل اليومي</label>
        <div class="sanad-input__field">
<select class="sanad-input__control" id="service-volume" name="daily_contact_volume" aria-describedby="service-volume-error" required>
            <option value="">اختر</option>
<option value="أقل من 100">أقل من 100</option>
<option value="100 - 500">100 - 500</option>
<option value="أكثر من 500">أكثر من 500</option>
        </select>
</div>
        <span class="sanad-input__status" id="service-volume-error" data-service-error="daily_contact_volume" aria-live="polite">
</span>
    </div>
    <div class="sanad-input sanad-service-form__field">
        <label class="sanad-input__label" for="service-systems">البرامج أو الأنظمة المستخدمة حالياً <span class="sanad-input__optional">(اختياري)</span>
</label>
        <div class="sanad-input__field">
<input class="sanad-input__control" id="service-systems" name="current_systems" type="text" maxlength="500" aria-describedby="service-systems-error">
</div>
        <span class="sanad-input__status" id="service-systems-error" data-service-error="current_systems" aria-live="polite">
</span>
    </div>
    <p class="sanad-service-form__notice" data-service-status role="status" tabindex="-1">
</p>
    <button type="submit" class="sanad-btn sanad-service-form__submit">احجز جلسة استشارية مجانية</button>
</form>
</div>
</div>
</div>
</section>
<section class="sanad-services-cta" id="services-final-cta" data-gsap-section="services-final-cta" data-node-id="349:5649" aria-labelledby="sanad-services-cta-title">
<div class="sanad-services-cta__container">
   <h2 class="sanad-services-cta__title" id="sanad-services-cta-title">جاهز لتحويل مركز التواصل لديك إلى محرك مبيعات متطور؟</h2>
   <p class="sanad-services-cta__description">تواصل مع مستشارينا التشغيليين اليوم لاختيار الحزمة والحل الأنسب لحجم نشاطك التجاري.</p>
   <button type="button" class="sanad-btn sanad-services-cta__button" data-consultation-open>احجز جلسة تحليل تشغيلي مجانية</button>
</div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('[data-service-request]');
    if (!form) return;
    const button = form.querySelector('[type="submit"]');
    const status = form.querySelector('[data-service-status]');
    const label = button.textContent;
    const clearError = input => {
        input.removeAttribute('aria-invalid');
        input.setCustomValidity('');
        const error = form.querySelector(`[data-service-error="${input.name}"]`);
        if (error) error.textContent = '';
    };
    form.addEventListener('input', event => clearError(event.target));
    form.addEventListener('change', event => clearError(event.target));
    form.addEventListener('invalid', event => {
        event.target.setAttribute('aria-invalid', 'true');
        const error = form.querySelector(`[data-service-error="${event.target.name}"]`);
        if (error) error.textContent = event.target.validationMessage;
    }, true);
    form.addEventListener('submit', async event => {
        event.preventDefault();
        if (button.disabled) return;
        form.querySelectorAll('input, select').forEach(input => {
            clearError(input);
            if (input.required && !input.value.trim()) input.setCustomValidity('يرجى تعبئة هذا الحقل.');
        });
        if (!form.reportValidity()) return;
        button.disabled = true;
        button.textContent = 'جارٍ إرسال الطلب…';
        form.setAttribute('aria-busy', 'true');
        status.textContent = '';
        const controller = new AbortController();
        const timeout = setTimeout(() => controller.abort(), 20000);
        try {
            const response = await fetch(form.action, {
                method: 'POST', credentials: 'same-origin', signal: controller.signal,
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: new FormData(form),
            });
            const data = await response.json();
            if (response.status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([name, messages]) => {
                    const input = form.elements.namedItem(name);
                    const error = form.querySelector(`[data-service-error="${name}"]`);
                    if (input) input.setAttribute('aria-invalid', 'true');
                    if (error) error.textContent = messages[0];
                });
                status.textContent = 'يرجى مراجعة الحقول الموضحة أدناه.';
                form.querySelector('[aria-invalid="true"]')?.focus();
            } else if (response.ok && data.code === 200) {
                form.reset();
                status.textContent = data.message || 'تم إرسال طلبك بنجاح. سيتواصل معك فريقنا قريباً.';
                status.focus();
            } else {
                throw new Error('request');
            }
        } catch (error) {
            status.textContent = 'تعذر إرسال الطلب. بياناتك باقية، يرجى المحاولة مرة أخرى.';
            status.focus();
        } finally {
            clearTimeout(timeout);
            button.disabled = false;
            button.textContent = label;
            form.removeAttribute('aria-busy');
        }
    });
});
</script>
@endpush
