<div class="col-sm-6">
    <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
        @if ($paginator->hasPages())
        <ul class="pagination" role="navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">@lang('pagination.previous')</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">@lang('pagination.next')</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
        @endif
    </div>
</div>
<div class="col-sm-3">
    <div class="dataTables_info pull-right" id="example1_info" role="status" aria-live="polite">
        @php
            $length = $paginator->total() < $paginator->firstItem() + $paginator->perPage() - 1
            ? $paginator->total()
            : $paginator->firstItem() + $paginator->perPage() - 1;
        @endphp
        {{ __('pagination.Showing :start to :length of :count entries', [
            'start' => $paginator->firstItem(),
            'length' => $length,
            'count'  => $paginator->total()
        ]) }}
    </div>
</div>