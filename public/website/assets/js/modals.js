(function () {
  var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content;
  var lastFocus;
  function anyOpen() { return document.querySelector('dialog[open]'); }
  function show(m, name) {
    m.querySelectorAll('[data-state]').forEach(function (s) { s.hidden = s.dataset.state !== name; });
    var h = m.querySelector('[data-state="' + name + '"] h2');
    if (h && name !== 'form') h.focus();
  }
  function open(m) { if (anyOpen()) return; lastFocus = document.activeElement; show(m, 'form'); m.showModal(); }
  function wire(m) {
    var form = m.querySelector('[data-modal-form]'), btn = form.querySelector('[type=submit]'), alertEl = form.querySelector('[data-form-alert]');
    function clear() {
      alertEl.hidden = true;
      form.querySelectorAll('[data-field-error]').forEach(function (e) { e.textContent = ''; e.classList.remove('sanad-input__status--error'); });
      form.querySelectorAll('.sanad-input__control').forEach(function (e) { e.classList.remove('sanad-input__control--error'); });
    }
    function errors(errs) {
      alertEl.hidden = false;
      Object.keys(errs).forEach(function (f) {
        var e = form.querySelector('[data-field-error="' + f + '"]'), i = form.querySelector('[name="' + f + '"]');
        if (e) { e.textContent = errs[f][0]; e.classList.add('sanad-input__status--error'); }
        if (i) i.classList.add('sanad-input__control--error');
      });
    }
    form.addEventListener('submit', function (ev) {
      ev.preventDefault();
      if (btn.disabled) return;
      clear();
      btn.disabled = true; btn.setAttribute('aria-busy', 'true'); show(m, 'loading');
      fetch(form.action, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }, body: new FormData(form) })
        .then(function (r) { return r.json().then(function (d) { return { s: r.status, d: d }; }); })
        .then(function (x) {
          if (x.s === 200 && x.d.code === 200) { form.reset(); show(m, 'success'); }
          else if (x.s === 422 && x.d.errors) { show(m, 'form'); errors(x.d.errors); }
          else show(m, 'error');
        })
        .catch(function () { show(m, 'error'); })
        .finally(function () { btn.disabled = false; btn.removeAttribute('aria-busy'); });
    });
    m.querySelector('[data-modal-retry]').addEventListener('click', function () { show(m, 'form'); });
    m.addEventListener('click', function (e) { if (e.target === m || e.target.closest('[data-modal-close]')) m.close(); });
    m.addEventListener('close', function () { if (lastFocus && lastFocus.focus) lastFocus.focus(); });
  }
  document.querySelectorAll('[data-sanad-modal]').forEach(wire);
  document.addEventListener('click', function (e) {
    var t = e.target.closest('[data-free-trial-open]'), m = document.getElementById('sanad-free-trial');
    if (t && m) { e.preventDefault(); open(m); }
  });
  var exit = document.getElementById('sanad-exit-intent');
  if (exit && matchMedia('(pointer: fine)').matches) {
    document.addEventListener('mouseout', function (e) {
      if (e.relatedTarget || e.clientY > 0 || anyOpen() || sessionStorage.getItem('sanadExitShown')) return;
      sessionStorage.setItem('sanadExitShown', '1');
      open(exit);
    });
  }
})();
