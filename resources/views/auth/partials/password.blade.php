@php($toggle = $toggle ?? true)

<div class="form-group">
    <div class="label-row">
        <label for="password">Kata Sandi (Password)</label>
        <a href="#">Lupa Sandi?</a>
    </div>
    <div class="password-wrap">
        <input type="password" id="password" name="password"
               class="input @error('password') is-invalid @enderror"
               placeholder="••••••••" required>
        @if ($toggle)
            <button type="button" class="toggle-eye" data-target="password" aria-label="Tampilkan kata sandi">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                    <circle cx="12" cy="12" r="3" fill="currentColor"/>
                </svg>
            </button>
        @endif
    </div>
    @error('password') <p class="error-text">{{ $message }}</p> @enderror
</div>