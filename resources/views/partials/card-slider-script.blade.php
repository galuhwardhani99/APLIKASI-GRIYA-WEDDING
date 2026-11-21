@once
<script>
    document.querySelectorAll('[data-catalog-slider]').forEach((slider) => {
        const track = slider.querySelector('.catalog-slider-track');
        const previous = slider.querySelector('[data-slider-prev]');
        const next = slider.querySelector('[data-slider-next]');
        if (!track || !previous || !next) return;

        const updateButtons = () => {
            const maxScroll = track.scrollWidth - track.clientWidth;
            const hasOverflow = maxScroll > 2;
            slider.classList.toggle('is-static', !hasOverflow);
            previous.disabled = !hasOverflow || track.scrollLeft <= 2;
            next.disabled = !hasOverflow || track.scrollLeft >= maxScroll - 2;
        };
        const move = (direction) => {
            const item = track.querySelector('.slider-item');
            if (!item) return;
            const styles = getComputedStyle(track);
            const gap = parseFloat(styles.columnGap || styles.gap) || 0;
            track.scrollBy({ left: direction * (item.getBoundingClientRect().width + gap), behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
        };

        previous.addEventListener('click', () => move(-1));
        next.addEventListener('click', () => move(1));
        track.addEventListener('scroll', updateButtons, { passive: true });
        window.addEventListener('resize', updateButtons);
        updateButtons();
    });
</script>
@endonce
