<div class="w-full h-12 space-y-1">
  <select wire:model="religion"
    class='w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 uppercase bg-gray-100 border-0 rounded-lg focus:outline-none peer focus:bg-white tt focus:border-2 focus:border-primary'
    id="">
    <option value="" class="">Religion*</option>
    @foreach (['Christian', 'Muslim', 'Judaism', 'others'] as $option)
      <option class="py-2 capitalize" value="{{ $option }}">
        {{ $option }}
      </option>
    @endforeach
  </select>
  @error('religion')
    <span class="text-red-600">{{ $message }}</span>
  @enderror
</div>
