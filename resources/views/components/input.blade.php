<div class="w-full">
    <div @click="lower = true" class='relative w-full h-12 overflow-x-hidden text-gray-500 rounded-lg shadow-sm'
        x-data="{ lower: false }">
        <input
            {{ $attributes->merge(['class' => 'w-full shadow-sm border border-primary bg-white placeholder-gray-500 text-dark h-full pt-6  pl-4 peer focus:outline-none font-medium shadow rounded-lg focus:bg-white tt focus:border-2 focus:border-primary', 'type' => $type, 'name' => $name, 'id' => $label]) }} />
        <label for="{{ $label }}" :class="lower ? 'text-xs pt-1' : 'pt-3'"
            class="absolute left-0 z-30 p-4 text-sm font-medium text-gray-500 capitalize cursor-text peer-focus:pt-1">
            {{ $label }}</label>
    </div>
    @error($name)
        <span class="mb-2 text-red-600">{{ $message }}</span>
    @enderror
</div>
