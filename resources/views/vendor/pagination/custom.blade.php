@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <ul class="inline-flex items-center -space-x-px">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li aria-disabled="true" aria-label="Previous">
                    <span
                        class="px-3 py-1.5 ml-0 leading-tight text-gray-400 bg-gray-100 border border-gray-200 rounded-l-md">&laquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous"
                        class="px-3 py-1.5 ml-0 leading-tight text-gray-700 bg-gray-100 border border-gray-200 rounded-l-md hover:bg-gray-200">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span
                            class="px-3 py-1.5 leading-tight text-gray-500 bg-gray-100 border border-gray-200">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page"><span
                                    class="px-3 py-1.5 leading-tight text-gray-800 bg-gray-300 border border-gray-200">{{ $page }}</span>
                            </li>
                        @else
                            <li><a href="{{ $url }}"
                                    class="px-3 py-1.5 leading-tight text-gray-700 bg-gray-100 border border-gray-200 hover:bg-gray-200">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next"
                        class="px-3 py-1.5 leading-tight text-gray-700 bg-gray-100 border border-gray-200 rounded-r-md hover:bg-gray-200">&raquo;</a>
                </li>
            @else
                <li aria-disabled="true" aria-label="Next">
                    <span
                        class="px-3 py-1.5 leading-tight text-gray-400 bg-gray-100 border border-gray-200 rounded-r-md">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
