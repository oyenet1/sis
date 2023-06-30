<div class="grid w-full gap-6 py-8 lg:py-12">
  {{-- alert notification --}}
  @if (session('success'))
    <x-alert type="success" :message="session('success')">
      <i class="text-3xl bi bi-check2-circle"></i>
    </x-alert>
  @elseif (session('error'))
    <x-alert type="error" :message="session('error')">
      <i class="text-3xl bi bi-check2-circle"></i>
    </x-alert>
  @else
  @endif

  {{-- form --}}
  {{-- modal forms and inputs components --}}
  <x-modal class="max-w-lg">
    <x-form title="Document title" :update="$update">
      <x-input label="Document Name*" class="cursor-pointer @error('name') border-red-500 text-red-600 @enderror"
        name="name" type="text" wire:model="name" />
    </x-form>
  </x-modal>


  {{-- fixed header --}}
  <header class="flex flex-col w-full gap-6 bg-background">
    {{-- buttons --}}
    <div class="flex items-center justify-between ">
      <div class="flex items-center space-x-6">
        <h1 class="text-3xl font-semibold capitalize text-primary">Document</h1>
      </div>
    </div>
    <form wire:submit.prevent=@if ($update) 'update' @else 'save' @endif
      class="flex flex-col space-y-4">
      <x-input label="name*" class="cursor-pointer w-[300px] @error('name') border-red-500 text-red-600 @enderror"
        name="name" type="text" wire:model="name" />
      <label for="image"
        class="border-2 border-primary rounded-lg text-center @error('image') border-red-500 text-red-500 bg-red-100 @enderror w-full md:w-2/3 lg:w-3/5 2xl:w-1/2 border-dashed py-10 md:py-14 lg:py-16 2xl:py-24">
        <div class="mx-auto flex justify-center flex-col">
          <span class="mx-auto block">
            <svg class="w-32 h-20 2xl:h-[143] 2xl:w-[175]" viewBox="0 0 175 143" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M98.375 22.5L76.625 0.75H0.5V142.125H174.5V22.5H98.375ZM87.5 60.5625L125.562 98.625H98.375V142.125H76.625V98.625H49.4375L87.5 60.5625Z"
                fill="#000B17" />
            </svg>
          </span>
          <label for="image" class="text-center mx-auto max-w-max mt-4">Drag and drop or <span
              class="text-primary hover:text-secondary cursor-pointer">browse</span>
            files
          </label>
          @error('image')
            <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>
        <input id="image" type="file" name="image" wire:model.defer="image" class="hidden">
      </label>
      @if ($update)
        <button wire:loading.attr="disabled"
          class="w-[239px] btn submit-primary capitalize tt submit-primary font-normal" type="submit">Update
          Document Title
          <img wire:loading.delay wire:target='update' src="/img/spin-white.svg" alt="" class="w-11 h-11">
        </button>
      @else
        <button wire:loading.attr="disabled"
          class="w-[239px] submit-primary py-2 capitalize tt submit-primary font-normal" type="submit">Add
          Document
          <img wire:loading.delay wire:target='save' src="/img/spin-white.svg" alt="" class="w-11 h-11">
        </button>
      @endif
    </form>
    {{-- right side --}}
    <div class="flex justify-between items-center space-x-6">
      <h1 class="text-dark text-2xl font-semibold">Uploaded documents({{ count($documents) }})</h1>
      <x-search name="documents" />
    </div>
  </header>

  {{-- tables --}}
  <div class="w-full p-4 pb-4 overflow-x-auto bg-white rounded-lg shadow-sm ">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 xl:gap-12 mg:gap-6 lg:gap-8">
      @foreach ($documents as $document)
        <div class="rounded-lg tt hover:scale-105 flex flex-col justify-between shadow overflow-hidden bg-white"
          x-data="{ text: false }" @mouseenter="text= true" @mouseleave="text= false">
          <div class="w-full relative flex-1">
            @if ($document->getFirstMedia('documents')->mime_type == 'image/png' ||
                $document->getFirstMedia('documents')->mime_type == 'image/jpg' ||
                $document->getFirstMedia('documents')->mime_type == 'image/jpeg' ||
                $document->getFirstMedia('documents')->mime_type == 'application/pdf')
              <embed src="{{ $document->getFirstMedia('documents')->getUrl() }}"
                type="{{ $document->getFirstMedia('documents')->mime }}"
                class="w-full aspect-square max-h-[300px] obeject-center object-cover">
            @else
              <div class="w-full min-h-[200px] h-full px-8 font-black text-4xl">
                <p class="text-center text-gray-100 py-24 my-auto block" style="text-shadow: 1px 3px rgba(0,0,0, 0.5)">
                  Office
                  Document
                </p>
              </div>
            @endif

            <div x-show="text"
              class="absolute tt duration-500 inset-0 w-full h-full flex justify-center bg-white bg-opacity-75 backdrop-blur-sm">
              <p class="text-center px-4 my-auto text-primary uppercase text-xl font-medium">{{ $document->name }}</p>
            </div>
          </div>
          <div class="m-0 p-4 flex items-center text-primary justify-between">
            <div class="flex items-center space-x-4 tex-sm">
              <p wire:click="edit({{ $document->id }})"
                class="flex items-center space-x-1 cursor-pointer hover:text-secondary">
                <span>
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                    </path>
                  </svg>
                </span>
                <span>Edit</span>
              </p>
              <p
                wire:click="download({{ $document->id }})"class="flex items-center space-x-1 cursor-pointer hover:text-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span class="">Download</span>
              </p>
            </div>
            <p class="flex space-x-2">
              <a href="{{ $document->getFirstMedia('documents')->getUrl() }}" target="_blank"
                class="w-6 h-6 pt-[5px] text-blue-600 border border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                  class="m-auto block bi bi-eye" viewBox="0 0 16 16">
                  <path
                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                </svg>
              </a>
              <span wire:click="confirmDelete({{ $document->id }})"
                class="w-6 h-6 pt-[5px] text-red-600 border border-red-600 rounded-full cursor-pointer tt hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                  class="bi block mx-auto bi-trash3" viewBox="0 0 16 16">
                  <path
                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                </svg>
              </span>
            </p>
          </div>
        </div>
      @endforeach
    </div>

    {{-- pagnation components --}}
    <div class="mt-4">
      <x-per-page>
        {{ $documents->links() }}
      </x-per-page>
    </div>
  </div>
</div>
