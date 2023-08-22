@if ($paginator->hasPages)
    <div class="pagination">
        @if ($paginator->onFirstPage())
        <a href="#" disabled>&laquo;</a>
        @else
        <a class="active-page" href="{{ $paginator->previousPageUrl() }}"></a>
        @endif

        @foreach($elements as $element)
            @if (is_string($element))
                <a href="#">{{ $element }}</a>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage)
                        <a class="active-page" href="#">{{ $page }}</a>
                    @else
                        <a class="{{ $url }}" href="#">{{ $page }}</a> 
                    @endif
                
            @endif

        @endforeach
        
      
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">&raquo;</a>     
        @else
            <a href="#"&laquo;></a>
        @endif
        
    </div>
@endif
