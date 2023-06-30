<div class="z-20 flex flex-col gap-6 py-8 lg:py-12">
  {{-- alert notification --}}
  @if (session('success'))
    <x-alert type="success" :message="session('success')">
      <i class="text-3xl bi bi-check2-circle"></i>
    </x-alert>
  @endif
  <div class="flex items-center justify-between">
    <h1 class="text-3xl font-semibold capitalize text-primary">messages</h1>

    {{-- user search components --}}
    <x-search name="messages" />
  </div>
  <div class="flex w-full gap-8" x-data="{ type: @entangle('type') }">
    {{-- message list area --}}
    <div class="flex-1 py-12 lg:py-16 2xl:py-20  min-h-full overflow-hidden bg-white divide-y rounded-lg shadow-sm">
      <div class="space-y-6 w-4/5 2xl:w-2/3 mx-auto text-center">
        {{-- toggle message type --}}
        <x-message-tab-toggle />
        <p class="text-sm text-center text-gray-500 px-4 lg:px-8">Click on the tab above to send message to the
          appropriate
          parties
        </p>
        <div x-show="type == 'member'" class="w-full">
          <div class="w-full">
            @foreach (['id' => 'id', 'role' => 'roles'] as $key => $item)
              <div class="flex my-2">
                <input
                  class="mr-2 text-left text-primary focus:outline-0 focus:border-primtext-primary focus:border-2 focus:ring-2 focus:ring-primtext-primary"
                  type="radio" wire:model="member_type" value="{{ $key }}" id="{{ $key }}">
                <label class="text-sm text-left w-[300px] block p-0 m-0  cursor-pointer" for="{{ $key }}">
                  Select receivers\'s by {{ strtoupper($item) }}
                </label>
              </div>
            @endforeach
          </div>
        </div>
        <form wire:submit.prevent="send" class="space-y-6">
          <div x-show="type == 'member'" class="w-full">

          </div>

          {{-- if message type is visitor --}}
          <div x-show="type == 'visitor'" class="space-y-6">
            {{-- email --}}
            <x-input label="Visitor's Email*" name="email" type="text" wire:model.defer="email" />
            <x-forms.phone />
          </div>
          <div>
            <textarea name="" wire:model.defer="message"
              class="w-full border-0 focus:outline-0 @error('message') border-2 border-red-600 @enderror focus:ring-0 tt focus:shadow focus:bg-white rounded-lg p-4 bg-gray-50"
              cols="30" rows="10" placeholder="Write your message letter here"></textarea>
            @error('message')
              <span class="text-red-600 text-left">{{ $message }}</span>
            @enderror
          </div>
          <button wire:loading.attr="disabled"
            class="w-full hover:bg-primary mt-6 hover:text-white mx-auto btn-primary py-2 capitalize tt submit font-normal"
            type="submit">send
            <img wire:loading.delay wire:target='save' src="/img/spin-white.svg" alt="" class="w-11 h-11">
          </button>
        </form>
      </div>
    </div>
    <div class="space-y-4 rounded-lg w-80 2xl:w-96 max-h-max">
      <x-message-switch />
      <div class="w-full py-4 space-y-4 bg-white rounded-lg">
        <div class="relative w-[90%] p-0 mx-auto">
          <input type="text" wire:model.debounce.500ms="search"
            class="w-full px-3 py-3 text-xs font-medium border-none rounded-lg shadow bg-gray-50 focus:bg-white tt focus:ring-0"
            placeholder="Search message">
          <svg class="absolute w-6 h-6 font-bold top-2 right-2 icons-svg text-primary" fill="none"
            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>

        {{-- converstion list --}}
        <div class="w-full flex flex-col overflow-y-auto p-4 space-y-3 h-96  2xl:h-[580px]">
          @forelse ($messages as $message)
            <div title="{{ $message->user->first_name }}" class="space-y-2 p-3 2xl:p-4 rounded-lg w-full border-2">
              <div class="flex text-[14px] items-center justify-between">
                <p class="capitalize">
                  @if ($message->status == 'awaiting approval')
                    <span class="text-secondary">{{ $message->status }}</span>
                  @elseif($message->status == 'denied')
                    <span class="text-red-600">{{ $message->status }}</span>
                  @else
                    <span class="text-green-600">{{ $message->status }}</span>
                  @endif
                </p>
                <p class="font-medium text-base text-dark">{{ formatDate($message->created_at) }}</p>
              </div>
              <p x-data="{
                  words: '{{ $message->message }}',
                  shorten: true
              }" class="text-sm font-normal"> <span
                  x-html="shorten ? words.substring(0, 100) : words.substring(0, words.lenght)"
                  class="text-gray-500"></span>
                <button :class="words.lenght < 100 ? 'hidden' : ''" @click="shorten = !shorten"
                  x-text="shorten ? 'Read more': 'Read less'" class="font-medium text-primary"></button>
              </p>
            </div>
          @empty
            <p class="">No Message sent yet</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
