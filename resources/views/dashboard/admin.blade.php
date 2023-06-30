<div class="grid w-full gap-6 px-4 py-8 mx-auto 2xl:w-[1280px] 2xl:gap-8 lg:px-6 lg:py-6">
  <h1 class="text-3xl font-semibold text-dark">Dashboard</h1>
  <div class="grid grid-cols-1 gap-6 2xl:gap-8 lg:grid-cols-5">
    {{-- income and expenses --}}
    <div class="grid grid-cols-1 gap-6 p-0 m-0 2xl:gap-8 lg:grid-cols-2 lg:col-span-3">
      @php
        $income = \App\Models\Finance::where('type', 'income')->sum('amount');
        $expenses = \App\Models\Finance::where('type', 'expenses')->sum('amount');
        $balance = $income - $expenses;
      @endphp
      <div class="flex flex-col justify-between p-4 space-y-4 rounded-lg income">
        <div class="flex justify-between w-full ">
          <span class="bg-[#B5FF7A] rounded-full p-3">
            <span class=" inline-block text-[#079300] ">
              <i class="fa-solid text-[20px] fa-arrow-trend-down"></i>
            </span>
          </span>
          <div>
            <x-session />
          </div>
        </div>
        <div class="text-dark">
          <p>Income</p>
          <p class="text-2xl font-semibold"> &#8358
            {{ moneyFormat($income) }}
          </p>
        </div>
      </div>
      <div class="flex flex-col justify-between p-4 rounded-lg shadow expenses">
        <div class="flex justify-between w-full ">
          <span class="bg-[#FFE1C5] rounded-full p-3">
            <span class=" inline-block text-[#EF1313] ">
              <i class="fa-solid text-[20px] fa-arrow-trend-up"></i>
            </span>
          </span>
          <div>
            <x-session />
          </div>
        </div>
        <div class="text-dark">
          <p>Expenses</p>
          <p class="text-2xl font-semibold"> &#8358
            {{ moneyFormat($expenses) }}
          </p>
        </div>
      </div>
    </div>
    <div class="flex justify-between w-full gap-12 p-4 bg-white rounded-lg shadow lg:gap-20 lg:col-span-2">
      <div class="flex flex-col w-1/2 space-y-2">
        <div class="flex items-center justify-between p-2 border rounded-lg border-primary">
          <span>Income</span>
          <span class="font-semibold text-green-600">&#8358 {{ moneyFormat($income) }}</span>
        </div>
        <div class="flex items-center justify-between p-2 border rounded-lg border-primary">
          <span>Expenses</span>
          <span class="font-semibold text-red-600">&#8358 {{ moneyFormat($expenses) }}</span>
        </div>
        <div class="flex items-center justify-between p-2 border rounded-lg border-primary">
          <span>Balance</span>
          <span class="{{ $balance > 0 ? 'text-green-600' : 'text-red-600' }} font-semibold">&#8358
            {{ moneyFormat($balance) }}</span>
        </div>
      </div>
      <div class="flex flex-col flex-1">
        <x-session />
      </div>
    </div>

    <div class="relative p-4 overflow-y-auto rounded-lg shadow bg-primary-light lg:col-span-2">
      @php
        $messages = \App\Models\Conversation::where('sender_id', currentUser()->id)
            ->orWhere('user_two', currentUser()->id)
            ->latest()
            ->get();
      @endphp
      <div class="absolute left-0 z-20 flex items-center justify-between w-full p-2 backdrop-blur-sm top-2">
        <h1 class="pl-4 text-lg font-medium text-dark">Messages</h1>
        <button class="pr-2 text-sm font-semibold text-secondary tt hover:text-primary">View All</button>
      </div>
      <div class="flex flex-col pt-10 space-y-2  overflow-y-auto max-h-[300px]">
        @forelse ($messages as $conversation)
          <div class="flex items-center w-full space-x-2 rounded-lg cursor-pointer tt hover:-translate-y-1">
            <img src="/img/staff.png" alt="name"
              class="block object-cover p-1 rounded-full w-14 h-14 aspect-square">
            <div class="flex flex-col flex-1 h-full pr-1 justify-evenly">
              <div class="flex justify-between text-sm font-medium">
                <p class="">
                  {{ $conversation->sender->first_name . ' ' . $conversation->sender->last_name }}</p>
                <p class="uppercase text-secondary">
                  <i class="bi bi-chat"></i>
                </p>
              </div>
              <div class="flex justify-between">
                <small></small>
                <p
                  class="rounded-full text-xs {{ $conversation->chats->where('is_seen', false)->count() < 1 ? 'hidden' : '' }} text-center  h-4 w-4">
                  {{ count($conversation->chats->where('is_seen', false)) }}
                </p>
              </div>
            </div>
          </div>
        @empty
          <x-empty-table comment="There is no message yet" title="message">
            <p class="max-w-xs text-center">There is no message yet
            </p>
          </x-empty-table>
        @endforelse
      </div>
    </div>

    {{-- notification --}}
    <div class="relative p-4 bg-white rounded-lg shadow lg:col-span-3">
      <div class="absolute left-0 z-20 flex items-center justify-between w-full py-2 backdrop-blur-sm top-2">
        <h1 class="pl-4 text-lg font-medium text-dark">Notification</h1>
        <button class="pr-6 text-sm font-semibold text-secondary tt hover:text-primary">Mark all as read</button>
      </div>
      <div class="flex flex-col pt-10 w-full pr-1 space-y-2 max-h-[400px] overflow-y-auto">
        @forelse (currentUser()->unreadNotifications as $notification)
          <div class="flex items-center justify-between p-2 border rounded-lg shadow-sm odd:border-primary">
            <div class="flex items-center w-3/4 space-x-2">
              <span class="px-2 py-1 rounded-full bg-primary-light text-primary"
                wire:click="readSingle($notification->id)">
                <i class="text-xl bi bi-bell"></i>
              </span>
              <p x-data="{
                  words: '{{ $notification->data['message'] ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error optio facilis expedita dolores quis minus nisi vero tenetur quae atque accusamus quasi, necessitatibus aspernatur at deleniti. Maiores enim sequi consequuntur.' }}',
                  shorten: true
              }" class="font-normal"> <span
                  x-text="shorten ? words.substring(0, 56) : words.substring(0, words.lenght)"
                  class="text-gray-500"></span>
                <button :class="words.lenght < 56 ? 'hidden' : ''" @click="shorten = !shorten"
                  x-text="shorten ? 'Read more': 'Read less'" class="font-medium text-primary"></button>
              </p>
            </div>
            <span class="font-medium text-dark">{{ $notification->created_at->diffForHumans() }}</span>
          </div>
        @empty
          <x-empty-table comment="There is no message yet" title="notification">
            <p class="max-w-xs text-center">Your notifications will dispaly here
            </p>
          </x-empty-table>
        @endforelse
        {{-- unread notifications --}}
      </div>
    </div>

    {{-- leave request --}}
    <div class="relative p-4 bg-white rounded-lg shadow lg:col-span-3 max-h-[350px] overflow-y-auto">
      <div class="absolute left-0 z-20 flex items-center justify-between w-full py-2 backdrop-blur-sm top-2">
        <h1 class="pl-4 text-lg font-medium text-dark">Leave Request</h1>
        <a href="{{ route('leave.action') }}"
          class="pr-6 text-sm font-semibold text-secondary tt hover:text-primary">View all</a>
      </div>
      <div class="flex flex-col pt-10 w-full pr-1 space-y-2 max-h-[350px] overflow-y-auto">
        @forelse (\App\Models\Leave::where('status', 'awaiting approval')->latest()->get() as $request)
          <div
            class="flex items-center justify-between p-2 rounded-lg shadow-sm tt hover:bg-gray-100 odd:border-primary"
            x-data="{
                words: '{{ $request->message ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error optio facilis expedita dolores quis minus nisi vero tenetur quae atque accusamus quasi, necessitatibus aspernatur at deleniti. Maiores enim sequi consequuntur.' }}',
                shorten: true
            }">
            <div class="flex items-center w-3/4 space-x-2">
              <img src="/img/staff.png" alt="name"
                class="block object-cover p-1 rounded-full w-14 h-14 aspect-square">
              <div>
                <p>{{ $request->user->title . ' ' . $request->user->first_name . ' ' . $request->user->last_name }}</p>
                <p class="font-normal first-letter:capitalize">
                  <span x-text="shorten ? words.substring(0, 30) : words.substring(0, words.lenght)"
                    class="text-gray-500"></span>

                </p>
              </div>

            </div>
            <a href="{{ route('leave.action') }}" @click="shorten = !shorten"
              x-text="shorten ? 'View more': 'View less'"
              class="px-3 py-2 text-sm text-white rounded tt hover:bg-opacity-75 bg-secondary"></a>
          </div>
        @empty
          <x-empty-table comment="There is no message yet" title="notification">
            <p class="max-w-xs text-center">Your notifications will dispaly here
            </p>
          </x-empty-table>
        @endforelse
      </div>
    </div>

    {{-- fees --}}
    <div class="relative p-4 bg-white rounded-lg shadow lg:col-span-2 max-h-[300px] overflow-y-auto">
      <div class="absolute left-0 z-20 flex items-center justify-between w-full py-2 backdrop-blur-sm top-2">
        <h1 class="pl-4 text-lg font-medium text-dark">Fees</h1>
        <a href="{{ route('fees') }}" class="pr-6 text-sm font-semibold text-secondary tt hover:text-primary">View
          all</a>
      </div>
      <div class="flex flex-col pt-10 w-full pr-1 space-y-2 max-h-[300px] overflow-y-auto">

        @forelse (\App\Models\Fee::select(['type', 'amount'])->latest()->get() as $fee)
          <table class="w-full">
            <tr class="w-full">
              <td class="w-3/4 capitalize 2xl:w-5/6">{{ $fee->type }}</td>
              <td class="font-semibold text-primary">&#8358
                {{ moneyFormat($fee->amount) }}</td>
            </tr>
          </table>
        @empty
          <x-empty-table comment="Fees to be paid by student will appear here" title="fee">
            <p class="max-w-xs text-center">Fees to be paid by student will appear here
            </p>
          </x-empty-table>
        @endforelse
      </div>
    </div>
