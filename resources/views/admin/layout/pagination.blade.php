@if ($paginator->hasPages())
<div class="mt-4 pt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item first disabled">
                    <a class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></a>
                </li>
            @else 
                <li class="page-item first">
                    <a class="page-link" href="{{ $paginator->toArray()['first_page_url'] }}"><i class="tf-icon bx bx-chevrons-left"></i></a>
                </li>
            @endif

            @if ($paginator->onFirstPage())
                <li class="page-item prev disabled">
                    <a class="page-link"><i class="tf-icon bx bx-chevron-left"></i></a>
                </li>
            @else 
            <li class="page-item prev">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="tf-icon bx bx-chevron-left"></i></a>
            </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">
                        <a class="page-link" href="#">1</a>
                    </li>
                @endif 

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link">{{ $page }}</a>
                            </li>
                        @else 
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            
            @if ($paginator->hasMorePages())
                <li class="page-item next">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="tf-icon bx bx-chevron-right"></i></a>
                </li>
            @else 
                <li class="page-item next disabled">
                    <a class="page-link"><i class="tf-icon bx bx-chevron-right"></i></a>
                </li>
            @endif
            
            @if ($paginator->hasMorePages())
                <li class="page-item last">
                    <a class="page-link" href="{{ $paginator->toArray()['last_page_url'] }}"><i class="tf-icon bx bx-chevrons-right"></i></a>
                </li>
            @else 
                <li class="page-item last disabled">
                    <a class="page-link"><i class="tf-icon bx bx-chevrons-right"></i></a>
                </li>
            @endif
        </ul>
    </nav>
</div>
@endif