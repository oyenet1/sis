<div class="flex justify-end items-center p-2 space-x-4">
@if ($paginator->hasPages())
<div class="space-x-4">
  <p class="text-xs text-gray-400 font-normal ">
    <span class="font-">{{ $paginator->firstItem() }}</span>
    <span>-</span>
    <span class="font-">{{ $paginator->lastItem() }}</span>
    <span>{!! __('of') !!}</span>
    <span class="font-">{{ $paginator->total() }}</span>
  </p>
</div>
<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
  <span>
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <span class="text-gray-400 cursor-not-allowed">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
    </span>
    @else
    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="text-gray-400 cursor-pointer hover:text-primary transition ease-in-out duration-150">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
    </button>
    @endif
  </span>

  <span>
    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="text-gray-400 cursor-pointer hover:text-primary transition ease-in-out duration-150">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </button>
    @else
    <span class="text-gray-400 cursor-not-allowed">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </span>
    @endif
  </span>
</nav>
@endif
</div>
