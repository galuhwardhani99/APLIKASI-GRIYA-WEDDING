@if ($paginator->hasPages())
    <div class="pagination-bar">
        <div class="pagination-info">
            Menampilkan <strong>{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</strong> dari <strong>{{ $paginator->total() }}</strong> data
        </div>

        <div class="pagination-links">
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <span class="page-btn disabled"><i class="fa-solid fa-chevron-left" style="font-size: 0.72rem;"></i> Previous</span>
            @else
                <a class="page-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left" style="font-size: 0.72rem;"></i> Previous</a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="page-btn disabled">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a class="page-btn" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <a class="page-btn" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <i class="fa-solid fa-chevron-right" style="font-size: 0.72rem;"></i></a>
            @else
                <span class="page-btn disabled">Next <i class="fa-solid fa-chevron-right" style="font-size: 0.72rem;"></i></span>
            @endif
        </div>
    </div>
@endif