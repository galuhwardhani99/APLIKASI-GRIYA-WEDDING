(() => {
    const $ = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => [...c.querySelectorAll(s)];
    const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

    const nav = $('#nav');
    const bar = $('#progress');
    const orbs = $$('[data-speed]');

    /* ---- Scroll: navbar, progress bar, parallax ---- */
    let ticking = false;
    function onScroll() {
        const y = window.scrollY;
        nav.classList.toggle('scrolled', y > 40);

        const max = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.transform = `scaleX(${max > 0 ? y / max : 0})`;

        if (!reduce) {
            orbs.forEach(o => {
                o.style.transform = `translate3d(0, ${y * parseFloat(o.dataset.speed)}px, 0)`;
            });
        }
        ticking = false;
    }
    addEventListener('scroll', () => {
        if (!ticking) { ticking = true; requestAnimationFrame(onScroll); }
    }, { passive: true });
    onScroll();

    /* ---- Reveal saat masuk layar ---- */
    const revealIO = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('in');
                revealIO.unobserve(e.target);
            }
        });
    }, { threshold: 0.15 });
    $$('.reveal').forEach(el => revealIO.observe(el));

    /* ---- Counter angka ---- */
    function animateCount(el) {
        const target = parseInt(el.dataset.count, 10);
        const suffix = el.dataset.suffix || '';
        if (reduce) { el.textContent = target + suffix; return; }
        const dur = 1600;
        const start = performance.now();
        (function tick(now) {
            const p = Math.min((now - start) / dur, 1);
            const eased = 1 - Math.pow(1 - p, 4);
            el.textContent = Math.round(target * eased) + suffix;
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    }
    const countIO = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { animateCount(e.target); countIO.unobserve(e.target); }
        });
    }, { threshold: 0.6 });
    $$('[data-count]').forEach(el => countIO.observe(el));

    /* ---- Menu aktif mengikuti scroll ---- */
    const links = $$('.nav-link');
    const spy = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                links.forEach(l => l.classList.toggle('active', l.getAttribute('href') === '#' + e.target.id));
            }
        });
    }, { rootMargin: '-45% 0px -50% 0px' });
    $$('section[id]').forEach(s => spy.observe(s));

    /* ---- Kartu miring 3D ---- */
    if (matchMedia('(hover: hover)').matches && !reduce) {
        $$('.tilt').forEach(card => {
            card.addEventListener('pointermove', (e) => {
                const r = card.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - 0.5;
                const y = (e.clientY - r.top) / r.height - 0.5;
                card.style.transform =
                    `perspective(900px) rotateX(${(-y * 7).toFixed(2)}deg) rotateY(${(x * 7).toFixed(2)}deg) translateY(-8px)`;
            });
            card.addEventListener('pointerleave', () => { card.style.transform = ''; });
        });
    }

    /* ---- Menu mobile ---- */
    const burger = $('#burger');
    burger.addEventListener('click', () => document.body.classList.toggle('menu-open'));
    $$('#drawer a').forEach(a => a.addEventListener('click', () => document.body.classList.remove('menu-open')));
})();