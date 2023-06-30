<div x-data="{ notification: false }" @click="notification = true" @click.away="notification = false"
  class="relative flex items-center px-3 py-1 space-x-4 font-medium capitalize rounded-lg cursor-pointer hover:shadow-sm hover:bg-white"
  :class="notification ? 'bg-white shadow-sm' : ''">
  <span class="hidden md:block">Notifications</span>
  <p class="relative">
    <span class="text-gray-400">
      <i class="text-3xl bi bi-bell-fill"></i>
    </span>
    <span
      class="absolute bg-red-600 top-0 {{ $unread->count() > 0 ? 'bg-red-600 px-1 -mt-1 -mr-1  text-white text-[10px]' : 'bg-gray-500 p-1' }} right-0 border-2 border-white font-medium rounded-full">{{ $unread->count() > 0 ? $unread->count() : '' }}</span>
  </p>
  <div x-show="notification"
    class="rounded-lg w-[377px] flex flex-col space-y-3 dropdown divide-2 z-50 p-4 bg-white shadow-sm absolute top-[60px] right-0">
    <div class="flex items-center justify-between p-2">
      @if ($unread->count() > 0)
        <h1 class="text-2xl font-semibold text-primary">Unread({{ $unread->count() }})</h1>
      @elseif($read->count() > 0)
        <h1 class="text-2xl font-semibold text-primary">Read({{ $unread->count() }})</h1>
      @else
        <h1 class="text-2xl font-semibold text-primary">No notification yet</h1>
      @endif
      <p class=" text-gray-300 tt hover:text-primary block" @clicky="notification = false">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi h-6 w-6 bi-x-circle-fill"
          viewBox="0 0 16 16">
          <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
        </svg>
      </p>
    </div>
    <div class="flex flex-col w-full pr-1 space-y-2 max-h-[400px] overflow-y-auto">
      @forelse ($unread as $notification)
        <div class="flex items-center justify-between p-2 space-x-4 border rounded-lg shadow-sm odd:border-primary">
          <span class="px-2 py-1 bg-gray-100 rounded-full text-primary" wire:click="readSingle($notification->id)">
            <i class="text-xl bi bi-bell"></i>
          </span>
          <p x-data="{
              words: '{{ $notification->data['message'] ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error optio facilis expedita dolores quis minus nisi vero tenetur quae atque accusamus quasi, necessitatibus aspernatur at deleniti. Maiores enim sequi consequuntur.' }}',
              shorten: true
          }" class="text-xs font-normal"> <span
              x-text="shorten ? words.substring(0, 56) : words.substring(0, words.lenght)" class="text-gray-500"></span>
            <button :class="words.lenght < 56 ? 'hidden' : ''" @click="shorten = !shorten"
              x-text="shorten ? 'Read more': 'Read less'" class="font-medium text-primary"></button>
          </p>
        </div>
      @empty
        <div class="flex items-center justify-between p-2 space-x-4 border rounded-lg shadow-sm odd:border-primary">
          <span class="px-2 py-1 bg-gray-100 rounded-full text-primary">
            <i class="text-xl bi bi-bell"></i>
          </span>
          <p x-data="{
              words: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Et, rem dolorem dignissimos dicta, enim voluptatibus delectus est harum aspernatur quas laboriosam nisi nam illo necessitatibus dolor exercitationem eveniet. Quibusdam, porro!',
              shorten: true
          }" class="text-xs font-normal"> <span
              x-text="shorten ? words.substring(0, 56) : words.substring(0, words.lenght)" class="text-gray-500"></span>
            <button @click="shorten = !shorten" x-text="shorten ? 'Read more': 'Read less'"
              class="font-medium text-primary"></button>
          </p>
        </div>
      @endforelse
      {{-- unread notifications --}}
    </div>
  </div>
</div>
