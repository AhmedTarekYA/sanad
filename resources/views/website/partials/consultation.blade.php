<dialog class="sanad-consultation" id="sanad-consultation" data-consultation-modal tabindex="-1" aria-labelledby="sanad-consultation-title" aria-describedby="sanad-consultation-description">
 <button type="button" class="sanad-consultation__close" data-consultation-close aria-label="إغلاق نافذة الاستشارة">×</button>
 <div class="sanad-consultation__scroll">
  <div class="sanad-consultation__container">
   <div class="sanad-consultation__layout">
    <div class="sanad-consultation__header">
     <h2 class="sanad-consultation__title" id="sanad-consultation-title">جاهز للارتقاء بتجربة عملائك <span class="sanad-consultation__title-accent">وتسريع نموك</span>؟</h2>
     <p class="sanad-consultation__description" id="sanad-consultation-description">اترك بياناتك و سيتواصل معك أحد خبراء التشغيل في <span lang="en" dir="ltr">Sanad CX</span> <br>لتقديم استشارة مجانية وحزمة مخصصة.</p>
    </div>
    <form class="sanad-consultation__form" id="sanad-consultation-form" novalidate>
     @csrf
     <div class="sanad-consultation__group">
      <div class="sanad-input">
       <label class="sanad-input__label" for="sanad-consultation-full-name">الاسم الكريم</label>
       <div class="sanad-input__field">
        <input class="sanad-input__control" id="sanad-consultation-full-name" type="text" name="full_name" placeholder="الاسم الكريم" autocomplete="name" required>
       </div>
       <span class="sanad-input__status" data-field-error="full_name" aria-live="polite"></span>
      </div>
      <div class="sanad-input">
       <label class="sanad-input__label" for="sanad-consultation-company-name">اسم الشركة / البراند</label>
       <div class="sanad-input__field">
        <input class="sanad-input__control" id="sanad-consultation-company-name" type="text" name="company_name" placeholder="اسم الشركة / البراند" autocomplete="organization" required>
       </div>
       <span class="sanad-input__status" data-field-error="company_name" aria-live="polite"></span>
      </div>
      <div class="sanad-input">
       <label class="sanad-input__label" for="sanad-consultation-mobile">رقم الموبايل / الواتساب</label>
       <div class="sanad-input__field">
        <input class="sanad-input__control" id="sanad-consultation-mobile" type="tel" name="mobile_whatsapp" inputmode="tel" placeholder="رقم الموبايل / الواتساب" autocomplete="tel" data-consultation-phone required>
       </div>
       <span class="sanad-input__status" data-field-error="mobile_whatsapp" aria-live="polite"></span>
      </div>
     </div>
     <div class="sanad-input sanad-input--select">
      <label class="sanad-input__label" for="sanad-consultation-volume">حجم التواصل اليومي</label>
      <div class="sanad-input__field">
       <select class="sanad-input__control" id="sanad-consultation-volume" name="daily_contact_volume" required>
        <option value="">اختر</option>
        <option value="أقل من 50 تواصل">أقل من 50 تواصل</option>
        <option value="50 - 200 تواصل">50 - 200 تواصل</option>
        <option value="200 - 500 تواصل">200 - 500 تواصل</option>
        <option value="أكثر من 500 تواصل">أكثر من 500 تواصل</option>
       </select>
       <svg class="sanad-input__toggle" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M4.18 6.13 8 9.21l3.82-3.08" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <span class="sanad-input__status" data-field-error="daily_contact_volume" aria-live="polite"></span>
     </div>
     <div class="sanad-input">
      <label class="sanad-input__label" for="sanad-consultation-systems">&#160;البرامج أو الأنظمة المستخدمة حالياً <span class="sanad-input__optional">"اختياري"</span></label>
      <div class="sanad-input__field">
       <input class="sanad-input__control" id="sanad-consultation-systems" type="text" name="current_systems" placeholder="البرامج أو الأنظمة المستخدمة حالياً">
      </div>
     </div>
     <button type="submit" class="sanad-btn sanad-btn--md sanad-btn--primary sanad-consultation__submit" id="sanad-consultation-submit">حجز جلسة استشارية مجانية لنمو عملائك</button>
    </form>
   </div>
  </div>
 </div>
</dialog>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script>
(function () {
    'use strict';

    var form = document.getElementById('sanad-consultation-form');
    var submitBtn = document.getElementById('sanad-consultation-submit');
    var modal = document.getElementById('sanad-consultation');
    if (!form || !submitBtn || !modal) return;

    function clearErrors() {
        form.querySelectorAll('[data-field-error]').forEach(function (el) {
            el.textContent = '';
            el.classList.remove('sanad-input__status--error');
        });
        form.querySelectorAll('.sanad-input__control').forEach(function (el) {
            el.classList.remove('sanad-input__control--error');
        });
    }

    function showFieldErrors(errors) {
        Object.keys(errors).forEach(function (field) {
            var errorEl = form.querySelector('[data-field-error="' + field + '"]');
            var inputEl = form.querySelector('[name="' + field + '"]');
            if (errorEl) {
                errorEl.textContent = errors[field][0];
                errorEl.classList.add('sanad-input__status--error');
            }
            if (inputEl) {
                inputEl.classList.add('sanad-input__control--error');
            }
        });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        var isLoading = submitBtn.dataset.loading === 'true';
        if (isLoading) return;

        submitBtn.dataset.loading = 'true';
        submitBtn.disabled = true;

        var formData = new FormData(form);

        fetch('{{ route('website.consultation.store') }}', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData,
        })
        .then(function (res) { return res.json().then(function (data) { return { status: res.status, data: data }; }); })
        .then(function (result) {
            if (result.status === 200 && result.data.code === 200) {
                modal.close();
                form.reset();
                Swal.fire({
                    icon: 'success',
                    title: 'تم الإرسال بنجاح',
                    text: result.data.message,
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: 'var(--sanad-color-primary, #6c5ce7)',
                    timer: 5000,
                    timerProgressBar: true,
                });
            } else if (result.status === 422 && result.data.errors) {
                showFieldErrors(result.data.errors);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'حدث خطأ',
                    text: result.data.message || 'يرجى المحاولة مرة أخرى.',
                    confirmButtonText: 'حسناً',
                });
            }
        })
        .catch(function () {
            Swal.fire({ icon: 'error', title: 'حدث خطأ', text: 'تعذر الاتصال بالخادم.', confirmButtonText: 'حسناً' });
        })
        .finally(function () {
            submitBtn.dataset.loading = 'false';
            submitBtn.disabled = false;
        });
    });
})();
</script>
@endpush
