<dialog class="sanad-consultation" id="sanad-exit-intent" data-sanad-modal tabindex="-1" aria-labelledby="sanad-exit-intent-title">
 <button type="button" class="sanad-consultation__close" data-modal-close aria-label="إغلاق">×</button>
 <div class="sanad-consultation__scroll"><div class="sanad-consultation__container"><div class="sanad-consultation__layout">
  <div data-state="form">
   <div class="sanad-consultation__header">
    <h2 class="sanad-consultation__title" id="sanad-exit-intent-title">قبل أن تغادر.. احصل على تحليل مجاني لفرص تحسين خدمة عملائك وتقليل التكاليف التشغيلية.</h2>
    <p class="sanad-consultation__description">اترك بياناتك و سيتواصل معك أحد خبراء التشغيل في <span lang="en" dir="ltr">Sanad CX</span> لتقديم استشارة مجانية وحزمة مخصصة.</p>
   </div>
   <form class="sanad-consultation__form" data-modal-form action="{{ route('website.consultation.store') }}" novalidate>
    <div class="sanad-modal-alert" data-form-alert hidden>راجع البيانات المطلوبة. أكمل الحقول المعلّمة أدناه ثم أعد إرسال طلبك.</div>
    <div class="sanad-input"><label class="sanad-input__label" for="ex-name">الاسم الكريم</label><div class="sanad-input__field"><input class="sanad-input__control" id="ex-name" type="text" name="full_name" placeholder="الاسم الكريم" autocomplete="name" required></div><span class="sanad-input__status" data-field-error="full_name" aria-live="polite"></span></div>
    <div class="sanad-input"><label class="sanad-input__label" for="ex-mob">رقم الموبايل / الواتساب</label><div class="sanad-input__field"><input class="sanad-input__control" id="ex-mob" type="tel" name="mobile_whatsapp" placeholder="رقم الموبايل / الواتساب" inputmode="tel" autocomplete="tel" required></div><span class="sanad-input__status" data-field-error="mobile_whatsapp" aria-live="polite"></span></div>
    <input type="hidden" name="company_name" value="غير محدد">
    <input type="hidden" name="daily_contact_volume" value="غير محدد">
    <button type="submit" class="sanad-btn sanad-btn--md sanad-btn--primary sanad-consultation__submit">حجز جلسة استشارية مجانية لنمو عملائك</button>
   </form>
  </div>
  <div data-state="loading" hidden><h2 class="sanad-consultation__title" tabindex="-1">جارٍ إرسال طلبك</h2><p class="sanad-consultation__description">لحظات ونؤكد استلام بياناتك.</p></div>
  <div data-state="success" hidden><h2 class="sanad-consultation__title" tabindex="-1">وصل طلبك بنجاح</h2><p class="sanad-consultation__description">شكرًا لتواصلك. سيتواصل معك فريق سند عبر الرقم الذي أدخلته.</p><button type="button" class="sanad-btn sanad-btn--md sanad-btn--primary" data-modal-close>تم</button></div>
  <div data-state="error" hidden><h2 class="sanad-consultation__title" tabindex="-1">تعذّر إرسال طلبك</h2><p class="sanad-consultation__description">بياناتك محفوظة في هذه الخطوة. حاول مرة أخرى أو تواصل معنا عبر واتساب.</p><button type="button" class="sanad-btn sanad-btn--md sanad-btn--primary" data-modal-retry>إعادة المحاولة</button> <a class="sanad-btn sanad-btn--md" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer">تواصل عبر واتساب</a></div>
 </div></div></div>
</dialog>
