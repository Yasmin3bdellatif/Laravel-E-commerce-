@if($paginator->hasPages())
    <nav class="page-section">
        <ul class="pagination">
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->onFirstPage() ? 'javascript:void(0)' : $paginator->previousPageURL() }}" aria-label="Previous" style="color:#6c757d;">
                    <span aria-hidden="true">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </a>
            </li>

            @foreach($elements as $element)
                @if(is_string($element))
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0)">{{ $element }}</a>
                    </li>
                @endif
                
                @if(is_array($element))
                    @foreach($element as $page => $url)
                        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $page == $paginator->currentPage() ? 'javascript:void(0)' : $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach
            
            <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->hasMorePages() ? $paginator->nextPageURL() : 'javascript:void(0)' }}" aria-label="Next" style="color:#6c757d;">
                    <span aria-hidden="true">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
@endif
