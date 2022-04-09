@if ($paginator->hasPages())
<div class="table-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <a href="javascript:void(0)" class="disabled">Anterior</a>
        @else
        <a href="{{ $paginator->previousPageUrl().'&'.str_replace('page=', '', $_SERVER['QUERY_STRING']) }}">Anterior</a>
        @endif

        <span>
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                {{ $element }}
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())
                    <a href="#" class="active">{{ $page }}</a>
                    @else
                    <a href="{{ $url.'&'.str_replace('page=', '', $_SERVER['QUERY_STRING']) }}">{{ $page }}</a>
                    @endif

                @endforeach
            @endif
        @endforeach
</span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl().'&'.str_replace('page=', '', $_SERVER['QUERY_STRING']) }}" rel="next">Próximo</a>
        @else
        <a href="javascript:void(0)" class="disabled">Próximo</a>
        @endif
</div>
@endif
