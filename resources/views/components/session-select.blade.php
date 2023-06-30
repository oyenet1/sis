<div class="h-12 rounded-lg border border-primary">
  <select wire:model.debounce="session_id"
    class='w-full h-full pl-4 uppercase space-y-3 font-medium text-primary bg-gray-100 border-0 rounded-lg focus:outline-none peer focus:bg-white tt focus:border-2 focus:border-primary'
    id="">
    @foreach (\App\Models\Sesion::select(['name', 'id'])->get() as $option)
      <option class="py-3 " value="{{ $option->id }}">
        {{ $option->name }}
      </option>
    @endforeach
  </select>
</div>
