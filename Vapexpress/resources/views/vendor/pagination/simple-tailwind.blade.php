@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-end space-x-2 mt-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-200 rounded-md cursor-default">
                Anterior
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#932F6D] rounded-md hover:bg-[#7B2457] transition duration-150">
                Anterior
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#932F6D] rounded-md hover:bg-[#7B2457] transition duration-150">
                Siguiente
            </a>
        @else
            <span
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-200 rounded-md cursor-default">
                Siguiente
            </span>
        @endif
    </nav>
@endif
