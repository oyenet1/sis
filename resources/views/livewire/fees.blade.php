<div class="grid w-full gap-6 py-8 lg:py-12">
  {{-- form --}}
  {{-- modal forms and inputs components --}}
  <x-modal class="max-w-lg">
    <x-form title="fee" :update="$update">
      <x-input label="Amount*" name="amount" type="number" step=".01" wire:model.defer="amount" />

      <x-input label="Fees Type*" class="cursor-pointer" name="type" type="text" wire:model.defer="type" />
      {{-- class associated --}}
      <x-clas-select />
      {{-- term associated --}}
      <div class="relative w-full h-12 space-y-1" x-data="{ select: 'Session' }">
        <label for="term_id" :class="$refs.term.value.length > 0 ? 'hidden' : ''"
          class="absolute z-50 pl-4 text-sm font-medium">Session</label>
        <select wire:model.defer="term_id" x-ref="term"
          class='absolute w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 capitalize bg-gray-100 border-0 rounded-lg bottom-2 focus:outline-none peer focus:bg-white tt focus:border-2 focus:border-primary'
          id="term_id">
          <option value="{{ null }}" selected></option>
          @foreach (\App\Models\Term::latest()->get() as $option)
            <option class="absolute bottom-0 py-2 -mb-2 capitalize" value="{{ $option->id }}">
              {{ $option->sesion->name . ' ' . '(' . $option->name . ' ' . 'term)' }}
            </option>
          @endforeach
        </select>
        @error('term_id')
          <span class="text-red-600">{{ $message }}</span>
        @enderror
      </div>
    </x-form>
  </x-modal>

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


  {{-- fixed header --}}
  <header class="flex flex-col w-full gap-6 bg-background">
    {{-- headers links with numbers of fees both total and active --}}
    <div class="flex flex-wrap items-center justify-end w-full">
      {{-- users link are here --}}


      <div class="flex flex-col text-gray-500">
        <p class="">Balance:
          <strong class="text-dark">{{ moneyFormat(\App\Models\fee::latest()->first()->balance ?? 0) }}</strong>
        </p>
      </div>
    </div>

    {{-- buttons --}}
    <div class="flex items-center justify-between ">
      <div class="flex items-center space-x-6">
        <h1 class="text-3xl font-semibold capitalize text-primary">fee</h1>
        @if ($checked)
          <button class="font-normal btn btn-secondary">Total ({{ count($checked) }})</button>
        @else
          <x-button.add name="fee" />
        @endif

      </div>

      {{-- right side --}}
      <div class="flex items-center space-x-6">
        @if ($checked)
          <x-button.generate-excel />
          <x-button.generate-report />
        @else
        @endif
        <x-search name="fees" />
      </div>
    </div>
  </header>

  {{-- tables --}}
  <div class="w-full px-4 pb-4 overflow-x-auto bg-white rounded-lg shadow-sm ">
    <table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
      <thead class="w-full pb-4 text-xl border-b">
        <tr class="z-10 font-medium">
          <th class="pl-2 text-left">
            <input type="checkbox" wire:model="selectPage"
              class="rounded text-primary focus:bg-primary focus:text-white">
          </th>
          <th wire:click="sortBy('type')"
            class="items-center p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Fees Type</span>

          </th>
          <th wire:click="sortBy('term_id')"
            class="p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Session</span>
          </th>
          <th wire:click="sortBy('clas_id')"
            class="items-center p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Class</span>
          </th>
          <th wire:click="sortBy('amount')"
            class="items-center p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Amount</span>
          </th>
          <th class="items-center p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Payment Made</span>
          </th>

          <th class="p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Sum</span>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody class="w-full overflow-x-auto break-normal">
        @forelse ($fees as $fee)
          <tr class="capitalize even:bg-primary-light">
            <td class="p-2">
              <input type="checkbox" wire:model="checked" id="" value="{{ $fee->id }}"
                class="rounded text-primary focus:outline-none focus:ring-primary">
            </td>
            <td class="p-2 capitalize">
              {{ $fee->type }}
            </td>

            <td class="p-2 uppercase">
              {{ $fee->term->sesion->name . ' (' . $fee->term->name . ' term)' }}
            </td>
            <td class="p-2 uppercase">
              @if ($fee->clas)
                <span>{{ $fee->clas->school->short . ' ' . $fee->clas->name . $fee->clas->section }}</span>
              @else
                <span>-----</span>
              @endif
            </td>
            <td class="p-2 capitalize">
              <span class="p-2 bg-opacity-25 rounded shadow-sm bg-secondary text-secondary "> &#8358
                {{ moneyFormat($fee->amount) }}</span>
            </td>

            <td class="p-2 capitalize">
              {{ $fee->payments->count() > 0 ? $fee->payments->count() : 'none' }}
            </td>
            <td class="p-2 capitalize">
              <span class="p-2 text-green-600 bg-green-600 bg-opacity-25 rounded shadow-sm "> &#8358
                {{ moneyFormat($fee->payments->count() * $fee->amount) }}</span>
            </td>

            <td class="p-2 whitespace-nowrap">
              @if (!$checked)
                <div class="flex space-x-2 item-center">
                  <span wire:click="edit({{ $fee->id }})"
                    class="w-8 h-8 p-2 text-blue-600 border border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-pencil" viewBox="0 0 16 16">
                      <path
                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                    </svg>
                  </span>
                  <span wire:click="confirmDelete({{ $fee->id }})"
                    class="w-8 h-8 p-2 text-red-600 border border-red-600 rounded-full cursor-pointer tt hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-trash3" viewBox="0 0 16 16">
                      <path
                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                    </svg>
                  </span>
                </div>
              @endif
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
        {{ $fees->links() }}
      </x-per-page>
    </div>
  </div>
</div>
