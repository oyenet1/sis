<div class="w-full shadow-sm">
  <div @click="lower = true" class='relative w-full h-12 overflow-x-hidden text-gray-500 rounded-lg'
    x-data="{ lower: false }">
    <input type="date"
      {{ $attributes->merge(['class' => 'w-full border-0 bg-gray-100 placeholder-gray-500 text-dark h-full pt-6  pl-4 peer focus:outline-none font-medium rounded-lg focus:bg-white tt focus:border-2 focus:border-primary', 'name' => $name, 'id' => $label]) }} />
    <label for="{{ $label }}"
      class="absolute left-0 z-30 p-4 pt-1 text-sm font-medium text-gray-500 capitalize cursor-text peer-focus:pt-1">
      {{ $label }}</label>
  </div>
  @error($name)
    <span class="mb-2 text-red-600">{{ $message }}</span>
  @enderror
</div>
