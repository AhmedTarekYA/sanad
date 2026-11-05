@extends('website.layouts.app')

@section('page_key', 'ai-assistant.html')
@section('title', 'المساعد الذكي — SANAD CX AI')
@section('meta_description', 'إضافة متصفح (Chrome Extension) ذكية تُدمج مباشرة فوق الواتساب ونظام الـ CRM لتزويد موظفيك بإجابات دقيقة وتقارير تحليلية لحظية.')
@section('og_title', 'المساعد الذكي — SANAD CX AI')
@section('og_description', 'ضاعف سرعة مبيعاتك ورضا عملائك بذكاء اصطناعي يعمل بجانب فريقك لحظة بلحظة.')

@push('styles')
<link rel="stylesheet" href="{{ asset('website/assets/css/pages/ai-assistant.css') }}">
@endpush

@section('content')
<div class="ai-page">
    <section class="ai-hero" aria-labelledby="ai-hero-title">
        <div class="ai-hero__text">
            <p class="ai-badge">SANAD CX AI — المساعد الذكي</p>
            <h1 id="ai-hero-title">ضاعف سرعة مبيعاتك ورضا عملائك بذكاء اصطناعي يعمل بجانب فريقك لحظة بلحظة</h1>
            <p class="ai-muted">إضافة متصفح (Chrome Extension) ذكية تُدمج مباشرة فوق الواتساب ونظام الـ CRM لتزويد موظفيك بإجابات دقيقة وتقارير تحليلية لحظية.</p>
            <button type="button" class="sanad-btn" data-free-trial-open>ابدأ التجربة المجانية</button>
        </div>
        <div class="ai-orbit" role="img" aria-label="تصوّر توضيحي لطريقة عمل المساعد">
            <div class="ai-orbit__ring"><span class="ai-orbit__core" dir="ltr">SANAD AI</span>
                <i class="ai-orbit__n" style="--a:-60deg">التحليلات</i><i class="ai-orbit__n" style="--a:0deg">الأداء</i><i class="ai-orbit__n" style="--a:60deg">المبيعات</i>
                <i class="ai-orbit__n" style="--a:120deg">العملاء</i><i class="ai-orbit__n" style="--a:180deg">المحادثات</i><i class="ai-orbit__n" style="--a:240deg">الردود</i>
            </div>
            <div class="ai-orbit__card ai-orbit__card--1"><small>01 / رسالة العميل</small><span>محادثة العميل على WhatsApp Web</span></div>
            <div class="ai-orbit__card ai-orbit__card--2"><small>02 / قاعدة المعرفة</small><span>معلومات المنتجات والأسعار</span></div>
            <div class="ai-orbit__card ai-orbit__card--3"><small>03 / اقتراح المساعد</small><span>ردود دقيقة بجانب فريقك</span></div>
            <p class="ai-caption">تصوّر توضيحي لطريقة عمل المساعد</p>
        </div>
    </section>

    <section aria-labelledby="ai-eco-title">
        <h2 id="ai-eco-title">تتكامل بسلاسة مع الأنظمة التي تستخدمها يومياً</h2>
        <div class="ai-logos" dir="ltr">
            <span class="ai-logos__hub">SANAD CX AI</span>
            <div class="ai-logos__row"><span>WhatsApp Web</span><span>Zoho CRM</span><span>HubSpot</span><span>Salesforce</span><span>Zendesk</span></div>
        </div>
    </section>

    <section aria-labelledby="ai-shift-title">
        <h2 id="ai-shift-title">الفارق الذي تحدثه إضافة Sanad CX AI في عملياتك:</h2>
        <div class="ai-shift">
            <article class="ai-card">
                <h3>قبل استخدام Sanad CX AI</h3>
                <ul>
                    <li>بطء في الرد وتأخر في إغلاق الصفقات</li>
                    <li>تباين جودة الأداء واختلاف إجابات الموظفين</li>
                    <li>صعوبة معرفة مدى رضا العميل أثناء الشات</li>
                    <li>غياب التحليلات الدقيقة عن أسباب ضياع الفرص</li>
                </ul>
                <div class="ai-bubble"><span>هل يمكن توضيح تفاصيل الخدمة؟</span><span class="ai-muted">جارٍ مراجعة المعلومات…</span><small class="ai-caption">مثال توضيحي</small></div>
            </article>
            <article class="ai-card ai-shift__after">
                <h3>بعد استخدام Sanad CX AI</h3>
                <ul>
                    <li>ردود مقترحة عالية الدقة خلال ثوانٍ معدودة</li>
                    <li>توحيد لغة الخطاب والتزام تام بقواعد الشركة</li>
                    <li>كشف تلقائي لنبرة ومشاعر العميل (Sentiment)</li>
                    <li>داشبورد متكاملة توضح أبرز اعتراضات العملاء وأداء الفريق</li>
                </ul>
                <div class="ai-bubble ai-bubble--ai"><span>هل يمكن توضيح تفاصيل الخدمة؟</span><b>رد مقترح من قاعدة المعرفة</b><small class="ai-caption">مثال توضيحي</small></div>
            </article>
        </div>
    </section>

    <section aria-labelledby="ai-steps-title">
        <h2 id="ai-steps-title">ابدأ العمل خلال 3 خطوات بسيطة:</h2>
        <div class="ai-steps">
            <ol>
                <li class="ai-card"><b>01</b><i class="ai-ico ai-ico--dl" aria-hidden="true"></i><div><h3>تثبيت الإضافة (Install)</h3><p class="ai-muted">إضافة Sanad CX لمتصفح كروم بضغطة زر.</p></div></li>
                <li class="ai-card"><b>02</b><i class="ai-ico ai-ico--kb" aria-hidden="true"><s></s><s></s><s></s></i><div><h3>ربط قاعدة المعرفة (Connect KB)</h3><p class="ai-muted">رفع ملفات المنتجات والأسعار في لوحة التحكم.</p></div></li>
                <li class="ai-card"><b>03</b><i class="ai-ico ai-ico--cp" aria-hidden="true"><s></s><s></s></i><div><h3>التوجيه اللحظي (Co-Pilot Advantage)</h3><p class="ai-muted">يبدأ الموظف في استقبال الاقتراحات والتحليلات أثناء المحادثة فوراً.</p></div></li>
            </ol>
            <p class="ai-caption ai-steps__cap">معاينة توضيحية للإضافة</p>
            <div class="ai-demo" role="img" aria-label="معاينة توضيحية لواجهة إضافة Sanad CX">
                <div class="ai-demo__top"><b dir="ltr">SANAD CX / AI</b><small>عرض تمثيلي للواجهة</small></div>
                <h3>ثبّت الإضافة بضغطة واحدة</h3>
                <div class="ai-demo__win"><div class="ai-demo__bar"><i></i><i></i><i></i><span dir="ltr">SANAD CX AI / Extension setup</span></div>
                    <div class="ai-demo__box"><span class="ai-demo__logo">AI</span><b dir="ltr">SANAD CX AI</b><span>مساعدك الذكي داخل المتصفح</span><span class="ai-demo__cta">إضافة إلى Chrome</span></div></div>
                <div class="ai-demo__foot"><span dir="ltr">01 / 04</span><span>ثبّت ← اربط ← راجع ← استخدم</span></div>
            </div>
        </div>
        <div class="ai-center">
            <p class="ai-muted">إضافة متصفح (Chrome Extension) ذكية تُدمج مباشرة فوق الواتساب ونظام الـ CRM لتزويد موظفيك بإجابات دقيقة وتقارير تحليلية لحظية.</p>
            <button type="button" class="sanad-btn" data-free-trial-open>ابدأ التجربة المجانية</button>
        </div>
    </section>

    <section aria-labelledby="ai-ops-title">
        <h2 id="ai-ops-title">تحكّم كامل ورؤية شاملة لمدراء الكول سنتر والمبيعات:</h2>
        <div class="ai-kpis">
            <article class="ai-card ai-kpis__big">
                <h3>مؤشرات الأداء اللحظية (Agent KPIs)</h3>
                <p class="ai-muted">متابعة سرعة الرد ونسبة التزام الموظف باقتراحات الذكاء الاصطناعي.</p>
                <div class="ai-spark" aria-hidden="true"><i style="height:20%"></i><i style="height:30%"></i><i style="height:18%"></i><i style="height:42%"></i><i style="height:36%"></i><i style="height:52%"></i><i style="height:48%"></i><i style="height:66%"></i><i style="height:60%"></i><i class="g" style="height:78%"></i><i class="g" style="height:72%"></i><i class="g" style="height:88%"></i></div>
                <p class="ai-caption">تصوّر توضيحي للتحليلات</p>
            </article>
            <article class="ai-card ai-kpis__s1">
                <h3>تحليل المشاعر العامة</h3>
                <p class="ai-muted">إحصائيات دقيقة لنسبة العملاء السعداء مقابل الغاضبين.</p>
                <div class="ai-bar" aria-hidden="true"><i></i></div>
                <div class="ai-bar-legend"><span>سعداء</span><span>غاضبون</span></div>
            </article>
            <article class="ai-card ai-kpis__s2">
                <h3>تقرير الاعتراضات الشائعة (Top Objections)</h3>
                <p class="ai-muted">معرفة الأسباب الحقيقية لتردد العملاء (السعر، الشحن، التوصيل) لتطوير خطتك التسويقية.</p>
                <div class="ai-lines" aria-hidden="true"><i></i><i></i><i></i></div>
            </article>
        </div>
    </section>

    <section aria-labelledby="ai-plans-title">
        <h2 id="ai-plans-title">باقات مرنة تناسب حجم فريقك:</h2>
        <div class="ai-plans">
            <article class="ai-card ai-plan">
                <h3 dir="ltr">Starter</h3><p class="ai-muted">حتى 3 موظفين</p>
                <p>3,000 اقتراح ذكي شهرياً</p>
                <p class="ai-plan__price">$49 / شهرياً</p><p class="ai-muted">$490 / سنوياً</p>
                <button type="button" class="sanad-btn" data-free-trial-open>ابدأ التجربة المجانية</button>
            </article>
            <article class="ai-card ai-plan ai-plan--featured">
                <span class="ai-plan__tag">الأكثر طلباً</span>
                <h3 dir="ltr">Pro</h3><p class="ai-muted">حتى 10 موظفين</p>
                <p>12,000 اقتراح ذكي شهرياً</p>
                <p class="ai-plan__price">$149 / شهرياً</p><p class="ai-muted">$1490 / سنوياً</p>
                <button type="button" class="sanad-btn" data-free-trial-open>ابدأ التجربة المجانية</button>
            </article>
            <article class="ai-card ai-plan">
                <h3>Business (الأكثر توفيراً)</h3><p class="ai-muted">حتى 25 موظف</p>
                <p>35,000 اقتراح ذكي شهرياً</p>
                <p class="ai-plan__price">$349 / شهرياً</p><p class="ai-muted">$3490 / سنوياً</p>
                <button type="button" class="sanad-btn" data-free-trial-open>ابدأ التجربة المجانية</button>
            </article>
        </div>
        <p class="ai-sales">هل تحتاج باقة خاصة لكول سنتر كبير؟ <button type="button" data-consultation-open>تواصل مع فريق المبيعات</button></p>
    </section>

    <section class="sanad-faq" id="faq" aria-labelledby="sanad-faq-title">
        <div class="sanad-faq__container">
            <div class="sanad-faq__header"><h2 class="sanad-faq__title" id="sanad-faq-title">الأسئلة الشائعة</h2></div>
            <div class="sanad-faq__list">
                @foreach([
                    ['هل أحتاج لمطورين لتثبيت الأداة؟', 'لا، التثبيت يتم بنقرة زر واحدة من متجر كروم ويتم الإعداد خلال دقائق.'],
                    ['هل تعمل الأداة مع اللهجة المحلية ؟', 'نعم، تم تدريب النموذج على فهم مختلف اللهجات العربية واللغة الإنجليزية بدقة عالية.'],
                    ['هل بيانات محادثاتنا آمنة؟', 'نلتزم بأعلى معايير التشفير والخصوصية، ولا يتم مشاركة بيانات عملائك مع أي طرف ثالث.'],
                ] as $i => [$q, $a])
                <div class="sanad-faq__item sanad-card-hoverable">
                    <h3 class="sanad-faq__heading">
                        <button type="button" class="sanad-faq__trigger" id="ai-faq-q{{ $i + 1 }}" aria-expanded="false" aria-controls="ai-faq-a{{ $i + 1 }}"><span class="sanad-faq__question">{{ $q }}</span>
                            <span class="sanad-faq__icon" aria-hidden="true"> <img class="sanad-faq__chevron sanad-faq__chevron--light" src="{{ asset('website/assets/image/svg/Group_16x8_homepage-light.svg') }}" alt="" width="16" height="8"> <img class="sanad-faq__chevron sanad-faq__chevron--dark" src="{{ asset('website/assets/image/svg/Group_16x8_homepage-dark.svg') }}" alt="" width="16" height="8"> </span></button>
                    </h3>
                    <div class="sanad-faq__panel" id="ai-faq-a{{ $i + 1 }}" role="region" aria-labelledby="ai-faq-q{{ $i + 1 }}" hidden>
                        <p class="sanad-faq__answer">{{ $a }}</p></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="ai-final" aria-labelledby="ai-final-title">
        <div class="ai-card">
            <h2 id="ai-final-title">SANAD CX AI — المساعد الذكي</h2>
            <button type="button" class="sanad-btn" data-free-trial-open>ابدأ التجربة المجانية</button>
        </div>
    </section>
</div>
@endsection
