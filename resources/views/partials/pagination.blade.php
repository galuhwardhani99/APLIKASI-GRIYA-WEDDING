@if($paginator->total() > 0)
    <div class="pagination-bar">
        <div class="pagination-info">
            Menampilkan {{ $paginator->firstItem() ?? 0 }}&ndash;{{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} data
        </div>
        <div class="pagination-links">
            @if($paginator->onFirstPage())
                <span class="page-btn disabled"><i class="fa-solid fa-chevron-left"></i> Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left"></i> Previous</a>
            @endif

            @foreach($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
            @endforeach

            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">Next <i class="fa-solid fa-chevron-right"></i></a>
            @else
                <span class="page-btn disabled">Next <i class="fa-solid fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
@endif