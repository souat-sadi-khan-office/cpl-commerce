<div class="row">
    <div class="col-md-12">
        <ul class="pagination mt-3 justify-content-center pagination_style1">
            @if ($products->onFirstPage())
                <li class="page-item disabled"><span class="page-link">«</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}">«</a></li>
            @endif

            @for ($i = 1; $i <= $products->lastPage(); $i++)
                <li class="page-item {{ $i === $products->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($products->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}"> »</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">»</span></li>
            @endif
        </ul>
    </div>
</div>