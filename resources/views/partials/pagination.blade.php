@if ($paginator->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            عرض {{ $paginator->firstItem() }} إلى {{ $paginator->lastItem() }} من إجمالي {{ $paginator->total() }} سجل
        </div>
        <nav class="custom-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="page-link disabled">« السابق</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link">« السابق</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-link disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link">التالي »</a>
            @else
                <span class="page-link disabled">التالي »</span>
            @endif
        </nav>
    </div>
@endif
