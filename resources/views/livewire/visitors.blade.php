<div class="z-40 flex flex-col gap-6 px-2 py-8">
  {{-- moadl forms and inputs components --}}
  <x-modal class="max-w-lg">
    {{-- <x-form title="Visitor" :update="$update">
      <x-input placeholder="Visitor's name" type="text" wire:model="name">
        @error('name')
          <span class="text-red-600">{{ $message }}</span>
        @enderror
      </x-input>
      <x-input placeholder="Visitor's telephone" type="number" wire:model="phone">
        @error('phone')
          <span class="text-red-600">{{ $message }}</span>
        @enderror
      </x-input>
      <x-form.textarea placeholder="The purpose of meeting" rows="4">
        @error('purpose')
          <span class="text-red-600">{{ $message }}</span>
        @enderror
      </x-form.textarea>
    </x-form> --}}
  </x-modal>
  <div class="flex items-center justify-between">
    <div class="flex items-center space-x-3">
      {{-- These two button will be show if the list is checked --}}
      @if ($checked)
        <button
          class="p-2 px-3 text-center text-white capitalize duration-300 border rounded border-tertiary tt bg-tertiary hover:bg-opacity-75">Select
          All - {{ count($checked) }}</button>
        {{-- onclick="confirm('Are you sure you want to delete this item') || event.stopImmediatePropagation() wire:submit='deleteMutiple'" --}}
        <button
          class="p-2 px-3 text-center text-white capitalize duration-300 bg-red-600 border border-red-600 rounded tt w-30 hover:bg-opacity-75"
          wire:click='deleteMutiple()'>Delete</button>
      @else
        <button
          class="w-48 py-2 text-center text-white capitalize duration-300 rounded-sm bg-primary tt hover:bg-opacity-75"
          wire:click="showForm()">Add
          visitor</button>
      @endif
    </div>
    <div class="flex items-center space-x-3">

      {{-- export button here --}}
      @if ($checked)
        <button
          class="p-2 px-3 text-center capitalize duration-300 bg-white border rounded hover:translate-y-1 text-primary border-primary tt"
          @click="$wire.exportCSV()">Export
          to Excel</button>
        <button
          class="p-2 px-3 text-center capitalize duration-300 bg-white border rounded hover:translate-y-1 border-primary text-primary tt"
          @click="$wire.exportPDF">Export
          to PDF</button>
      @else
        <button
          class="p-2 px-3 text-center text-white capitalize duration-300 border rounded border-primary bg-primary tt w-30 hover:bg-opacity-75">Generate
          Report</button>
      @endif
      <div class="relative w-48 p-0 lg:mr-4">
        <input type="text" wire:model.debounce.500ms="search"
          class="w-full px-3 py-2 text-xs font-medium bg-white border-none rounded-sm focus:ring-0"
          placeholder="Search Permission">
        {{-- <i class="absolute my-auto text-lg bi bi-search top-2 right-2 text-primary"></i> --}}
        <svg class="absolute w-4 h-4 font-bold top-2 right-2 icons-svg text-primary" fill="none" stroke="currentColor"
          viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
      </div>
    </div>
  </div>
  <div class="w-full space-y-4 overflow-auto border border-gray-400 shadow-sm rounded-xl">
    <table class="w-full overflow-x-auto bg-white ">
      <thead class=" rounded-t-xl">
        <tr class="p-2 text-black capitalize bg-gray-100 text-opacity-7bg-opacity-75">
          <th class=""></th>
          <th wire:click="sortBy('name')"
            class="items-center p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Visitors Name</span>
            <span class="flex-col items-center pl-2 space-y-0 ">
              @include('components.sort', ['field' => 'name'])
            </span>
          </th>
          <th wire:click="sortBy('phone')"
            class="items-center p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Telephone</span>
            <span class="flex-col items-center pl-2 space-y-0 ">
              @include('components.sort', ['field' => 'phone'])
            </span>
          </th>
          <th wire:click="sortBy('purpose')"
            class="p-2 transition duration-300 transform cursor-pointer min-w-sm hover:text-primary">
            <span class="">Purpose of Visit</span>
            <span class="flex-col items-center pl-2 space-y-0 ">
              @include('components.sort', ['field' => 'purpose'])
            </span>
          </th>
          <th wire:click="sortBy('created_at')"
            class="p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span class="">Date</span>
            <span class="flex-col items-center pl-2 space-y-0 ">
              @include('components.sort', ['field' => 'created_at'])
            </span>
          </th>
          <th class="text-center">
            <span class="">Came At</span>
          </th>
          <th class="text-center">
            <span class="">Left At</span>
          </th>
          <th class="p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span class=""></span>
            <span class=""></span>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($visitors as $visitor)
          <tr class="border-t hover:bg-secondary {{ $this->isChecked($visitor->id) ? 'bg-secondary' : '' }}">
            <td class="p-2 text-center border-r">
              <input type="checkbox" wire:model="checked" id="" value="{{ $visitor->id }}"
                class="rounded text-primary focus:bg-primary focus:text-white">
            </td>

            <td class="p-2 capitalize">{{ $visitor->name }}</td>
            <td class="p-2 capitalize">
              <a href="tel:+234{{ $visitor->phone }}" target="pop" class="hover:no-underline ">
                <p
                  class="py-1 text-black transition duration-500 bg-green-100 rounded shadow-sm hover:text-white hover:bg-green-400">
                  <i class="p-2 pl-0 m-2 ml-0 text-green-600 bg bi bi-telephone-outbound-fill "></i>
                  {{ $visitor->phone }}
                </p>
              </a>
            </td>
            <td class="max-w-lg p-2">{{ $visitor->purpose }}</td>
            <td class="p-2">{{ formatDate($visitor->created_at) }}</td>
            <td class="p-2 text-center">
              {{ returnTime($visitor->entered_at) }}
            </td>
            <td class="p-3 text-center">
              @if ($visitor->left_at)
                {{ formatTime($visitor->left_at) }}
              @else
                <span wire:click="left({{ $visitor->id }})"
                  class="px-2 py-1 text-green-500 border border-green-600 rounded cursor-pointer action-button">Left</span>
              @endif
            </td>
            <td class="p-3">
              @if (!$checked)
                <p class="flex items-center w-full gap-2 text-white">
                  {{-- <span
                  class="p-1 px-2 transition duration-300 rounded shadow-sm cursor-pointer hover:-translate-y-1 translate bg-primary">
                  <i class="text-ß 2xl:text-xl bi bi-eye"></i>
                </span> --}}
                  <span wire:click="edit({{ $visitor->id }})"
                    class="text-blue-600 border-blue-500 btn-icon action-button hover:-translate-y-1">
                    <i class="text-md 2xl:text-lg bi bi-pencil-fill"></i>
                  </span>
                  <span wire:click="confirmDelete({{ $visitor->id }})"
                    class="text-red-500 border-red-500 btn-icon action-button hover:-translate-y-1">
                    <i class="text-md 2xl:text-lg bi bi-trash"></i>
                  </span>
                </p>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div
      class="flex items-center justify-between pb-2 pl-4 pr-2 text-gray-500 lg:px-0 md:justify-end md:space-x-6 text-">
      <div class="flex items-center space-x-4">
        <span class="">Rows per page:</span>
        <select wire:model="perPage" name="" id=""
          class="w-16 px-2 py-1 text-sm bg-white border rounded focus:ring-primary">
          <option value="10">10</option>
          @for ($i = 25; $i < 101; $i = $i + 25)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="">{{ $visitors->links() }}</div>
    </div>
  </div>
</div>
