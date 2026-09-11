/* Dutugemunu College OSA — vanilla JS, no build step. */
(function () {
    'use strict';

    /* ----- Mobile navigation ------------------------------------------------ */
    var toggle = document.querySelector('.nav-toggle');
    var body = document.body;

    if (toggle) {
        var backdrop = document.createElement('div');
        backdrop.className = 'nav-backdrop';
        body.appendChild(backdrop);

        var closeNav = function () {
            body.classList.remove('nav-open');
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', function () {
            var open = body.classList.toggle('nav-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        backdrop.addEventListener('click', closeNav);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeNav();
        });
        document.querySelectorAll('.nav a').forEach(function (link) {
            link.addEventListener('click', closeNav);
        });
    }

    /* ----- Sticky header shadow ------------------------------------------- */
    var header = document.querySelector('.site-header');
    if (header) {
        var onScroll = function () {
            header.classList.toggle('is-stuck', window.scrollY > 8);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    /* ----- Hero background slideshow ----------------------------------- */
    var calm = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var heroBg = document.querySelector('.hero__bg');
    if (heroBg) {
        var hSlides = heroBg.querySelectorAll('.hero__slide');
        var hDots = document.querySelectorAll('.hero__dots button');
        var hCards = document.querySelectorAll('.hero__artshot');
        var hIndex = 0;
        var hTimer = null;
        var INTERVAL = 5000;

        var retrigger = function (el) {
            el.classList.remove('is-active');
            void el.offsetWidth;                 /* force reflow -> restart CSS animation */
            el.classList.add('is-active');
        };

        var heroGo = function (n) {
            hSlides[hIndex].classList.remove('is-active');
            if (hDots[hIndex]) hDots[hIndex].classList.remove('is-active');
            hIndex = (n + hSlides.length) % hSlides.length;
            retrigger(hSlides[hIndex]);
            if (hDots[hIndex]) retrigger(hDots[hIndex]);
            hCards.forEach(function (img, i) {
                img.classList.toggle('is-active', i === hIndex);
            });
        };

        var heroStart = function () {
            if (calm || hSlides.length < 2 || hTimer) return;
            hTimer = setInterval(function () { heroGo(hIndex + 1); }, INTERVAL);
        };
        var heroStop = function () {
            if (hTimer) { clearInterval(hTimer); hTimer = null; }
        };

        hDots.forEach(function (dot, i) {
            dot.addEventListener('click', function () {
                heroStop();
                heroGo(i);
                heroStart();
            });
        });

        /* pause while the tab is hidden */
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) { heroStop(); } else { heroStart(); }
        });

        heroStart();
    }

    /* ----- Reveal on scroll -------------------------------------------------- */
    var revealEls = Array.prototype.slice.call(document.querySelectorAll('.reveal'));
    var show = function (el) { el.classList.add('is-visible'); };

    if (revealEls.length && 'IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    show(entry.target);
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0, rootMargin: '0px 0px -10% 0px' });

        var sweep = function () {
            var h = window.innerHeight || document.documentElement.clientHeight;
            revealEls.forEach(function (el) {
                if (el.classList.contains('is-visible')) return;
                /* anything already at or above the fold shows now (covers deep links / scroll-up) */
                if (el.getBoundingClientRect().top < h * 1.15) {
                    show(el);
                    io.unobserve(el);
                }
            });
        };

        revealEls.forEach(function (el) { io.observe(el); });
        sweep();
        window.addEventListener('load', sweep);
        /* last-resort safety net so content is never left hidden */
        setTimeout(function () { revealEls.forEach(show); }, 2500);
    } else {
        revealEls.forEach(show);
    }

    /* ----- Gallery lightbox ----------------------------------------------- */
    var galleryLinks = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
    if (galleryLinks.length) {
        var box = document.createElement('div');
        box.className = 'lightbox';
        box.innerHTML =
            '<button class="lightbox__close" aria-label="Close">&times;</button>' +
            '<button class="lightbox__nav lightbox__nav--prev" aria-label="Previous">&#8249;</button>' +
            '<img alt="">' +
            '<button class="lightbox__nav lightbox__nav--next" aria-label="Next">&#8250;</button>';
        body.appendChild(box);

        var boxImg = box.querySelector('img');
        var current = 0;

        var showImage = function (i) {
            current = (i + galleryLinks.length) % galleryLinks.length;
            var link = galleryLinks[current];
            boxImg.src = link.getAttribute('href');
            boxImg.alt = link.getAttribute('data-caption') || '';
            box.classList.add('is-open');
        };
        var hide = function () { box.classList.remove('is-open'); };

        galleryLinks.forEach(function (link, i) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                showImage(i);
            });
        });

        box.querySelector('.lightbox__close').addEventListener('click', hide);
        box.querySelector('.lightbox__nav--prev').addEventListener('click', function () { showImage(current - 1); });
        box.querySelector('.lightbox__nav--next').addEventListener('click', function () { showImage(current + 1); });
        box.addEventListener('click', function (e) { if (e.target === box) hide(); });
        document.addEventListener('keydown', function (e) {
            if (!box.classList.contains('is-open')) return;
            if (e.key === 'Escape') hide();
            if (e.key === 'ArrowLeft') showImage(current - 1);
            if (e.key === 'ArrowRight') showImage(current + 1);
        });
    }

    /* ----- Inert forms: friendly notice --------------------------------- */
    document.querySelectorAll('form[data-demo]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var note = form.querySelector('.form__result');
            if (!note) {
                note = document.createElement('p');
                note.className = 'form__result';
                note.style.cssText = 'margin-top:1rem;padding:0.9rem 1rem;border-radius:4px;background:#f3e6e6;color:#6a1b2a;font-weight:600;';
                form.appendChild(note);
            }
            note.textContent = 'Thank you. This is a demonstration form — please email ' +
                (form.getAttribute('data-email') || 'the Association') + ' directly for now.';
            note.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });

    /* ----- Footer year --------------------------------------------------- */
    var yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();
})();
