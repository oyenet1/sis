<div class="w-[160px] h-12 space-y-1">
  <select wire:model.defer="code" x-data="{ country: 'NG' }"
    {{ $attributes->merge(['class' => 'w-full border-0 space-y-1 bg-gray-100 placeholder-gray-500 text-gray-500 focus:outline-none h-full  pl-4 peer font-medium rounded-lg focus:bg-white focus:ring-2 ring-primary ring- tt ']) }}
    id="">
    @foreach (countries() as $key => $option)
      <option class="text-sm" value="{{ $option['dial_code'] }}">
        {{ $option['dial_code'] . ' ' . $option['code'] }}</option>
    @endforeach
  </select>
  @error('code')
    <span class="text-red-600 ">{{ $message }}</span>
  @enderror
</div>
