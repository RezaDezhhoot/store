@if ($paginator->hasPages())
    <div class="blog_pagination">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pagination">
                        <ul>
                            @if ($paginator->onFirstPage())

                            @else
                                <li><a wire:click="previousPage"><i class="fa fa-angle-double-right"></i></a></li>
                                <li class="next" wire:click="previousPage"><a>قبلی</a></li>
                            @endif
                            @foreach ($elements as $element)

                                @if (is_string($element))
                                    <li class="page-item disabled">
                                        <button class="page-link">{{ $element }}</button>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $paginator->currentPage())
                                           <li class="current" wire:click="gotoPage({{ $page }})"><span>{{ $page }}</span></li>
                                        @else
                                            <li wire:click="gotoPage({{ $page }})"><a>{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <li class="next" wire:click="nextPage"><a>بعدی</a></li>
                                <li><a wire:click="nextPage"><i class="fa fa-angle-double-left"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
