@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-6">
        <ul class="inline-flex items-center space-x-2">
            {{-- Bouton Précédent --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                    &laquo; Précédent
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-white bg-[#45C4EB] rounded-md hover:bg-[#F7881B]">
                        &laquo; Précédent
                    </a>
                </li>
            @endif

            {{-- Numéros de page --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-3 py-2 text-gray-400">...</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-2 text-white bg-[#45C4EB] rounded-md">{{ $page }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="px-3 py-2 text-blue-500 bg-gray-100 rounded-md hover:bg-gray-200">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Bouton Suivant --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-white bg-[#45C4EB] rounded-md hover:bg-[#F7881B]">
                        Suivant &raquo;
                    </a>
                </li>
            @else
                <li class="px-3 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                    Suivant &raquo;
                </li>
            @endif
        </ul>
    </nav>
@endif
