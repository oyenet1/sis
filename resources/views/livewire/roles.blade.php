<div class="z-50 flex flex-col gap-6 px-2 py-8">
  <div class="flex items-center justify-between">
    <button
      class="w-48 py-2 text-center text-white capitalize duration-300 rounded-sm bg-primary hover:bg-opacity-50">Add
      permission</button>
    <div class="relative w-48 p-0 lg:mr-4">
      <input type="text" wire:model.debounce="search"
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
  <div class="w-full space-y-4 overflow-auto border border-gray-400 shadow-sm rounded-xl">
    <table class="w-full overflow-x-auto bg-white ">
      <thead class=" rounded-t-xl">
        <tr class="text-black text-opacity-50 capitalize">
          <th class=""></th>
          <th class="items-center p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span wire:click="sortBy('name')" class="">Name</span>
            <span class="flex-col items-center pl-2 space-y-0 ">
              @include('components.sort', ['field' => 'name'])
            </span>
          </th>
          <th class="p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span wire:click="sortBy('display_name')" class="">Display As</span>
            <span class="flex-col items-center pl-2 space-y-0 ">
              @include('components.sort', ['field' => 'display_name'])
            </span>
          </th>
          <th class="p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span wire:click="sortBy('description')" class="">Description</span>
            <span class="flex-col items-center pl-2 space-y-0 ">
              @include('components.sort', ['field' => 'description'])
            </span>
          </th>
          <th class="text-center">
            <span class="">No of users</span>
          </th>
          <th class="p-2 transition duration-300 transform cursor-pointer hover:text-primary">
            <span class=""></span>
            <span class=""></span>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($roles as $role)
          <tr class="border-t">
            {{-- <td class="p-2">
          <input type="checkbox" name="" id="" class="rounded text-primary focus:bg-primary focus:text-white">
        </td> --}}
            <td class="py-2 pl-4 capitalize">{{ $loop->index + 1 }}</td>
            <td class="p-3 capitalize">{{ $role->name }}</td>
            <td class="p-3">{{ $role->display_name }}</td>
            <td class="p-3">
              {{ Str::limit('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi ipsam repudiandae, accusantium modi cupiditate dolore reprehenderit explicabo magnam soluta sed officia veniam doloremque excepturi, dolorum quam accusamus sapiente incidunt? Placeat.',50,'...') }}
            </td>
            <td class="p-3 text-center">{{ $role->users->count() }}</td>
            <td class="p-3"></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div
      class="flex items-center justify-between pb-2 pl-4 pr-2 text-gray-500 lg:px-0 md:justify-end md:space-x-6 text-">
      <div class="flex items-center space-x-4">
        <span class="">Rows per page:</span>
        <select wire:model="perPage" name="" id=""
          class="px-2 py-1 text-sm bg-white border-0 rounded focus:ring-primary w-14">
          <option value="10">10</option>
          @for ($i = 25; $i < 101; $i = $i + 25)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="">{{ $roles->links() }}</div>
    </div>
  </div>
</div>
