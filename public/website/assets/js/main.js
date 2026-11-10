(() => {
  'use strict';

  if (window.SanadUI) return;
  const root = document.documentElement;
  const $ = (selector, scope = document) => scope.querySelector(selector);
  const $$ = (selector, scope = document) => [...scope.querySelectorAll(selector)];
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
  const events = new AbortController();
  const disposers = [];
  const listen = (target, event, handler, options = {}) => target?.addEventListener(event, handler, { ...options, signal: events.signal });
  const canAnimate = () => Boolean(window.gsap && !reduced.matches);
  const flip = () => window.Flip || window.gsap?.plugins?.Flip;
  const transient = new Set();
  const track = animation => {
    transient.add(animation);
    ['onComplete', 'onInterrupt'].forEach(event => {
      const previous = animation.eventCallback(event);
      animation.eventCallback(event, function (...args) { transient.delete(animation); previous?.apply(this, args); });
    });
    return animation;
  };
  const finishTransient = () => { [...transient].forEach(animation => { animation.progress(1); animation.kill(); }); transient.clear(); };
  const tween = (target, vars) => canAnimate() ? track(window.gsap.to(target, { overwrite: 'auto', ...vars })) : null;
  listen(reduced, 'change', () => { if (reduced.matches) finishTransient(); });

  // Keep original nodes, including their listeners, so reverting never loses author markup.
  class SanadSplitText {
    constructor(target, { type = 'lines,words', linesClass = 'sanad-line-mask', wordsClass = 'sanad-word' } = {}) {
      this.elements = typeof target === 'string' ? $$(target) : target instanceof Element ? [target] : [...(target || [])];
      this.words = [];
      this.lines = [];
      this.chars = [];
      this.originals = [];
      this.elements.forEach(element => {
        if (element.querySelector('button,input,select,textarea,a,[contenteditable=true]')) return;
        const original = document.createDocumentFragment();
        const label = element.getAttribute('aria-label');
        const text = element.textContent;
        while (element.firstChild) original.append(element.firstChild);
        element.append(original.cloneNode(true));
        this.originals.push({ element, original, label });
        element.setAttribute('aria-label', text.trim());
        const walker = document.createTreeWalker(element, NodeFilter.SHOW_TEXT, {
          acceptNode: node => node.parentElement.closest('script,style,svg,[aria-hidden=true]') ? NodeFilter.FILTER_REJECT : NodeFilter.FILTER_ACCEPT,
        });
        const textNodes = [];
        while (walker.nextNode()) textNodes.push(walker.currentNode);
        const words = [];
        // Words are the smallest unit for every language. Arabic letter shaping stays intact.
        const arabic = /[\u0600-\u06FF]/.test(text);
        this.type = arabic ? 'lines,words' : type;
        textNodes.forEach(node => {
          const fragment = document.createDocumentFragment();
          node.textContent.split(/(\s+)/u).forEach(part => {
            if (!part) return;
            if (/^\s+$/u.test(part)) fragment.append(document.createTextNode(part));
            else {
              const word = document.createElement('span');
              word.className = wordsClass;
              word.style.display = 'inline-block';
              word.textContent = part;
              word.setAttribute('aria-hidden', 'true');
              fragment.append(word);
              words.push(word);
            }
          });
          node.replaceWith(fragment);
        });
        this.words.push(...words);
        if (!this.type.includes('lines') || !words.length) return;
        const groups = [];
        words.forEach(word => {
          const top = word.offsetTop;
          const visualTop = word.getBoundingClientRect().top;
          const previous = groups.at(-1);
          if (!previous || Math.abs(previous.visualTop - visualTop) > 2) groups.push({ top, visualTop, words: [word] });
          else previous.words.push(word);
        });
        // Extract in reverse order: ranges preserve nested emphasis and mixed RTL/LTR runs.
        const lines = [];
        groups.reverse().forEach(group => {
          const range = document.createRange();
          range.setStartBefore(group.words[0]);
          range.setEndAfter(group.words.at(-1));
          const line = document.createElement('span');
          line.className = linesClass;
          line.style.cssText = 'display:block;overflow:hidden;overflow:clip;padding-block:.08em;margin-block:-.08em';
          line.setAttribute('aria-hidden', 'true');
          line.append(range.extractContents());
          range.insertNode(line);
          lines.unshift(line);
        });
        this.lines.push(...lines);
      });
    }

    revert() {
      this.originals.forEach(({ element, original, label }) => {
        element.replaceChildren(original);
        if (label === null) element.removeAttribute('aria-label');
        else element.setAttribute('aria-label', label);
      });
      this.originals = [];
      this.words = [];
      this.lines = [];
      this.chars = [];
    }
  }
  window.SanadSplitText = SanadSplitText;
  window.SplitText = window.SplitText || SanadSplitText;

  function setupTheme() {
    const buttons = $$('[data-theme-toggle]');
    const update = theme => {
      root.dataset.theme = theme;
      buttons.forEach(button => {
        button.setAttribute('aria-pressed', String(theme === 'dark'));
        button.setAttribute('aria-label', theme === 'dark' ? 'تفعيل المظهر الفاتح' : 'تفعيل المظهر الداكن');
      });
    };
    let theme = root.dataset.theme === 'dark' ? 'dark' : 'light';
    try {
      const saved = localStorage.getItem('sanad-theme');
      if (saved === 'dark' || saved === 'light') theme = saved;
    } catch { /* Private browsing can disable storage. */ }
    update(theme);
    buttons.forEach(button => listen(button, 'click', () => {
      const next = root.dataset.theme === 'dark' ? 'light' : 'dark';
      update(next);
      try { localStorage.setItem('sanad-theme', next); } catch { /* Theme still works without persistence. */ }
    }));
    listen(window, 'storage', event => {
      if (event.key === 'sanad-theme' && ['dark', 'light'].includes(event.newValue)) update(event.newValue);
    });
  }

  function setupNavigation() {
    const header = $('[data-site-header]');
    const button = $('[data-site-header-menu]', header || document);
    const nav = $('[data-site-header-nav]', header || document);
    const close = () => button?.setAttribute('aria-expanded', 'false');
    listen(button, 'click', () => button.setAttribute('aria-expanded', String(button.getAttribute('aria-expanded') !== 'true')));
    listen(nav, 'click', event => { if (event.target.closest('a')) close(); });
    listen(document, 'keydown', event => {
      if (event.key === 'Escape' && button?.getAttribute('aria-expanded') === 'true') { close(); button.focus(); }
    });
    listen(document, 'pointerdown', event => { if (header && !header.contains(event.target)) close(); });
    listen(window.matchMedia('(min-width:1024px)'), 'change', event => { if (event.matches) close(); });
    const glass = () => header?.classList.toggle('sanad-header--scrolled', window.scrollY > 24);
    listen(window, 'scroll', glass, { passive: true });
    glass();
  }

  function setupDialogs() {
    $$('dialog[data-consultation-modal], dialog#free-trial-modal').forEach(dialog => {
      const trial = dialog.id === 'free-trial-modal';
      const openers = $$(trial ? '[data-free-trial-open], a[href="#free-trial-modal"]' : '[data-site-header-cta], [data-consultation-open]');
      let returnTo;
      openers.forEach(button => listen(button, 'click', event => {
        event.preventDefault();
        if (dialog.open) return;
        returnTo = button;
        dialog.showModal();
        root.classList.add(trial ? 'ai-modal-open' : 'sanad-modal-open');
      }));
      $$('[data-consultation-close], [data-modal-close]', dialog).forEach(button => listen(button, 'click', () => dialog.close()));
      listen(dialog, 'click', event => {
        const rect = dialog.getBoundingClientRect();
        if (event.target === dialog && (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom)) dialog.close();
      });
      listen(dialog, 'keydown', event => {
        if (event.key !== 'Tab') return;
        const controls = $$('a[href],button:not(:disabled),input:not(:disabled),select:not(:disabled),textarea:not(:disabled),[tabindex="0"]', dialog).filter(el => el.getClientRects().length);
        const first = controls[0], last = controls.at(-1);
        if (event.shiftKey && (document.activeElement === first || document.activeElement === dialog)) { event.preventDefault(); last?.focus(); }
        else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first?.focus(); }
      });
      listen(dialog, 'close', () => {
        root.classList.remove(trial ? 'ai-modal-open' : 'sanad-modal-open');
        returnTo?.focus({ preventScroll: true });
      });
    });
  }

  function setupPhoneInputs() {
    const normalize = value => {
      let text = value.replace(/[\u0660-\u0669\u06f0-\u06f9]/g, char => String(char.charCodeAt(0) & 15)).replace(/[^\d+ ()-]/g, '');
      text = text.replace(/(?!^)\+/g, '');
      return text;
    };
    $$('[data-consultation-phone]').forEach(input => listen(input, 'input', event => {
      if (event.isComposing) return;
      const before = input.value, position = input.selectionStart ?? before.length;
      const next = normalize(before);
      if (next === before) return;
      input.value = next;
      const caret = normalize(before.slice(0, position)).length;
      input.setSelectionRange(caret, caret);
    }));
  }

  function setupTrialForm() {
    listen(document, 'invalid', event => {
      if (event.target.closest('.sanad-service-form, [data-trial-form], .sanad-contact')) tween(event.target, { keyframes: { x: [-8, 8, -5, 5, 0] }, duration: 0.4 });
    }, { capture: true });
    const form = $('[data-trial-form]');
    if (!form) return;
    const button = $('button[type=submit]', form), status = $('[data-form-status]', form);
    const initialLabel = button.textContent;
    let pending = false;
    listen(form, 'submit', async event => {
      event.preventDefault();
      if (pending || !form.reportValidity()) return;
      pending = true;
      button.disabled = true;
      form.setAttribute('aria-busy', 'true');
      button.textContent = 'جارٍ إرسال الطلب…';
      status.textContent = '';
      const controller = new AbortController();
      const timeout = setTimeout(() => controller.abort(), 20000);
      const cancel = () => controller.abort();
      events.signal.addEventListener('abort', cancel, { once: true });
      try {
        // Standalone HTML cannot render @csrf. Read the token from the existing Laravel page.
        const page = await fetch('/', { credentials: 'same-origin', signal: controller.signal });
        if (!page.ok) throw new Error('csrf');
        const document = new DOMParser().parseFromString(await page.text(), 'text/html');
        const token = document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value;
        if (!token) throw new Error('csrf');
        const response = await fetch(form.action, {
          method: 'POST', credentials: 'same-origin', signal: controller.signal,
          headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }, body: new FormData(form),
        });
        const data = await response.json();
        if (response.status === 422) {
          status.textContent = Object.values(data.errors || {}).flat().join(' ') || 'يرجى مراجعة الحقول المطلوبة.';
        } else if (response.ok && data.code === 200) {
          status.textContent = data.message || 'تم إرسال طلبك بنجاح. سيتواصل معك فريق Sanad CX.';
          form.reset();
        } else throw new Error('request');
      } catch (error) {
        status.textContent = error.message === 'csrf' ? 'تعذر تجهيز إرسال الطلب. يمكنك التواصل مع الفريق عبر info@sanadcx.com أو المحاولة مجدداً.' : 'تعذر إرسال الطلب. يرجى المحاولة مجدداً أو التواصل عبر info@sanadcx.com.';
      } finally {
        clearTimeout(timeout);
        events.signal.removeEventListener('abort', cancel);
        pending = false;
        button.disabled = false;
        button.textContent = initialLabel;
        form.removeAttribute('aria-busy');
      }
    });
  }

  function setupAccordions() {
    $$('.sanad-faq__trigger, .ai-faq__trigger').forEach(trigger => {
      const panel = document.getElementById(trigger.getAttribute('aria-controls'));
      if (!panel) return;
      listen(trigger, 'click', () => {
        const opening = trigger.getAttribute('aria-expanded') !== 'true';
        trigger.setAttribute('aria-expanded', String(opening));
        panel.inert = !opening;
        const chevron = $('svg, .sanad-faq__chevron, span[aria-hidden]', trigger);
        if (!canAnimate()) {
          panel.hidden = !opening; panel.style.height = '';
          if (chevron) chevron.style.transform = `rotate(${opening ? 180 : 0}deg)`;
          return;
        }
        window.gsap.killTweensOf(panel);
        const height = panel.hidden ? 0 : panel.getBoundingClientRect().height;
        panel.hidden = false;
        track(window.gsap.fromTo(panel, { height, overflow: 'hidden' }, { height: opening ? 'auto' : 0, duration: 0.4, ease: 'power3.out', onComplete: () => {
          panel.hidden = !opening;
          window.gsap.set(panel, { clearProps: 'height,overflow' });
          window.ScrollTrigger?.refresh();
        } }));
        if (chevron) tween(chevron, { rotation: opening ? 180 : 0, duration: 0.3 });
      });
    });
  }

  function setupCarousel() {
    $$('[data-carousel]').forEach(carousel => {
      const slides = $$('[data-carousel-slide]', carousel), dots = $$('[data-carousel-dot]', carousel);
      if (!slides.length) return;
      let current = Math.max(0, slides.findIndex(slide => slide.hasAttribute('data-carousel-active')));
      const rtl = () => getComputedStyle(carousel).direction === 'rtl';
      const show = (index, animate = true) => {
        const previous = current;
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => {
          slide.toggleAttribute('data-carousel-active', i === current);
          slide.setAttribute('aria-hidden', String(i !== current));
          slide.inert = i !== current;
        });
        dots.forEach((dot, i) => i === current ? dot.setAttribute('aria-current', 'true') : dot.removeAttribute('aria-current'));
        const status = $('[data-carousel-status]', carousel);
        if (status) status.textContent = `الشريحة ${current + 1} من ${slides.length}`;
        if (animate && previous !== current && canAnimate()) {
          window.gsap.killTweensOf(slides);
          track(window.gsap.fromTo(slides[current], { x: current > previous ? -48 : 48, opacity: 0 }, { x: 0, opacity: 1, duration: 0.55, ease: 'power3.out', clearProps: 'transform,opacity' }));
        }
      };
      listen($('[data-carousel-next]', carousel), 'click', () => show(current + 1));
      listen($('[data-carousel-prev]', carousel), 'click', () => show(current - 1));
      dots.forEach((dot, index) => listen(dot, 'click', () => show(index)));
      listen(carousel, 'keydown', event => {
        if (event.altKey || event.ctrlKey || event.metaKey || event.shiftKey || event.target.closest('input,textarea,select,[contenteditable=true]')) return;
        const index = { ArrowLeft: current + (rtl() ? 1 : -1), ArrowRight: current + (rtl() ? -1 : 1), Home: 0, End: slides.length - 1 }[event.key];
        if (index === undefined) return;
        event.preventDefault(); show(index);
      });
      const viewport = $('[data-carousel-viewport]', carousel);
      let start;
      listen(viewport, 'pointerdown', event => { if (event.button === 0) start = [event.clientX, event.clientY]; });
      listen(viewport, 'pointerup', event => {
        if (!start) return;
        const [x, y] = start; start = null;
        const dx = event.clientX - x, dy = event.clientY - y;
        if (Math.abs(dx) > 48 && Math.abs(dx) > Math.abs(dy)) show(current + (dx < 0 ? (rtl() ? 1 : -1) : (rtl() ? -1 : 1)));
      });
      listen(viewport, 'pointercancel', () => { start = null; });
      listen(viewport, 'dragstart', event => event.preventDefault());
      show(current, false);
    });
  }

  function setupCalculator() {
    $$('[data-sanad-calculator], .sanad-calculator').forEach(calculator => {
      const range = $('[data-calculator-range]', calculator), thumb = $('[data-calculator-thumb]', calculator), value = $('[data-calculator-value]', calculator);
      if (!range || !thumb || !value) return;
      const presets = $$('[data-calculator-preset]', calculator), values = [50, 100, 500, 1000];
      const outputs = $$('.sanad-calculator__output', calculator);
      const format = number => number >= 1000 ? '+1,000' : Math.round(number).toLocaleString('en-US');
      const counter = { value: 50 };
      let volume = 50;
      thumb.setAttribute('aria-valuemin', '50'); thumb.setAttribute('aria-valuemax', '1000');
      range.style.touchAction = 'pan-y';
      presets.forEach((button, index) => {
        if (!values[index]) return;
        button.dataset.calculatorPreset = String(values[index]);
        const label = $('span', button) || button;
        label.textContent = format(values[index]);
      });
      $$('.sanad-calculator__stop', calculator).forEach((stop, index) => {
        if (values[index]) stop.style.insetInlineStart = `calc(${(values[index] - 50) / 950} * (100% - 44px))`;
      });
      $$('.sanad-calculator__limits span', calculator).forEach((label, index) => { label.textContent = index ? '+1,000' : '50'; });
      const update = (next, animate = true) => {
        volume = Math.max(50, Math.min(1000, Math.round(next)));
        const active = $('.sanad-calculator__preset[aria-pressed="true"]', calculator);
        const targets = [active, ...outputs].filter(Boolean);
        const state = animate && canAnimate() && flip() ? flip().getState(targets) : null;
        range.style.setProperty('--sanad-calculator-pos', (volume - 50) / 950);
        thumb.setAttribute('aria-valuenow', String(volume)); thumb.setAttribute('aria-valuetext', format(volume));
        presets.forEach(button => button.setAttribute('aria-pressed', String(Number(button.dataset.calculatorPreset) === volume)));
        const tier = volume < 100 ? 0 : volume < 500 ? 1 : volume < 1000 ? 2 : 3;
        const packages = ['باقة البداية — 12 ساعة', 'باقة النمو — 12 ساعة', 'باقة التوسع — 24 ساعة', 'باقة مخصصة — 24 ساعة'];
        const notes = ['مناسبة تجريبياً لـ 50–99 محادثة يومياً.', 'مناسبة تجريبياً لـ 100–499 محادثة يومياً.', 'مناسبة تجريبياً لـ 500–999 محادثة يومياً.', 'مناسبة تجريبياً لـ 1,000 محادثة يومياً فأكثر.'];
        const savings = [15, 20, 30, 35];
        const set = (selector, text, scope) => { const element = $(selector, scope); if (element) element.textContent = text; };
        if (outputs[0]) { set('.sanad-calculator__output-value', packages[tier], outputs[0]); set('.sanad-calculator__output-note', notes[tier], outputs[0]); }
        if (outputs[1]) { set('.sanad-calculator__output-value', `توفير تقديري ${savings[tier]}%`, outputs[1]); set('.sanad-calculator__output-note', 'أرقام افتراضية للعرض وليست عرض سعر.', outputs[1]); }
        if (animate && canAnimate()) {
          tween(counter, { value: volume, duration: 0.6, ease: 'power2.out', onUpdate: () => { value.textContent = format(counter.value); } });
          if (state) track(flip().from(state, { duration: 0.5, ease: 'expo.out', stagger: 0.04, absolute: false }));
        } else { counter.value = volume; value.textContent = format(volume); }
      };
      const pointer = event => {
        const rect = range.getBoundingClientRect(), padding = Math.min(22, rect.width / 4);
        const position = Math.max(0, Math.min(1, (event.clientX - rect.left - padding) / (rect.width - 2 * padding)));
        update(50 + position * 950, false);
      };
      listen(range, 'pointerdown', event => { if (event.button !== 0) return; range.setPointerCapture(event.pointerId); pointer(event); thumb.focus({ preventScroll: true }); });
      listen(range, 'pointermove', event => { if (range.hasPointerCapture(event.pointerId)) pointer(event); });
      listen(thumb, 'keydown', event => {
        const next = { ArrowRight: volume + 1, ArrowLeft: volume - 1, ArrowUp: volume + 1, ArrowDown: volume - 1, PageUp: volume + 50, PageDown: volume - 50, Home: 50, End: 1000 }[event.key];
        if (next !== undefined) { event.preventDefault(); update(next); }
      });
      presets.forEach(button => listen(button, 'click', () => update(Number(button.dataset.calculatorPreset))));
      update(50, false);
      disposers.push(() => window.gsap?.killTweensOf(counter));
    });
  }

  function setupBilling() {
    $$('[data-billing-toggle]').forEach(group => {
      const prices = $$('[data-price-monthly]');
      prices.forEach(price => price.setAttribute('aria-live', 'polite'));
      $$('[data-billing]', group).forEach(button => listen(button, 'click', () => {
        if (button.getAttribute('aria-pressed') === 'true') return;
        const yearly = button.dataset.billing === 'yearly';
        const state = canAnimate() && flip() ? flip().getState($$('.ai-pricing__card')) : null;
        $$('[data-billing]', group).forEach(control => control.setAttribute('aria-pressed', String(control === button)));
        prices.forEach(price => { price.textContent = yearly ? price.dataset.priceYearly : price.dataset.priceMonthly; });
        $$('[data-price-note]').forEach(note => { note.textContent = yearly ? note.dataset.noteYearly : note.dataset.noteMonthly; });
        if (state) track(flip().from(state, { duration: 0.45, ease: 'power3.out' }));
        if (canAnimate()) track(window.gsap.fromTo(prices, { opacity: 0.25, y: 6 }, { opacity: 1, y: 0, duration: 0.35, overwrite: true }));
        window.ScrollTrigger?.refresh();
      }));
    });
  }

  function setupSteps() {
    $$('.sanad-home-steps').forEach(section => {
      const cards = $$('.sanad-home-steps__card', section);
      const select = card => cards.forEach(item => {
        item.classList.toggle('sanad-home-steps__card--active', item === card);
        item.setAttribute('aria-pressed', String(item === card));
      });
      cards.forEach((card, index) => {
        listen(card, 'click', () => select(card));
        listen(card, 'focus', () => select(card));
        listen(card, 'keydown', event => {
          if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); select(card); }
          const move = { ArrowLeft: 1, ArrowRight: -1 }[event.key];
          if (move) { event.preventDefault(); const next = cards[(index + move + cards.length) % cards.length]; select(next); next.focus(); }
        });
      });
    });
  }

  const tocSelector = '.sanad-legal__toc-link, .sanad-privacy-hero__toc-link, .sanad-privacy-toc__link, .sanad-privacy-contents__link, .sanad-terms-contents__link';
  function setupAnchorsAndSpy() {
    if (window.gsap && window.ScrollToPlugin) {
      // Native CSS smooth scrolling fights ScrollToPlugin and triggers autoKill.
      const previous = root.style.scrollBehavior;
      root.style.scrollBehavior = 'auto';
      disposers.push(() => { root.style.scrollBehavior = previous; });
    }
    const links = $$(tocSelector);
    const targets = links.map(link => { try { return document.getElementById(decodeURIComponent(link.hash.slice(1))); } catch { return null; } });
    const activate = target => links.forEach((link, index) => {
      const active = targets[index] === target;
      link.classList.toggle('active', active); link.classList.toggle('is-active', active);
      if (active) link.setAttribute('aria-current', 'location'); else link.removeAttribute('aria-current');
    });
    if (links.length && window.IntersectionObserver) {
      const observer = new IntersectionObserver(entries => entries.forEach(entry => { if (entry.isIntersecting) activate(entry.target); }), { rootMargin: '-20% 0px -55% 0px' });
      targets.filter(Boolean).forEach(target => observer.observe(target));
      disposers.push(() => observer.disconnect());
    }
    listen(document, 'click', event => {
      const link = event.target.closest('a[href*="#"]');
      if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || link.target || link.hasAttribute('download')) return;
      const url = new URL(link.href, location.href);
      if (url.origin !== location.origin || url.pathname !== location.pathname || url.search !== location.search || !url.hash || url.hash === '#free-trial-modal') return;
      let target;
      try { target = document.getElementById(decodeURIComponent(url.hash.slice(1))); } catch { return; }
      if (!target) return;
      event.preventDefault();
      const focus = () => {
        const temporary = !target.hasAttribute('tabindex');
        if (temporary) { target.tabIndex = -1; target.addEventListener('blur', () => target.removeAttribute('tabindex'), { once: true }); }
        target.focus({ preventScroll: true });
        activate(target);
      };
      history.pushState(null, '', url.hash);
      if (canAnimate() && window.ScrollToPlugin) tween(window, { scrollTo: { y: target, offsetY: ($('[data-site-header]')?.offsetHeight || 0) + 24, autoKill: true }, duration: 0.7, ease: 'power3.inOut', onComplete: focus });
      else { target.scrollIntoView({ behavior: reduced.matches ? 'instant' : 'smooth' }); focus(); }
    });
  }

  function boot() {
    setupTheme(); setupNavigation(); setupDialogs(); setupPhoneInputs(); setupTrialForm();
    setupAccordions(); setupCarousel(); setupCalculator(); setupBilling(); setupSteps(); setupAnchorsAndSpy();
    setupMotion();
  }

  window.SanadUI = { destroy() { finishTransient(); events.abort(); disposers.forEach(dispose => dispose()); window.SanadMotion?.destroy(); } };
  if (document.readyState === 'loading') listen(document, 'DOMContentLoaded', boot, { once: true });
  else boot();

  function setupMotion() {
    const g = window.gsap, ST = window.ScrollTrigger;
    const state = { available: Boolean(g && ST), specs: [], errors: [], reduced: reduced.matches };
    window.SanadMotion = state;
    if (!g || !ST) { state.destroy = () => {}; return; }
    g.registerPlugin(ST, ...[window.ScrollToPlugin, window.Flip].filter(Boolean));
    let context, motionEvents, splits = [], resizeTimer, width = window.innerWidth;
    let stopped = false, headerIntroduced = false;
    const entered = new WeakSet();
    const on = (target, event, callback, options = {}) => target?.addEventListener(event, callback, { ...options, signal: motionEvents.signal });
    const cleanup = () => {
      motionEvents?.abort();
      context?.revert();
      splits.forEach(split => split.revert());
      splits = [];
    };
    const build = () => {
      if (stopped) return;
      cleanup();
      state.specs = []; state.errors = []; state.reduced = reduced.matches;
      motionEvents = new AbortController();
      const cachedSplits = new WeakMap();
      const splitText = (element, type = 'lines,words') => {
        if (!element) return { words: [], lines: [] };
        if (cachedSplits.has(element)) return cachedSplits.get(element);
        const split = new SanadSplitText(element, { type });
        splits.push(split); cachedSplits.set(element, split);
        return split;
      };
      const trigger = (element, start = 'top 80%') => ({ trigger: element, start, once: true });
      const from = (target, vars = {}, anchor) => {
        const targets = typeof target === 'string' ? $$(target) : target instanceof Element ? [target] : [...(target || [])];
        if (!targets.length) return;
        const focusable = 'a[href],button,input,select,textarea,[tabindex]';
        const fade = targets.some(element => element.matches(focusable) || element.querySelector(focusable)) ? { opacity: 0 } : { autoAlpha: 0 };
        const safeVars = { ...vars };
        if ('x' in vars) safeVars.x = (index, element) => {
          const distance = typeof vars.x === 'function' ? vars.x(index, element) : vars.x;
          const rect = element.getBoundingClientRect();
          return distance < 0 ? Math.max(distance, -Math.max(0, rect.left)) : Math.min(distance, Math.max(0, window.innerWidth - rect.right));
        };
        if (anchor) return g.from(targets, { y: 40, ...fade, stagger: 0.1, duration: 0.8, ease: 'power3.out', ...safeVars, scrollTrigger: trigger(anchor) });
        targets.forEach(element => {
          if (entered.has(element)) return;
          g.from(element, { y: 40, ...fade, duration: 0.8, ease: 'power3.out', ...safeVars, onComplete: () => entered.add(element), scrollTrigger: trigger(element) });
        });
      };
      const heading = (selector, vars = {}) => $$(selector).forEach(element => {
        if (entered.has(element) || !element.getClientRects().length) return;
        const split = splitText(element);
        if (!split.words.length) return;
        g.from(split.words, { yPercent: 115, stagger: 0.04, duration: 0.9, ease: 'expo.out', ...vars, onComplete: () => entered.add(element), scrollTrigger: trigger(element, 'top 88%') });
      });
      const batch = (selector, vars = {}, max = 8) => {
        const targets = $$(selector).filter(element => !entered.has(element));
        if (!targets.length) return;
        // Opacity keeps off-screen links and accordions reachable by keyboard.
        g.set(targets, { opacity: 0, y: vars.y ?? 40 });
        ST.batch(targets, { start: 'top 85%', once: true, batchMax: max, interval: 0.1, onEnter: elements => {
          context.add(() => {
            g.to(elements, { autoAlpha: 1, y: 0, stagger: 0.1, duration: 0.8, ease: 'power3.out', ...vars, onComplete: () => elements.forEach(element => entered.add(element)), overwrite: 'auto' });
          });
        } });
      };
      const scrub = (selector, fromVars, toVars, anchor, start = 'top bottom', end = 'bottom top') => {
        $$(selector).forEach(element => g.fromTo(element, fromVars, { ...toVars, ease: 'none', scrollTrigger: { trigger: anchor || element, start, end, scrub: toVars.scrub ?? 0.8, invalidateOnRefresh: true } }));
      };
      const count = selector => $$(selector).forEach(element => {
        const original = element.textContent;
        // Keep ratios (24/7), response-time ranges and other compound metrics intact.
        const normalized = original.replace(/[\u0660-\u0669\u06f0-\u06f9]/g, char => String(char.charCodeAt(0) & 15));
        const matches = normalized.match(/\d[\d,]*(?:\.\d+)?/g);
        if (!matches || matches.length !== 1 || entered.has(element)) return;
        const token = matches[0], final = Number(token.replaceAll(',', ''));
        if (!Number.isFinite(final)) return;
        const decimal = token.includes('.') ? token.split('.')[1].length : 0;
        const arabicDigits = /[\u0660-\u0669]/.test(original);
        const counter = { value: 0 };
        g.to(counter, { value: final, duration: 1.8, ease: 'power2.out', scrollTrigger: trigger(element, 'top 82%'), onUpdate: () => {
          let number = counter.value.toFixed(decimal);
          if (token.includes(',')) number = Number(number).toLocaleString('en-US', { minimumFractionDigits: decimal, maximumFractionDigits: decimal });
          if (arabicDigits) number = number.replace(/\d/g, digit => String.fromCharCode(0x0660 + Number(digit)));
          element.textContent = normalized.replace(token, number);
        }, onComplete: () => { element.textContent = original; entered.add(element); } });
        on(window, 'sanad:motion-reset', () => { element.textContent = original; });
      });
      const draw = (selector, anchor, scrubbed = false) => $$(selector).forEach(path => {
        if (typeof path.getTotalLength !== 'function') return;
        const length = path.hasAttribute('pathLength') ? Number(path.getAttribute('pathLength')) : path.getTotalLength();
        g.fromTo(path, { strokeDasharray: length, strokeDashoffset: length }, { strokeDashoffset: 0, duration: 1.2, ease: 'power2.inOut', scrollTrigger: { trigger: anchor || path, start: 'top 78%', ...(scrubbed ? { end: 'bottom 60%', scrub: 1 } : { once: true }) } });
      });
      const tilt = selector => {
        if (!finePointer.matches) return;
        $$(selector).forEach(element => {
          const x = g.quickTo(element, 'rotationX', { duration: 0.4, ease: 'power3.out' });
          const y = g.quickTo(element, 'rotationY', { duration: 0.4, ease: 'power3.out' });
          g.set(element, { transformPerspective: 900 });
          on(element, 'pointermove', event => { const rect = element.getBoundingClientRect(); x((0.5 - (event.clientY - rect.top) / rect.height) * 7); y(((event.clientX - rect.left) / rect.width - 0.5) * 7); });
          on(element, 'pointerleave', () => { x(0); y(0); });
        });
      };
      const magnetic = selector => {
        if (!finePointer.matches) return;
        $$(selector).forEach(element => {
          const x = g.quickTo(element, 'x', { duration: 0.35, ease: 'power3.out' });
          const y = g.quickTo(element, 'y', { duration: 0.35, ease: 'power3.out' });
          on(element, 'pointermove', event => { const rect = element.getBoundingClientRect(); x((event.clientX - rect.left - rect.width / 2) * 0.15); y((event.clientY - rect.top - rect.height / 2) * 0.2); });
          on(element, 'pointerleave', () => { x(0); y(0); });
          on(element, 'blur', () => { x(0); y(0); });
        });
      };
      const floatInView = (selector, anchor) => {
        const targets = $$(selector);
        if (!targets.length) return;
        const floating = g.to(targets, { y: -6, stagger: 0.2, duration: 2.2, ease: 'sine.inOut', yoyo: true, repeat: -1, paused: true });
        ST.create({ trigger: anchor || targets[0], start: 'top bottom', end: 'bottom top', onToggle: self => self.isActive && !document.hidden ? floating.play() : floating.pause() });
        on(document, 'visibilitychange', () => { if (document.hidden) floating.pause(); else if (ST.isInViewport(anchor || targets[0])) floating.play(); });
      };
      const spec = (id, selector, callback) => {
        const mounted = Boolean($(selector));
        state.specs.push({ id, selector, mounted });
        if (mounted && !reduced.matches) callback($(selector));
      };
      context = g.context(() => {});
      context.add(() => {
        spec('00.header', '[data-site-header]', header => {
          if (!headerIntroduced) { g.from(header, { yPercent: -100, duration: 0.7, ease: 'expo.out' }); headerIntroduced = true; }
          const reveal = () => g.to(header, { yPercent: 0, duration: 0.3, ease: 'power3.out', overwrite: 'auto' });
          on(header, 'focusin', reveal);
          ST.create({ start: 'top -80', end: 'max', onUpdate: self => {
            const stayVisible = window.scrollY < 80 || header.contains(document.activeElement) || $('[data-site-header-menu][aria-expanded=true]', header) || $('dialog[open]');
            g.to(header, { yPercent: stayVisible || self.direction < 0 ? 0 : -100, duration: 0.35, ease: 'power3.out', overwrite: 'auto' });
          } });
        });
        spec('home.01.hero', '.sanad-hero', hero => {
          const tl = g.timeline({ defaults: { ease: 'power3.out' } });
          const eyebrow = $('.sanad-hero__eyebrow', hero);
          const headline = $('.sanad-hero__headline', hero);
          const desc = $('.sanad-hero__description', hero);
          const actions = $$('.sanad-hero__actions .sanad-btn', hero);
          const trust = $$('.sanad-hero__trust-item', hero);
          const visual = $('.sanad-hero__visual', hero);
          const globe = $('.sanad-hero__globe', hero);
          const glow = $('.sanad-hero__glow', hero);

          if (eyebrow) tl.from(eyebrow, { y: -25, autoAlpha: 0, scale: 0.9, duration: 0.6, ease: 'back.out(1.8)' });
          if (headline) {
            const split = splitText(headline);
            if (split.words.length) tl.from(split.words, { y: 45, autoAlpha: 0, stagger: 0.04, duration: 0.85, ease: 'power4.out' }, '-=0.4');
            else tl.from(headline, { y: 35, autoAlpha: 0, duration: 0.8 }, '-=0.4');
          }
          if (desc) tl.from(desc, { y: 25, autoAlpha: 0, duration: 0.7 }, '-=0.5');
          if (actions.length) tl.from(actions, { y: 20, autoAlpha: 0, scale: 0.9, stagger: 0.1, duration: 0.7, ease: 'back.out(2)' }, '-=0.4');
          if (trust.length) tl.from(trust, { y: 20, autoAlpha: 0, stagger: 0.08, duration: 0.6 }, '-=0.3');
          if (visual) tl.from(visual, { scale: 0.82, autoAlpha: 0, rotationY: -10, duration: 1.2, ease: 'power3.out' }, 0.1);

          if (globe) {
            g.to(globe, { y: -18, duration: 3.2, yoyo: true, repeat: -1, ease: 'sine.inOut' });
          }
          if (glow) {
            g.to(glow, { scale: 1.35, opacity: 0.9, duration: 2.6, yoyo: true, repeat: -1, ease: 'sine.inOut' });
          }
          from('.sanad-hero__chip', { y: 24, stagger: 0.12 }, hero);
          scrub('.sanad-hero__visual', { yPercent: 0 }, { yPercent: 12 }, hero, 'top top', 'bottom top');
          if (finePointer.matches) {
            const movers = $$('.sanad-hero__globe, .sanad-hero__chip', hero).map((element, index) => ({ x: g.quickTo(element, 'x', { duration: 0.6 }), y: g.quickTo(element, 'y', { duration: 0.6 }), depth: index ? 10 : 18 }));
            on(hero, 'pointermove', event => { const rect = hero.getBoundingClientRect(); movers.forEach(move => { move.x(((event.clientX - rect.left) / rect.width - 0.5) * move.depth); move.y(((event.clientY - rect.top) / rect.height - 0.5) * move.depth); }); });
            on(hero, 'pointerleave', () => movers.forEach(move => { move.x(0); move.y(0); }));
          }
        });
        spec('home.02.stats', '.sanad-stats', section => { count('.sanad-stats__value'); from('.sanad-stats__item', { y: 24, stagger: 0.1 }, section); });
        spec('home.03.integration-services', '.sanad-integration, .sanad-home-services', () => {
          heading('.sanad-integration__title, .sanad-home-services__title');
          $$('.sanad-integration, .sanad-home-services').forEach(section => from($$('.sanad-integration__benefit, .sanad-home-services__card', section), { y: 64, rotationX: 8, stagger: 0.12 }, section));
          tilt('.sanad-integration__benefit, .sanad-home-services__card, .sanad-card-hoverable');
          draw('.sanad-home-services .service-icon path');
        });
        spec('home.04.fikr', '.sanad-home-fkr', section => {
          scrub('.sanad-home-fkr__portal', { clipPath: 'inset(6% 4% round 32px)', scale: 0.96 }, { clipPath: 'inset(0% 0% round 24px)', scale: 1 }, section, 'top 85%', 'top 25%');
          heading('.sanad-home-fkr__title', { ease: 'power4.out', duration: 1.15 });
          from('.sanad-home-fkr__pillar', { stagger: 0.12 }, section);
        });
        spec('home.05.comparison', '.sanad-comparison', section => {
          from('.sanad-comparison__card', { stagger: 0.12 }, section);
          from('.sanad-comparison__criterion, .sanad-comparison__row', { x: -24, y: 0, stagger: 0.08 }, section);
          const featured = $('.sanad-comparison__card--sanad', section);
          if (featured) g.fromTo(featured, { scale: 0.98 }, { scale: 1.02, boxShadow: '0 0 28px rgba(56,211,155,0.12)', duration: 0.9, scrollTrigger: trigger(featured) });
        });
        spec('home.06.ai', '.sanad-home-ai', section => {
          const timeline = g.timeline({ scrollTrigger: trigger(section, 'top 68%') });
          const incoming = $$('.chat-incoming', section), badges = $$('.ai-copilot-badge', section), replies = $$('.ai-reply-text', section);
          if (incoming.length) timeline.from(incoming, { y: 24, autoAlpha: 0, duration: 0.5 });
          if (badges.length) timeline.from(badges, { scale: 0.8, autoAlpha: 0, ease: 'back.out(1.7)' });
          replies.forEach(reply => timeline.from(splitText(reply, 'words').words, { autoAlpha: 0, y: 8, stagger: 0.025, duration: 0.4 }));
          floatInView('.sanad-home-ai__tag', section);
        });
        spec('home.07.testimonials', '.sanad-testimonials', section => {
          $$('.sanad-testimonials__quote', section).filter(element => element.getClientRects().length).forEach(element => { const split = splitText(element); if (split.lines.length) g.from(split.lines, { yPercent: 100, opacity: 0, stagger: 0.07, duration: 0.75, scrollTrigger: trigger(section) }); });
        });
        spec('home.08.steps', '.sanad-home-steps', section => {
          from('.sanad-home-steps__card', { y: 40, stagger: 0.15 }, section);
          from('.sanad-home-steps__connector', { scaleX: 0, y: 0, transformOrigin: 'right', stagger: 0.15 }, section);
          const cards = $$('.sanad-home-steps__card', section);
          cards.forEach(card => ST.create({ trigger: card, start: 'top 65%', onEnter: () => { cards.forEach(item => item.classList.toggle('sanad-home-steps__card--active', item === card)); }, onEnterBack: () => { cards.forEach(item => item.classList.toggle('sanad-home-steps__card--active', item === card)); } }));
          draw('.sanad-home-steps .progress-line', section, true);
        });
        spec('home.09.calculator', '.sanad-calculator', section => from([section], { scale: 0.96, y: 0 }));
        spec('home.10.privacy', '.sanad-privacy-banner', section => {
          heading('.sanad-privacy-banner__title');
          from('.sanad-privacy-banner__shield, .sanad-privacy-banner__icon, .sanad-privacy-banner__glow', { scale: 0.7, y: 0, duration: 1.2 }, section);
          draw('.sanad-privacy-banner .shield-path', section);
          floatInView('.sanad-privacy-banner__glow', section);
        });
        spec('home.11.faq', '.sanad-faq', () => batch('.sanad-faq__item', { duration: 0.65 }));
        spec('home.12.contact-footer', '.sanad-contact, .sanad-footer, .fikr-footer, .ai-footer', () => {
          from('.sanad-contact .sanad-input', { y: 30, stagger: 0.06 }, $('.sanad-contact'));
          magnetic('.sanad-contact__submit, .sanad-hero__cta, .magnetic-btn, .sanad-how-cta__button');
          $$('.sanad-footer, .fikr-footer, .ai-footer').forEach(footer => g.fromTo(footer, { yPercent: -15 }, { yPercent: 0, ease: 'none', scrollTrigger: { trigger: footer, start: 'top bottom', end: 'bottom bottom', scrub: true } }));
        });
        spec('services.01.hero', '.sanad-services-hero', hero => {
          const tl = g.timeline({ defaults: { ease: 'power3.out' } });
          const badge = $('.sanad-services-hero__badge', hero);
          const headline = $('.sanad-services-hero__headline', hero);
          const desc = $('.sanad-services-hero__description', hero);
          const actions = $$('.sanad-services-hero__actions .sanad-btn', hero);
          const panel = $('.sanad-services-hero__panel', hero);
          const tiles = $$('.sanad-services-hero__tile', hero);

          if (badge) tl.from(badge, { y: -25, autoAlpha: 0, duration: 0.6, ease: 'back.out(1.8)' });
          if (headline) {
            const split = splitText(headline);
            if (split.words.length) tl.from(split.words, { y: 45, autoAlpha: 0, stagger: 0.04, duration: 0.85, ease: 'power4.out' }, '-=0.4');
            else tl.from(headline, { y: 35, autoAlpha: 0, duration: 0.8 }, '-=0.4');
          }
          if (desc) tl.from(desc, { y: 25, autoAlpha: 0, duration: 0.7 }, '-=0.5');
          if (actions.length) tl.from(actions, { y: 20, autoAlpha: 0, scale: 0.9, stagger: 0.1, duration: 0.7, ease: 'back.out(2)' }, '-=0.4');
          if (panel) tl.from(panel, { scale: 0.85, autoAlpha: 0, duration: 1.1, ease: 'power3.out' }, 0.1);
          if (tiles.length) tl.from(tiles, { scale: 0.8, autoAlpha: 0, y: 20, stagger: 0.08, duration: 0.7, ease: 'back.out(1.8)' }, '-=0.5');
        });
        spec('services.02.disciplines', '.sanad-services-detail', () => {
          $$('.sanad-services-detail__card').forEach(card => {
            from([card]);
            from($$('.sanad-services-detail__detail, .sanad-services-detail__tag', card), { x: -24, y: 0, stagger: 0.07 }, card);
          });
        });
        spec('services.03.difference', '.sanad-differ', () => {
          batch('.differ-card, .sanad-differ__card', { scale: 1 });
          if (finePointer.matches) $$('.differ-card, .sanad-differ__card').forEach(card => {
            on(card, 'pointermove', event => { const rect = card.getBoundingClientRect(); card.style.setProperty('--mouse-x', `${event.clientX - rect.left}px`); card.style.setProperty('--mouse-y', `${event.clientY - rect.top}px`); });
            on(card, 'pointerleave', () => { card.style.removeProperty('--mouse-x'); card.style.removeProperty('--mouse-y'); });
          });
        });
        spec('services.04.roi', '.sanad-roi', section => { count('.sanad-roi__card-value'); from('.sanad-roi__card', { stagger: 0.1 }, section); draw('.sla-ring', section); });
        spec('services.05.industries', '.sanad-industries', section => from('.sanad-industries__card, .sanad-industries__use-case', { x: 40, y: 0, stagger: 0.06 }, section));
        spec('services.06.form-cta', '.sanad-service-form, .sanad-services-cta', () => { from('.sanad-service-form .sanad-input, .sanad-service-form .request-field', { y: 24, stagger: 0.06 }, $('.sanad-service-form')); from('.sanad-services-cta', { scale: 0.94 }); });
        spec('how.01.hero', '.sanad-how-hero', hero => {
          const tl = g.timeline({ defaults: { ease: 'power3.out' } });
          const badge = $('.sanad-how-hero__badge', hero);
          const title = $('.sanad-how-hero__title', hero);
          const desc = $('.sanad-how-hero__description', hero);
          const actions = $$('.sanad-how-hero__actions .sanad-btn', hero);
          const milestones = $$('.sanad-how-journey__milestone', hero);

          if (badge) tl.from(badge, { y: -25, autoAlpha: 0, duration: 0.6, ease: 'back.out(1.8)' });
          if (title) {
            const split = splitText(title);
            if (split.words.length) tl.from(split.words, { y: 45, autoAlpha: 0, stagger: 0.04, duration: 0.85, ease: 'power4.out' }, '-=0.4');
            else tl.from(title, { y: 35, autoAlpha: 0, duration: 0.8 }, '-=0.4');
          }
          if (desc) tl.from(desc, { y: 25, autoAlpha: 0, duration: 0.7 }, '-=0.5');
          if (actions.length) tl.from(actions, { y: 20, autoAlpha: 0, scale: 0.9, stagger: 0.1, duration: 0.7, ease: 'back.out(2)' }, '-=0.4');
          if (milestones.length) tl.from(milestones, { scale: 0.75, autoAlpha: 0, stagger: 0.12, duration: 0.8, ease: 'back.out(1.8)' }, '-=0.4');
        });
        spec('how.02.process', '.sanad-how-process', section => {
          from('.sanad-how-process__step', { stagger: 0.15 }, section);
          scrub('.vertical-timeline-fill, .sanad-how-process__progress', { scaleY: 0 }, { scaleY: 1, transformOrigin: 'top' }, section, 'top 55%', 'bottom 65%');
          $$('.sanad-how-process__step', section).forEach(step => ST.create({ trigger: step, start: 'top 60%', end: 'bottom 40%', toggleClass: 'is-active' }));
        });
        spec('how.03.systems', '.sanad-systems', section => from('.sanad-systems__card, .sanad-systems__tag', { scale: 0.7, y: 0, stagger: { amount: 0.6, from: 'center' }, ease: 'back.out(1.6)' }, section));
        spec('how.04.security-continuity-cta', '.sanad-security, .sanad-continuity, .sanad-how-cta', () => {
          $$('.sanad-security, .sanad-continuity').forEach(section => from($$('.sanad-security__card, .sanad-continuity__card', section), { stagger: 0.1 }, section));
          from('.sanad-how-cta', { scale: 0.96 }); draw('.sanad-security .security-path');
        });
        spec('about.01.hero', '.sanad-about-hero', hero => {
          const tl = g.timeline({ defaults: { ease: 'power3.out' } });
          const badge = $('.sanad-about-hero__badge', hero);
          const headline = $('.sanad-about-hero__headline', hero);
          const desc = $('.sanad-about-hero__description', hero);
          const identity = $('.sanad-about-hero__identity', hero);
          const pillars = $$('.sanad-about-hero__pillar', hero);

          if (badge) tl.from(badge, { y: -25, autoAlpha: 0, duration: 0.6, ease: 'back.out(1.8)' });
          if (headline) {
            const split = splitText(headline);
            if (split.words.length) tl.from(split.words, { y: 45, autoAlpha: 0, stagger: 0.04, duration: 0.85, ease: 'power4.out' }, '-=0.4');
            else tl.from(headline, { y: 35, autoAlpha: 0, duration: 0.8 }, '-=0.4');
          }
          if (desc) tl.from(desc, { y: 25, autoAlpha: 0, duration: 0.7 }, '-=0.5');
          if (identity) tl.from(identity, { scale: 0.85, autoAlpha: 0, duration: 1.1, ease: 'power3.out' }, 0.1);
          if (pillars.length) tl.from(pillars, { y: 30, autoAlpha: 0, stagger: 0.1, duration: 0.7, ease: 'power3.out' }, '-=0.4');
          scrub('.sanad-about-hero__identity', { yPercent: -4 }, { yPercent: 8 }, hero);
        });
        spec('about.02.story', '.sanad-our-story', section => {
          $$('.sanad-our-story__description', section).forEach(paragraph => g.fromTo(splitText(paragraph, 'words').words, { opacity: 0.25 }, { opacity: 1, stagger: 0.05, ease: 'none', scrollTrigger: { trigger: paragraph, start: 'top 75%', end: 'bottom 55%', scrub: 0.5 } }));
        });
        spec('about.03.vision', '.sanad-vision', section => from('.sanad-vision__card', { x: i => i === 0 ? 50 : -50, y: 0, stagger: 0.1 }, section));
        spec('about.04.pillars', '.sanad-three-pillars, .sanad-about-hero__pillars', section => { from('.pillar-item, .sanad-three-pillars__item, .sanad-about-hero__pillar', { y: 48, stagger: 0.14 }, section); scrub('.sanad-three-pillars__divider', { scaleY: 0 }, { scaleY: 1, transformOrigin: 'top' }, section); });
        spec('about.05.values-partnership', '.sanad-values, .sanad-partnership', () => { batch('.sanad-values__card, .sanad-partnership__card'); tilt('.sanad-values__card, .sanad-partnership__card'); });
        spec('blog.01.hero-featured', '.sanad-blog-hero', () => { heading('.sanad-blog-hero__headline, .sanad-blog-hero__title'); from('.sanad-blog-featured, .sanad-blog-featured__card, .sanad-blog-hero__featured', { clipPath: 'inset(100% 0 0 0)', duration: 1.1 }); });
        spec('blog.02.grid', '.sanad-blog-card', () => {
          batch('.sanad-blog-card', {}, 3);
          if (finePointer.matches) $$('.sanad-blog-card, .sanad-blog-featured').forEach(card => {
            const image = $('img', card); if (!image) return;
            const zoom = g.to(image, { scale: 1.05, duration: 0.45, paused: true });
            on(card, 'pointerenter', () => zoom.play()); on(card, 'pointerleave', () => zoom.reverse());
          });
        });
        spec('article.01.hero-progress', '.sanad-article-hero', () => {
          heading('.sanad-article-hero__title');
          const body = $('.sanad-article-body');
          if (!body) return;
          let bar = $('.reading-progress-bar, .sanad-reading-progress');
          if (!bar) { bar = document.createElement('div'); bar.className = 'sanad-reading-progress'; bar.setAttribute('aria-hidden', 'true'); document.body.append(bar); on(window, 'sanad:motion-reset', () => bar.remove()); }
          g.fromTo(bar, { scaleX: 0, transformOrigin: 'right' }, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: body, start: 'top top', end: 'bottom bottom', scrub: 0.2 } });
        });
        spec('article.02.body-related', '.sanad-article-body, .sanad-article-related', () => { from('.sanad-article-section, .sanad-article-body__content h2, .sanad-article-body__content h3, .sanad-article-body__content blockquote'); batch('.sanad-article-related__card, .sanad-article-related .sanad-article-card', {}, 3); });
        const legal = page => {
          const links = $$(tocSelector);
          links.forEach(link => {
            const clause = document.getElementById(link.hash.slice(1)); if (!clause) return;
            ST.create({ trigger: clause, start: 'top 35%', end: 'bottom 35%', onToggle: self => { link.classList.toggle('is-active', self.isActive); if (self.isActive) link.setAttribute('aria-current', 'location'); else link.removeAttribute('aria-current'); } });
          });
          from(`.sanad-${page}-clause, .sanad-legal-clause`, { y: 24, duration: 0.6 });
          const toc = $(`.sanad-${page}-contents, .sanad-${page}-toc, .sanad-${page}-hero__panel, .sanad-legal__toc`);
          const body = $(`.sanad-${page}-clauses`);
          if (toc && body && window.innerWidth >= 1024 && toc.offsetHeight < window.innerHeight - 150) ST.create({ trigger: toc, start: 'top 140px', endTrigger: body, end: 'bottom 75%', pin: true, pinReparent: true, pinSpacing: false, invalidateOnRefresh: true });
        };
        spec('privacy.01.legal', '.sanad-privacy-hero, .sanad-legal--privacy', () => legal('privacy'));
        spec('terms.01.legal', '.sanad-terms-hero, .sanad-legal--terms', () => legal('terms'));
        spec('fikr.01.hero', '.fikr-hero, .fkr__hero', section => {
          heading('.fikr-hero__title, #fkr-title, .fkr__hero h1', { yPercent: 120, duration: 1.15, ease: 'power4.out', stagger: 0.05 });
          from('.editorial-img-wrap, .fkr__hero-copy p, .fkr__lead', { y: 20, stagger: 0.08, duration: 0.8 }, section);
          from('.fikr-original-logo, .fkr__logo', { y: 0, scale: 1.15, duration: 1.3, ease: 'power4.out' }, section);
          from('.fkr__btn, .fikr-button', { scale: 0.9, duration: 0.7, ease: 'back.out(1.8)' }, section);
        });
        spec('fikr.02.marquee-philosophy', '.fikr-expertise, .fkr__strip', section => {
          const track = $('.fikr-marquee-track, .fkr__track', section);
          if (track) {
            const loop = g.fromTo(track, { xPercent: -50 }, { xPercent: 0, duration: 34, repeat: -1, ease: 'none', onReverseComplete() { this.totalTime(this.rawTime() + this.duration() * 100); } });
            const settle = g.quickTo(loop, 'timeScale', { duration: 0.8, ease: 'power2.out' });
            let idle;
            ST.create({ onUpdate: self => { const speed = Math.min(5, 1 + Math.abs(self.getVelocity()) / 600); settle(self.direction * speed); clearTimeout(idle); idle = setTimeout(() => settle(self.direction), 180); } });
            on(document, 'visibilitychange', () => document.hidden ? loop.pause() : loop.play());
            on(window, 'sanad:motion-reset', () => clearTimeout(idle));
          }
          heading('.fikr-philosophy h2, .fkr__phil h2');
          $$('.fikr-philosophy__text p, .fkr__phil-copy p').forEach(paragraph => g.fromTo(splitText(paragraph, 'words').words, { opacity: 0.3 }, { opacity: 1, stagger: 0.04, ease: 'none', scrollTrigger: { trigger: paragraph, start: 'top 85%', end: 'bottom 55%', scrub: 0.5 } }));
        });
        spec('fikr.03.disciplines', '.fikr-services-section, .fkr__svcs', section => {
          heading('.fikr-services-section h2, .fkr__head h2');
          $$('.fkr-discipline, .fkr__svc', section).forEach(row => {
            from([row], { y: 24 });
            const divider = $('.divider, .fkr__rule', row);
            if (divider) g.from(divider, { scaleX: 0, transformOrigin: 'right', duration: 1, ease: 'expo.out', scrollTrigger: trigger(row) });
            const number = $('b, .fkr__num', row);
            if (number) g.fromTo(number, { y: 12 }, { y: -12, ease: 'none', scrollTrigger: { trigger: row, start: 'top bottom', end: 'bottom top', scrub: true } });
          });
        });
        spec('fikr.04.portraits', '.fikr-industries, .fkr__inds', () => {
          heading('.fikr-industries h2, .fkr__inds h2');
          $$('.fikr-photo, .fkr__ind').forEach(photo => {
            from([photo], { y: 24, duration: 1.2 });
            const inner = $('.portrait-img, img', photo);
            if (inner) g.fromTo(inner, { yPercent: -8 }, { yPercent: 8, ease: 'none', scrollTrigger: { trigger: photo, start: 'top bottom', end: 'bottom top', scrub: true } });
          });
        });
        spec('fikr.05.method-consultation', '.fikr-method, .fkr__meth', section => {
          heading('.fikr-method h2, .fikr-cta h2, .fkr__meth h2, .fkr__cta h2', { duration: 1.15, ease: 'power4.out' });
          from('.method-step, .fkr__step', { y: 40, stagger: 0.15, duration: 0.9 }, section);
          draw('.growth-loop__path', section, true);
          $$('.method-step, .fkr__step', section).forEach(step => ST.create({ trigger: step, start: 'top 70%', end: 'bottom 30%', toggleClass: 'is-active' }));
        });
        spec('ai.01.hero', '.ai-hero', section => {
          heading('.ai-hero__title, #ai-hero-title', { stagger: 0.035, duration: 0.85 });
          from('.ai-dashboard-mockup, .ai-art', { rotationX: 14, scale: 0.92, y: 50, duration: 1.1 }, section);
          from('.ai-flow-node, .ai-hcard', { y: 20, stagger: 0.16 }, section);
        });
        spec('ai.02.ecosystem-shift', '.ai-ecosystem, .ai-eco, .ai-shift', () => {
          const lines = $$('.data-stream-line');
          if (lines.length) {
            const pulse = g.to(lines, { strokeDashoffset: -120, repeat: -1, duration: 1.8, ease: 'none', paused: true });
            ST.create({ trigger: $('.ai-ecosystem, .ai-eco'), start: 'top bottom', end: 'bottom top', onToggle: self => self.isActive ? pulse.play() : pulse.pause() });
            on(document, 'visibilitychange', () => document.hidden ? pulse.pause() : ST.isInViewport($('.ai-ecosystem, .ai-eco')) && pulse.play());
          }
          from('.ai-pills span, .ai-eco__hub, .ai-eco__node', { scale: 0.8, y: 20, stagger: 0.08 }, $('.ai-ecosystem, .ai-eco'));
          from('.ai-shift__card, .ai-canvas', { x: i => i ? -40 : 40, y: 0, stagger: 0.12 }, $('.ai-shift'));
          const after = $('.ai-shift__card--after, .ai-canvas--after');
          if (after) { const reply = $('.ai-reply-text', after); const timeline = g.timeline({ scrollTrigger: trigger(after, 'top 68%') }); timeline.from($('.chat-incoming', after), { y: 24, opacity: 0 }).from($('.ai-copilot-badge', after), { scale: 0.8, opacity: 0, ease: 'back.out(1.7)' }); if (reply) timeline.from(splitText(reply, 'words').words, { opacity: 0, stagger: 0.025, duration: 0.4 }); }
        });
        spec('ai.03.walkthrough', '.ai-walkthrough, .ai-steps', section => {
          const steps = $$('.ai-walkthrough__step, .ai-step', section), visual = $('.copilot-visual, .ai-demo', section), stage = $('.copilot-stage', section);
          from(steps, { stagger: 0.15 }, section);
          if (visual && stage && window.innerWidth >= 1024 && visual.offsetHeight < window.innerHeight - 160) {
            ST.create({ trigger: visual, start: 'top 128px', end: () => `+=${Math.min(600, Math.max(240, window.innerHeight * 0.5))}`, pin: visual, pinSpacing: true, invalidateOnRefresh: true, onUpdate: self => {
              const current = Math.min(steps.length - 1, Math.floor(self.progress * steps.length));
              steps.forEach((step, index) => step.classList.toggle('is-active', index === current));
              const caption = $('[data-copilot-caption]', visual); if (caption && steps[current]) caption.textContent = $('h3', steps[current]).textContent;
            } });
            g.from('.copilot-extension', { rotationY: -8, scale: 0.95, duration: 1, scrollTrigger: { trigger: visual, start: 'top 70%', end: 'top 25%', scrub: 1 } });
          } else from('.copilot-visual, .ai-demo', { scale: 0.96 });
        });
        spec('ai.04.telemetry-pricing', '.ai-ops, .ai-pricing-section, .ai-plans', () => {
          from('.telemetry-bar, .ai-kpi__chart i', { scaleY: 0, y: 0, transformOrigin: 'bottom', stagger: 0.06, duration: 0.8, ease: 'expo.out' }, $('.ai-ops'));
          from('.ai-pricing__card, .ai-plan', { stagger: 0.1 }, $('.ai-pricing-section, .ai-plans'));
          const featured = $('.ai-pricing--featured, .ai-plan--p');
          if (featured) g.to(featured, { boxShadow: '0 0 32px rgba(51,126,252,.2)', duration: 1.2, scrollTrigger: trigger(featured) });
          batch('.ai-faq__item, .ai-faq__row'); heading('.ai-ops>h2, .ai-pricing-section>h2, .ai-plans>h2');
        });
      });
      ST.refresh();
    };
    const rebuild = () => {
      window.dispatchEvent(new Event('sanad:motion-reset'));
      try { build(); } catch (error) {
        state.errors.push(String(error));
        cleanup();
        console.error('Sanad motion initialization failed; content remains available.', error);
      }
    };
    state.destroy = () => { stopped = true; clearTimeout(resizeTimer); window.dispatchEvent(new Event('sanad:motion-reset')); cleanup(); };
    listen(reduced, 'change', () => {
      // Finish transient UI animations before turning motion off mid-interaction.
      if (reduced.matches) {
        $$('.sanad-faq__trigger, .ai-faq__trigger').forEach(button => {
          const panel = document.getElementById(button.getAttribute('aria-controls'));
          if (panel) { g.killTweensOf(panel); panel.hidden = button.getAttribute('aria-expanded') !== 'true'; g.set(panel, { clearProps: 'height,overflow' }); }
        });
      }
      rebuild();
    });
    listen(finePointer, 'change', rebuild);
    listen(window, 'resize', () => {
      if (width === window.innerWidth) return;
      width = window.innerWidth; clearTimeout(resizeTimer); resizeTimer = setTimeout(rebuild, 180);
    }, { passive: true });
    listen(window, 'pageshow', () => ST.refresh());
    listen(window, 'load', () => ST.refresh(), { once: true });
    if (document.fonts?.ready) document.fonts.ready.then(() => { if (!stopped) rebuild(); });
    else rebuild();
  }
})();
