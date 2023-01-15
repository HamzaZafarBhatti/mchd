@if ($paginator->hasPages())
<ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
    @if ($paginator->onFirstPage())
    <li class="page-item disabled">
        <a href="#" class="page-link">Previous</a>
    </li>
    @else
    <li class="page-item">
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link">Previous</a>
    </li>
    @endif

        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="page-item disabled">
                    <a class="page-link">{{ $element }}</a>
                </li>
            @endif


            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link">
                                {{ $page }}
                            </a>
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
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link">
                    Next
                </a>
            </li>
        @endif

</ul>
@endif
