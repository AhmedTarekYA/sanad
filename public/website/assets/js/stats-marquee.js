(() => {
  'use strict';

  function initStatsMarquee() {
    const root = document.querySelector('[data-stats-slider]');
    if (!root) return;

    const track = root.querySelector('[data-stats-track]') || root.querySelector('.sanad-stats__track');
    const viewport = root.querySelector('.sanad-stats__viewport');
    if (!track || !viewport) return;

    const originalItems = [...track.children].filter(el => !el.hasAttribute('data-stats-clone'));
    if (!originalItems.length) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const isRtl = () => (window.getComputedStyle(track).direction === 'rtl');
    const perView = () => (window.innerWidth < 640 ? 2 : window.innerWidth < 1024 ? 3 : 4);

    let loop = null;
    let isHovered = false;
    let isFocused = false;
    let isInView = false;
    let lastWidth = window.innerWidth;
    let resizeTimer = null;
    let intersectionObserver = null;
    let gsapRetryTimer = null;
    const disposers = [];
    const originalTabIndex = root.getAttribute('tabindex');
    root.tabIndex = 0;
    function listen(target, event, listener, options) {
      target.addEventListener(event, listener, options);
      disposers.push(() => target.removeEventListener(event, listener, options));
    }

    // Ensure stat values display accurately from data-stat-value or current text
    originalItems.forEach(item => {
      const val = item.querySelector('[data-stat-value]');
      if (val && val.dataset.statValue) {
        val.textContent = val.dataset.statValue;
        val.classList.remove('is-counting');
      }
    });

    function clearClones() {
      track.querySelectorAll('[data-stats-clone]').forEach(clone => clone.remove());
    }

    function createClones() {
      clearClones();
      originalItems.forEach(item => {
        const clone = item.cloneNode(true);
        clone.setAttribute('data-stats-clone', '');
        clone.setAttribute('aria-hidden', 'true');

        // Remove any id to guarantee NO duplicate IDs in document
        if (clone.id) clone.removeAttribute('id');
        clone.querySelectorAll('[id]').forEach(el => el.removeAttribute('id'));

        // Prevent cloned elements from receiving focus
        clone.querySelectorAll('a, button, input, select, textarea, [tabindex]').forEach(el => {
          el.setAttribute('tabindex', '-1');
          el.setAttribute('aria-hidden', 'true');
        });

        track.appendChild(clone);
      });
    }

    function applyItemDimensions() {
      const basis = (100 / perView()) + '%';
      [...track.children].forEach(item => {
        item.style.flex = `0 0 ${basis}`;
        item.style.minInlineSize = '0';
        item.style.boxSizing = 'border-box';
      });
    }

    function clearInlineDimensions() {
      track.style.transform = '';
      track.style.transition = '';
      track.style.willChange = '';
      if (window.gsap) {
        window.gsap.killTweensOf(track);
        window.gsap.set(track, { clearProps: 'all' });
      }
      originalItems.forEach(item => {
        item.style.flex = '';
        item.style.width = '';
        item.style.minInlineSize = '';
        item.style.transform = '';
      });
    }

    function setupMarquee(preserveProgress = 0) {
      delete root.dataset.statsStatic;
      if (reducedMotion.matches) {
        setupReducedMotion();
        return;
      }

      createClones();
      applyItemDimensions();

      if (loop) {
        loop.kill();
        loop = null;
      }

      const g = window.gsap;
      if (!g) {
        // If GSAP is still loading asynchronously, wait for it
        clearInterval(gsapRetryTimer);
        let retries = 0;
        gsapRetryTimer = setInterval(() => {
          retries++;
          if (window.gsap) {
            clearInterval(gsapRetryTimer);
            setupMarquee(preserveProgress);
          } else if (retries > 30) {
            clearInterval(gsapRetryTimer);
            clearClones();
            clearInlineDimensions();
            root.dataset.statsStatic = '';
          }
        }, 50);
        return;
      }

      const rtl = isRtl();
      // The track stays viewport-wide; measure one complete set, not half the track.
      const firstClone = track.querySelector('[data-stats-clone]');
      const distance = Math.abs(firstClone.offsetLeft - originalItems[0].offsetLeft);
      const targetX = rtl ? distance : -distance;
      const duration = Math.max(20, originalItems.length * 4); // ~28s for 7 items, consistent with Fikr ticker pace

      g.set(track, { x: 0, xPercent: 0 });

      loop = g.fromTo(track,
        { x: 0 },
        {
          x: targetX,
          duration,
          ease: 'none',
          repeat: -1,
          onReverseComplete() {
            this.totalTime(this.rawTime() + this.duration() * 100);
          }
        }
      );

      if (preserveProgress > 0 && preserveProgress < 1) {
        loop.progress(preserveProgress);
      }

      syncPlayState();
    }

    function setupReducedMotion() {
      clearInterval(gsapRetryTimer);
      if (loop) {
        loop.kill();
        loop = null;
      }
      clearClones();
      clearInlineDimensions();
    }

    function syncPlayState() {
      if (reducedMotion.matches || !loop) return;
      const shouldPlay = isInView && !isHovered && !isFocused && !document.hidden;
      if (shouldPlay) {
        if (loop.paused()) loop.play();
      } else {
        if (!loop.paused()) loop.pause();
      }
    }

    function onResize() {
      if (window.innerWidth === lastWidth) return;
      lastWidth = window.innerWidth;
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (reducedMotion.matches) return;
        const currentProgress = loop ? loop.progress() : 0;
        setupMarquee(currentProgress);
      }, 150);
    }

    function onReducedMotionChange(e) {
      if (e.matches) {
        setupReducedMotion();
      } else {
        setupMarquee(0);
      }
    }

    // Interaction listeners: pause on hover, keyboard focus
    listen(root, 'mouseenter', () => {
      isHovered = true;
      syncPlayState();
    });
    listen(root, 'mouseleave', () => {
      isHovered = false;
      syncPlayState();
    });
    listen(root, 'focusin', () => {
      isFocused = true;
      syncPlayState();
    });
    listen(root, 'focusout', () => {
      isFocused = false;
      syncPlayState();
    });

    // Pause when document hidden or tab switched
    listen(document, 'visibilitychange', () => {
      syncPlayState();
    });

    // Pause when out-of-view via IntersectionObserver
    if ('IntersectionObserver' in window) {
      intersectionObserver = new IntersectionObserver(entries => {
        isInView = Boolean(entries[0]?.isIntersecting);
        syncPlayState();
      }, { threshold: 0.05 });
      intersectionObserver.observe(root);
    } else {
      isInView = true;
    }

    // Media query listener for prefers-reduced-motion
    if (typeof reducedMotion.addEventListener === 'function') {
      listen(reducedMotion, 'change', onReducedMotionChange);
    } else if (typeof reducedMotion.addListener === 'function') {
      reducedMotion.addListener(onReducedMotionChange);
      disposers.push(() => reducedMotion.removeListener(onReducedMotionChange));
    }

    // Resize listener
    listen(window, 'resize', onResize, { passive: true });

    // Handle global motion reset event from main.js
    listen(window, 'sanad:motion-reset', () => {
      if (!reducedMotion.matches) {
        setupMarquee(0);
      }
    });

    // Initial setup
    if (reducedMotion.matches) {
      setupReducedMotion();
    } else {
      setupMarquee(0);
    }

    // Expose cleanup/api for testing or external coordination
    window.SanadStatsMarquee = {
      rebuild: () => setupMarquee(loop ? loop.progress() : 0),
      destroy: () => {
        clearInterval(gsapRetryTimer);
        clearTimeout(resizeTimer);
        if (loop) loop.kill();
        clearClones();
        clearInlineDimensions();
        intersectionObserver?.disconnect();
        disposers.forEach(dispose => dispose());
        if (originalTabIndex === null) root.removeAttribute('tabindex');
        else root.setAttribute('tabindex', originalTabIndex);
      },
      pause: () => loop?.pause(),
      play: () => loop?.play()
    };
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initStatsMarquee, { once: true });
  } else {
    initStatsMarquee();
  }
})();
