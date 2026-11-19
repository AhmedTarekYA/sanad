(() => {
    'use strict';

    const section = document.querySelector('.sanad-testimonials');
    const track = section?.querySelector('.sanad-testimonials__grid');
    const cards = track ? [...track.children] : [];
    if (cards.length < 2) return;

    const isArabic = document.documentElement.lang.startsWith('ar');
    const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)');
    const mobile = matchMedia('(max-width: 767px)');
    let page = 0;
    let dots = [];
    let scrollTimer;
    const pages = () => Math.ceil(cards.length / (mobile.matches ? 1 : 2));
    const rtl = () => getComputedStyle(track).direction === 'rtl';

    track.id = 'sanad-testimonials-track';
    section.classList.add('sanad-testimonials--slider');
    section.setAttribute('aria-roledescription', isArabic ? 'عارض شرائح' : 'carousel');
    track.tabIndex = 0;
    const controls = document.createElement('div');
    controls.className = 'sanad-testimonials__controls';
    const makeButton = (label, text) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.setAttribute('aria-label', label);
        button.setAttribute('aria-controls', track.id);
        button.textContent = text;
        return button;
    };
    const previous = makeButton(isArabic ? 'آراء الشركاء السابقة' : 'Previous partner reviews', '‹');
    const next = makeButton(isArabic ? 'آراء الشركاء التالية' : 'Next partner reviews', '›');
    const pagination = document.createElement('div');
    pagination.className = 'sanad-testimonials__dots';
    const status = document.createElement('span');
    status.className = 'sanad-sr-only';
    status.setAttribute('aria-live', 'polite');
    status.setAttribute('aria-atomic', 'true');
    controls.append(previous, pagination, next, status);
    section.append(controls);

    const update = () => {
        dots.forEach((dot, index) => {
            if (index === page) dot.setAttribute('aria-current', 'true');
            else dot.removeAttribute('aria-current');
        });
        previous.disabled = page === 0;
        next.disabled = page === pages() - 1;
        status.textContent = isArabic ? `الشريحة ${page + 1} من ${pages()}` : `Slide ${page + 1} of ${pages()}`;
    };
    const go = (index, smooth = true) => {
        page = Math.max(0, Math.min(index, pages() - 1));
        const card = cards[page * (mobile.matches ? 1 : 2)];
        const delta = rtl() ? card.getBoundingClientRect().right - track.getBoundingClientRect().right
            : card.getBoundingClientRect().left - track.getBoundingClientRect().left;
        track.scrollBy({ left: delta, behavior: smooth && !reducedMotion.matches ? 'smooth' : 'instant' });
        update();
    };
    const layout = () => {
        pagination.replaceChildren();
        dots = Array.from({ length: pages() }, (_, index) => {
            const dot = makeButton(isArabic ? `عرض الشريحة ${index + 1}` : `Show slide ${index + 1}`, '');
            dot.addEventListener('click', () => go(index));
            pagination.append(dot);
            return dot;
        });
        controls.hidden = pages() < 2;
        go(Math.min(page, pages() - 1), false);
    };
    previous.addEventListener('click', () => go(page - 1));
    next.addEventListener('click', () => go(page + 1));
    track.addEventListener('keydown', event => {
        if (event.target !== track || event.altKey || event.ctrlKey || event.metaKey) return;
        const target = { ArrowLeft: page + (rtl() ? 1 : -1), ArrowRight: page + (rtl() ? -1 : 1), Home: 0, End: pages() - 1 }[event.key];
        if (target === undefined) return;
        event.preventDefault();
        go(target);
    });
    track.addEventListener('scroll', () => {
        clearTimeout(scrollTimer);
        scrollTimer = setTimeout(() => {
            const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
            page = Math.min(pages() - 1, Math.round(Math.abs(track.scrollLeft) / (track.clientWidth + gap)));
            update();
        }, 120);
    }, { passive: true });
    new ResizeObserver(layout).observe(track);
})();
