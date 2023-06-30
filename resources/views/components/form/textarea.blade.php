<div class="">
  <textarea
    {{ $attributes->merge(['class' => 'rounded bg-gray-50 shadow-md placeholder-capitalize capitalize border-0 p-2 px-3 focus:ring-0 placeholder-gray-500 shadow-sm h-[120px] focus:outline-none w-full']) }}
    wire:model.debounce.500ms="{{ $name }}" placeholder="{{ $placeholder }}">
  </textarea>
  @error($name)
    <span class="text-red-600">{{ $message }}</span>
  @enderror
</div>
