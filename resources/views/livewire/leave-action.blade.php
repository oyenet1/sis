<div class="z-20 flex flex-col gap-6 py-8 lg:py-12">
  {{-- alert notification --}}
  @if (session('success'))
    <x-alert type="success" :message="session('success')">
      <i class="text-3xl bi bi-check2-circle"></i>
    </x-alert>
  @endif
  <div class="flex items-center justify-between">
    <h1 class="text-3xl font-semibold capitalize text-primary">Leave </h1>

    {{-- user search components --}}
    <x-search name="leave" />
  </div>
  {{-- tables --}}
  <div class="w-full px-4 pb-4 overflow-x-auto bg-white rounded-lg shadow-sm ">
    <table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
      <thead class="w-full pb-4 text-xl border-b">
        <tr class="font-medium">
          {{-- <th class="p-2 whitespace-nowrap"></th> --}}
          <th class="p-2 whitespace-nowrap">#</th>
          <th class="p-2 text-xl font-medium text-left">Name</th>
          <th class="p-2 text-xl font-medium text-left">Staff ID</th>
          <th class="p-2 text-xl font-medium text-left">Position</th>
          <th class="p-2 text-xl font-medium text-left">Notes</th>
          <th class="p-2 text-xl font-medium text-left">Status</th>
          <th class="p-2"></th>
        </tr>
      </thead>
      <tbody class="w-full overflow-x-auto break-normal">
        @forelse ($leaves as $request)
          <tr class="even:bg-primary-light">
            {{-- <td class="p-2 whitespace-nowrap">
              <input type="checkbox" wire:model="checked" id="" value="{{ $request->id }}"
                class="block rounded text-primary whitespace-nowrap focus:outline-none focus:ring-primary">
            </td> --}}
            <td class="p-2 whitespace-nowrap">
              <img src="/img/staff.png" alt="{{ $request->user->first_name . ' ' . $request->user->last_name }}"
                class="block object-cover p-1 rounded-full w-14 h-14 aspect-square">
            </td>
            <td class="p-2">
              <p class="">{{ $request->user->first_name . ' ' . $request->user->last_name }}</p>
              <p class="text-sm text-gray-500">Requested on
                <span class="font-medium">{{ formatDate($request->created_at) }}</span>
              </p>
            </td>
            <td class="p-2">
              {{ $request->user->school_id }}
            </td>
            <td class="p-2 capitalize">
              {{ $request->user->roles[0]->name ?? '' }}
            </td>
            <td class="p-2 max-w-[200px]">
              <span>{{ Str::limit($request->message, 20, '...') }}</span>

            </td>
            <td class="p-2 capitalize">
              @if ($request->status === 'awaiting approval')
                <span
                  class="px-3 py-1 text-sm font-normal bg-opacity-25 rounded-lg shadow-sm text-secondary bg-secondary ">{{ $request->status }}</span>
              @elseif($request->status == 'denied')
                <span
                  class="px-3 py-1 text-sm font-normal text-red-600 bg-red-600 bg-opacity-25 rounded-lg shadow-sm ">{{ $request->status }}</span>
              @else
                <span
                  class="px-3 py-1 text-sm font-normal bg-opacity-25 rounded-lg shadow-sm bg-green-600 text-green-600">{{ $request->status }}</span>
              @endif
            </td>
            <td class="p-2">
              <span wire:click="view({{ $request->id }})"
                class="py-2 font-medium border-primary px-6 rounded-lg cursor-pointer tt hover:text-primary border text-sm hover:bg-white text-white bg-primary">View</span>
              {{-- where request message shows when click on view button --}}
              <x-modal class="max-w-lg lg:max-w-2xl 2xl:max-w-4xl">
                <div>
                  <div class="flex flex-col space-y-6 justify-center p-4 px-6 lg:px-12 xl:px-20">
                    <div class="text-center justify-center">
                      <img src="/img/staff.png" alt="{{ $request->user_id . ' ' . $request->user_id }}"
                        class="block object-cover mx-auto p-1 rounded-full w-24 aspect-square">
                      <h1 class="text-xl font-semibold">
                        {{ $request->user->first_name . $request->user->last_name }}</h1>
                      <p class="text-gray-400 font-medium">{{ $request->user->school_id }}</p>
                    </div>
                    <div class="border-2 shadow-sm rounded-lg p-4">
                      <span x-text="words" class="w-full break-words">
                        {!! strval($request->message) !!}
                      </span>
                    </div>
                  </div>
                  <div class="flex items-center justify-center text-center gap-4 xl:gap-8 py-4">
                    <button type="button" class="w-[183px] btn-primary btn tt" wire:click="accept">Approve</button>
                    <button type="button" class="w-[183px] btn-primary-outline btn tt"
                      wire:click="decline">Decline</button>
                  </div>
                </div>
              </x-modal>
            </td>
          </tr>
        @empty
          <h1 class="text-2xl font-bold">No records found in the database</h1>
        @endforelse
      </tbody>
    </table>

    {{-- pagnation components --}}
    <div class="mt-4">
      <x-per-page>
        {{ $leaves->links() }}
      </x-per-page>
    </div>
  </div>

</div>
