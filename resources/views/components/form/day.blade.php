<div class="w-full h-12 space-y-1">
  <select wire:model.defer="day_id"
    class='w-full h-full capitalize pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 bg-gray-100 border-0 rounded-lg focus:outline-none peer focus:bg-white tt focus:border-2 focus:border-primary'
    id="">
    <option value="select" class="">Day*</option>
    @foreach (\App\Models\Day::select(['id', 'name'])->get() as $option)
      <option class="py-2" value="{{ $option->id }}">
        {{ $option->name }}
      </option>
    @endforeach
  </select>
  @error('day_id')
    <span class="text-red-600">{{ $message }}</span>
  @enderror
</div>
