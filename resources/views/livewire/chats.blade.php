<div class="z-20 flex flex-col gap-6 py-8 lg:py-12">
  <div class="flex items-center justify-between">
    <h1 class="text-3xl font-semibold capitalize text-primary">Chat</h1>

    {{-- user search components --}}
    <x-search name="user" />
  </div>
  <div class="flex w-full gap-8" x-data="{ activeChat: @entangle('activeChat'), showMessage: @entangle('showMessage') }">
    <div class="space-y-4 rounded-lg w-72 2xl:w-80 max-h-max" x-data="{ active: 'students' }">
      <div class="flex justify-center px-2 space-x-1 overflow-hidden capitalize bg-white rounded-lg shadow">
        <button @click="active = 'students'"
          :class="active === 'students' ? 'text-primary border-b-4 font-medium border-primary' : ''"
          href="{{ route('students') }}"
          class="px-6 rounded {{ request()->is('users/students') ? 'text-primary border-b-4 font-medium border-primary' : '' }} py-3">Students</button>
        <button @click="active = 'parents'"
          :class="active === 'parents' ? 'text-primary border-b-4 font-medium border-primary' : ''"
          href="{{ route('parents') }}" class="px-6 py-3 rounded">Parents</button>
        <button @click="active = 'staff'"
          :class="active === 'staff' ? 'text-primary border-b-4 font-medium border-primary' : ''"
          class="px-6 py-3 rounded">Staff</button>
      </div>
      <div class="w-full py-4 space-y-4 bg-white rounded-lg">
        <div class="relative w-[90%] p-0 mx-auto">
          <input type="text" wire:model.debounce.500ms="search"
            class="w-full px-3 py-3 text-xs font-medium border-none rounded-lg shadow bg-gray-50 focus:bg-white tt focus:ring-0"
            placeholder="Search Message">
          <svg class="absolute w-6 h-6 font-bold top-2 right-2 icons-svg text-primary" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>

        {{-- converstion list --}}
        <div class="w-full flex flex-col overflow-y-auto p-4 space-y-2 h-96  2xl:h-[580px]">
          @forelse ($conversations as $index => $conversation)
            <div
              class="flex items-center w-full p-1 space-x-2 border rounded-lg shadow-sm cursor-pointer tt hover:-translate-y-1"
              :class="activeChat == {{ $conversation->id }} ? 'bg-primary text-white font-normal' : ''"
              @click="$wire.setActiveChat({{ $conversation->id }})">
              <img src="/img/staff.png" alt="name" class="block object-cover p-1 rounded-full w-14 h-14 aspect-square">
              <div class="flex flex-col flex-1 h-full pr-1 justify-evenly">
                <div class="flex justify-between text-sm font-medium">
                  <p class=""
                    :class="activeChat == {{ $conversation->id }} ? 'text-white font-normal' : 'font-medium'">
                    {{ $conversation->sender->first_name . ' ' . $conversation->sender->last_name }}</p>
                  <p class="text-xs uppercase">
                    @if ($conversation->chats->last()->created_at < \Carbon\Carbon::today())
                      {{ $conversation->updated_at->diffForHumans() }}
                    @else
                      {{ date_format($conversation->updated_at, 'h:i A') }}
                    @endif

                  </p>
                </div>
                <div class="flex justify-between">
                  <small
                    :class="activeChat != {{ $conversation->id }} ? 'text-gray-500' : ''">{{ Str::limit($conversation->chats->last()->message, 22) }}</small>
                  <p :class="activeChat != {{ $conversation->id }} ? 'bg-primary text-white ' :
                      'bg-white text-primary font-semibold'"
                    class="rounded-full text-xs {{ $conversation->chats->where('is_seen', false)->count() < 1 ? 'hidden' : '' }} text-center  h-4 w-4">
                    {{ count($conversation->chats->where('is_seen', false)) }}
                  </p>
                </div>
              </div>
            </div>
          @empty
            <p class="">No message yet, Kindly use the user bar on the top right on the page to search and
              message user.</p>
          @endforelse
        </div>
      </div>
    </div>
    {{-- message list area --}}
    <div class="flex-1 min-h-full overflow-hidden bg-white divide-y rounded-lg shadow-sm" x-show="showMessage">

      {{-- message sender --}}
      <div class="flex items-center justify-between w-full p-4">
        <div class="flex items-center">
          <img src="/img/staff.png" alt="name" class="block object-cover p-1 rounded-full w-14 h-14 aspect-square">
          <div class="">
            <p class="-mb-1 font-medium">Yusuf Amina</p>
            <span class="text-sm text-gray-500 ">Active Now</span>
          </div>
        </div>
        <div class="relative flex items-center space-x-2" x-data="{ dropdown: false }">
          <a href="tel:+234"
            class="block w-8 h-8 p-2 text-gray-600 bg-gray-100 border rounded-full tt hover:-translate-y-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone"
              viewBox="0 0 16 16">
              <path
                d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
            </svg>
          </a>
          <span class="text-sm text-gray-500 cursor-pointer tt hover:text-primary" @click="dropdown = !dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots-vertical h-7 w-7"
              viewBox="0 0 16 16">
              <path
                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
            </svg>
          </span>
          <button x-show="dropdown"
            class="absolute px-8 text-sm font-normal bg-white shadow-sm btn top-16 tt hover:-translate-y-2 right-2"
            @click.away="dropdown = false">Refresh</button>
        </div>
      </div>
      <div class="w-full p-4 lg:p-6 flex flex-col space-y-6 overflow-y-auto h-[520px]">
        @foreach ($messages as $message)
          <div class="flex w-full {{ $message->user_id === currentUser()->id ? 'justify-end' : 'justify-start' }}"
            title="{{ $message->user->first_name . ' ' . $message->user->id }}">
            <div
              class="py-4 mb-2 px-6 {{ $message->user_id != currentUser()->id ? 'bg-gray-50 text-gray-500 rounded-tl-none shadow-sm' : 'bg-primary text-white rounded-tr-none' }} rounded-xl clear-both odd:flex-grow-0  relative  max-w-xs md:max-w-sm lg:max-w-lg 2xl:max-w-2xl">
              <p class="">{{ $message->message }}</p>
              <p class="absolute bottom-0 right-0 pt-2 mt-2 mb-1 mr-4 text-xs lg:mr-6">
                <span class="">{{ $message->created_at->diffForHumans() }}</span>
              </p>
            </div>
          </div>
        @endforeach
      </div>
      <div class="w-full"></div>
    </div>
  </div>
