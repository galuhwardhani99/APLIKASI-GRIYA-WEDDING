    .catalog-slider { --slider-gap: 24px; position: relative; margin-inline: 36px; }
    .catalog-slider-controls { position: absolute; z-index: 4; top: 50%; right: -48px; left: -48px; display: block; height: 58px; transform: translateY(-50%); pointer-events: none; }
    .catalog-slider.is-static .catalog-slider-controls { display: none; }
    .catalog-slider-button { display: grid; width: 58px; height: 58px; place-items: center; border: 0; border-radius: 50%; background: #fff; color: #665E58; font-size: 20px; cursor: pointer; box-shadow: 0 6px 22px rgba(36,26,22,.14); transition: transform .25s ease, background .25s ease, color .25s ease; pointer-events: auto; }
    .catalog-slider-button:hover:not(:disabled) { transform: translateY(-2px); background: #C58F43; color: #fff; }
    .catalog-slider-button:disabled { display: none; }
    .catalog-slider-button[data-slider-prev] { position: absolute; top: 0; left: 0; }
    .catalog-slider-button[data-slider-next] { position: absolute; top: 0; right: 0; }
    .catalog-slider-track { display: flex !important; gap: var(--slider-gap) !important; overflow-x: auto; overflow-y: hidden; scroll-snap-type: x mandatory; scroll-behavior: smooth; scrollbar-width: none; overscroll-behavior-inline: contain; padding: 4px 2px 18px; }
    .catalog-slider .catalog-slider-track { max-width: none; margin: 0; }
    .catalog-slider-track::-webkit-scrollbar { display: none; }
    .catalog-slider-track > .slider-item { flex: 0 0 calc((100% - (2 * var(--slider-gap))) / 3); min-width: 0; scroll-snap-align: start; }
    .catalog-slider-track > .slider-item > article { height: 100%; }
    .catalog-slider-track > .slider-empty { flex: 0 0 100%; }
    @media (max-width: 900px) { .catalog-slider { --slider-gap: 18px; } .catalog-slider-track > .slider-item { flex-basis: calc((100% - var(--slider-gap)) / 2); } }
    @media (max-width: 600px) { .catalog-slider { --slider-gap: 14px; margin-inline: 24px; } .catalog-slider-track > .slider-item { flex-basis: 86%; } .catalog-slider-controls { height: 46px; right: -34px; left: -34px; } .catalog-slider-button { width: 46px; height: 46px; } }
    @media (prefers-reduced-motion: reduce) { .catalog-slider-track { scroll-behavior: auto; } .catalog-slider-button { transition: none; } }
