<div class="z-20 flex flex-col gap-6 py-8 lg:py-12">
  {{-- alert notification --}}
  @if (session('success'))
    <x-alert type="success" :message="session('success')">
      <i class="text-3xl bi bi-check2-circle"></i>
    </x-alert>
  @endif
  <div class="flex items-center justify-between">
    <h1 class="text-3xl font-semibold capitalize text-primary">Leave Request</h1>

    {{-- user search components --}}
    <x-search name="user" />
  </div>
  <div class="flex w-full gap-8">
    {{-- message list area --}}
    <div class="flex-1 py-12 lg:py-16 2xl:py-20  min-h-full overflow-hidden bg-white divide-y rounded-lg shadow-sm">
      <div class="space-y-6 w-4/5 2xl:w-2/3 mx-auto text-center">
        <div class="">
          <h1 class="capitalize text-center font-semibold text-2xl p-2">Request for Leave</h1>
          <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempora, cupiditate mollitia!
            Totam,
          </p>
        </div>
        <form wire:submit.prevent="save">
          <div>
            <textarea name="" wire:model.defer="message"
              class="w-full border-0 focus:outline-0 @error('message') border-2 border-red-600 @enderror focus:ring-0 tt focus:shadow focus:bg-white rounded-lg p-4 bg-gray-50"
              cols="30" rows="10" placeholder="Write your leave letter here"></textarea>
            @error('message')
              <span class="text-red-600 text-left">{{ $message }}</span>
            @enderror
          </div>
          <button wire:loading.attr="disabled"
            class="w-full hover:bg-primary mt-6 hover:text-white mx-auto btn-primary py-2 capitalize tt submit font-normal"
            type="submit">Apply for Leave
            <img wire:loading.delay wire:target='save' src="/img/spin-white.svg" alt="" class="w-11 h-11">
          </button>
        </form>
      </div>
    </div>
    <div class="space-y-4 rounded-lg w-80 2xl:w-96 max-h-max">
      <div class="w-full bg-white rounded-lg shadow-sm">
        <h1 class="text-center font-semibold text-2xl p-2">Leave History</h1>
      </div>
      <div class="w-full py-4 space-y-4 bg-white rounded-lg">
        <div class="relative w-[90%] p-0 mx-auto">
          <input type="text" wire:model.debounce.500ms="search"
            class="w-full px-3 py-3 text-xs font-medium border-none rounded-lg shadow bg-gray-50 focus:bg-white tt focus:ring-0"
            placeholder="Search leave by status">
          <svg class="absolute w-6 h-6 font-bold top-2 right-2 icons-svg text-primary" fill="none"
            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>

        {{-- converstion list --}}
        <div class="w-full flex flex-col overflow-y-auto p-4 space-y-3 h-96  2xl:h-[580px]">
          @forelse ($leaves as $leave)
            <div title="{{ $leave->user->first_name }}" class="space-y-2 p-3 2xl:p-4 rounded-lg w-full border-2">
              <div class="flex text-[14px] items-center justify-between">
                <p class="capitalize">
                  @if ($leave->status == 'awaiting approval')
                    <span class="text-secondary">{{ $leave->status }}</span>
                  @elseif($leave->status == 'denied')
                    <span class="text-red-600">{{ $leave->status }}</span>
                  @else
                    <span class="text-green-600">{{ $leave->status }}</span>
                  @endif
                </p>
                <p class="font-medium text-base text-dark">{{ formatDate($leave->created_at) }}</p>
              </div>
              <p x-data="{
                  words: '{{ $leave->message }}',
                  shorten: true
              }" class="text-sm font-normal"> <span
                  x-html="shorten ? words.substring(0, 100) : words.substring(0, words.lenght)"
                  class="text-gray-500"></span>
                <button :class="words.lenght < 100 ? 'hidden' : ''" @click="shorten = !shorten"
                  x-text="shorten ? 'Read more': 'Read less'" class="font-medium text-primary"></button>
              </p>
            </div>
          @empty
            <p class="">No leave yet</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
