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

    /* ----- Membership wizard (progressive enhancement) -------------------- */
    var wizardForm = document.querySelector('.wizard-form');
    if (wizardForm) {
        var wSteps = Array.prototype.slice.call(wizardForm.querySelectorAll('.wizard-step'));
        var wProgress = Array.prototype.slice.call(wizardForm.querySelectorAll('.wizard-progress__step'));
        var wCurrent = 0;

        var wRender = function () {
            wProgress.forEach(function (el, i) {
                el.classList.toggle('is-active', i === wCurrent);
                el.classList.toggle('is-done', i < wCurrent);
            });
        };

        var wGoTo = function (i) {
            if (i < 0 || i >= wSteps.length) return;
            wSteps[wCurrent].classList.remove('is-current');
            wCurrent = i;
            wSteps[wCurrent].classList.add('is-current');
            wRender();
            wizardForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        var wValidateCurrent = function () {
            var fields = wSteps[wCurrent].querySelectorAll('input, textarea, select');
            var ok = true;
            fields.forEach(function (f) { if (!f.checkValidity()) ok = false; });
            if (!ok) {
                var firstInvalid = wSteps[wCurrent].querySelector(':invalid');
                if (firstInvalid) firstInvalid.reportValidity();
            }
            return ok;
        };

        wizardForm.classList.add('is-wizard');
        wSteps[0].classList.add('is-current');
        wRender();

        wizardForm.querySelectorAll('.wizard-next').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (wValidateCurrent()) wGoTo(wCurrent + 1);
            });
        });
        wizardForm.querySelectorAll('.wizard-back').forEach(function (btn) {
            btn.addEventListener('click', function () { wGoTo(wCurrent - 1); });
        });

        /* Enter key on an earlier step advances instead of submitting early */
        wizardForm.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA' && wCurrent < wSteps.length - 1) {
                e.preventDefault();
                if (wValidateCurrent()) wGoTo(wCurrent + 1);
            }
        });
    }

    /* ----- Tabs (progressive enhancement) --------------------------------- */
    document.querySelectorAll('.tabs').forEach(function (tabs) {
        var navBtns = Array.prototype.slice.call(tabs.querySelectorAll('.tab-nav__btn'));
        var panels = Array.prototype.slice.call(tabs.querySelectorAll('.tab-panel'));
        if (!navBtns.length || !panels.length) return;

        var activate = function (key) {
            navBtns.forEach(function (b) { b.classList.toggle('is-active', b.getAttribute('data-tab') === key); });
            panels.forEach(function (p) { p.classList.toggle('is-active', p.getAttribute('data-tab') === key); });
        };

        tabs.classList.add('is-tabs');

        var initial = navBtns[0].getAttribute('data-tab');
        var hashKey = (window.location.hash || '').replace('#', '');
        if (hashKey && navBtns.some(function (b) { return b.getAttribute('data-tab') === hashKey; })) {
            initial = hashKey;
        }
        activate(initial);

        navBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var key = btn.getAttribute('data-tab');
                activate(key);
                if (window.history && window.history.replaceState) {
                    window.history.replaceState(null, '', '#' + key);
                }
            });
        });
    });

    /* ----- Growth charts (Apache ECharts, progressive enhancement) -------- */
    if (window.echarts) {
        document.querySelectorAll('.growth-chart__canvas').forEach(function (el) {
            var labels = JSON.parse(el.getAttribute('data-labels') || '[]');
            var values = JSON.parse(el.getAttribute('data-values') || '[]');
            var format = el.getAttribute('data-format') || 'number';
            var color = el.getAttribute('data-color') || '#6a1b2a';

            var formatValue = function (v) {
                if (format === 'money') return 'Rs. ' + Number(v).toLocaleString('en-US');
                if (format === 'count') return v + (Number(v) === 1 ? ' member' : ' members');
                return v;
            };

            var chart = echarts.init(el);
            chart.setOption({
                color: [color],
                grid: { left: 8, right: 28, top: 16, bottom: 26, containLabel: true },
                xAxis: {
                    type: 'category',
                    data: labels,
                    boundaryGap: false,
                    axisLine: { lineStyle: { color: '#e6e0d8' } },
                    axisTick: { show: false },
                    axisLabel: { color: '#8a827e', fontSize: 11 },
                },
                yAxis: {
                    type: 'value',
                    splitLine: { lineStyle: { color: '#efe7dc' } },
                    axisLabel: {
                        color: '#8a827e',
                        fontSize: 11,
                        formatter: function (v) {
                            if (format === 'money') {
                                if (v >= 1000000) return (v / 1000000) + 'M';
                                if (v >= 1000) return (v / 1000) + 'k';
                            }
                            return v;
                        },
                    },
                },
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: '#fff',
                    borderColor: '#e6e0d8',
                    textStyle: { color: '#22201f' },
                    formatter: function (params) {
                        var p = params[0];
                        return p.axisValueLabel + '<br>' + formatValue(p.data);
                    },
                },
                series: [{
                    type: 'line',
                    data: values,
                    smooth: true,
                    symbolSize: 7,
                    lineStyle: { width: 3 },
                    areaStyle: { color: color, opacity: 0.08 },
                    itemStyle: { color: color },
                }],
            });

            window.addEventListener('resize', function () { chart.resize(); });
        });
    }

    /* ----- Footer year --------------------------------------------------- */
    var yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();
})();
