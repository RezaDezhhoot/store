@if ($paginator->hasPages())
    <div class="row">
        <div class="col">
            <ul class="pagination float-right">
                @if ($paginator->onFirstPage())
                @else
                    <li class="page-item"><a wire:click="previousPage" class="page-link" ><i class="fas fa-angle-right"></i></a></li>
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
                                    <li class="current" wire:click="gotoPage({{ $page }})"><a class="page-link">{{ $page }}</a></li>
                                @else
                                    <li wire:click="gotoPage({{ $page }})"><a class="page-link">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @if ($paginator->hasMorePages())
                        <li wire:click="nextPage" class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                    @endif
            </ul>
        </div>
    </div>
@endif
