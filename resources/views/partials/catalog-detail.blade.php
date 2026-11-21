@php
    $detailId = 'catalog-detail-' . ($detailKey ?? uniqid());
    $detailDescription = (string) ($detailDescription ?? '');
    $detailLines = preg_split('/\r\n|\r|\n/', trim($detailDescription)) ?: [];
    $hasLongDetails = mb_strlen($detailDescription) > 150 || count(array_filter($detailLines, fn ($line) => preg_match('/^\s*(?:[-*•]\s+|\d+[.)]\s+)/u', $line))) >= 3;
@endphp
@if($hasLongDetails)
    <button type="button" class="detail-trigger" onclick="document.getElementById('{{ $detailId }}').showModal()">Lihat detail</button>
    <dialog class="catalog-detail-dialog" id="{{ $detailId }}" onclick="if (event.target === this) this.close()">
        <article class="catalog-detail-content">
            <button type="button" class="detail-close" aria-label="Tutup" onclick="document.getElementById('{{ $detailId }}').close()">&times;</button>
            @if(!empty($detailImage))
                <img class="detail-image" src="{{ asset('storage/' . $detailImage) }}" alt="{{ $detailTitle }}">
            @else
                <div class="detail-image-placeholder" aria-hidden="true">{{ $detailTitle }}</div>
            @endif
            <div class="detail-body">
                <h3>{{ $detailTitle }}</h3>
                @if(!empty($detailExtra))<p class="detail-extra">{{ $detailExtra }}</p>@endif
                @include('partials.format-description', ['descriptionText' => $detailDescription])
                @if(isset($detailPrice))<strong class="detail-price">Rp {{ number_format($detailPrice, 0, ',', '.') }}</strong>@endif
            </div>
        </article>
    </dialog>
@endif
