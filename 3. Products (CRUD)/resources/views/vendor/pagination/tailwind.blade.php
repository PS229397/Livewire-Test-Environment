@if ($paginator->hasPages())
    <nav class="flex items-center justify-between px-4 py-3">
        <div class="flex flex-1 justify-start sm:hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-200 rounded">
                    Previous
                </span>
            @else
                <button wire:click="previousPage" class="px-4 py-2 text-sm text-white bg-gray-600 rounded">
                    Previous
                </button>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="px-4 py-2 text-sm text-white bg-gray-600 rounded">
                    Next
                </button>
            @else
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-200 rounded">
                    Next
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-medium">{{ $paginator->total() }}</span>
                results
            </div>

            <div class="inline-flex space-x-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-2 text-white bg-gray-700 rounded">
                                    {{ $page }}
                                </span>
                            @else
                                <button
                                    wire:click="gotoPage({{ $page }})"
                                    class="px-3 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </nav>
@endif
