<div class="h-10 border rounded-lg border-primary">
  <select wire:model.debounce="session_id"
    class='w-full h-full pl-4 space-y-3 text-sm font-medium capitalize bg-transparent border-0 rounded-lg text-primary focus:outline-none peer focus:bg-white tt focus:border-2 focus:border-primary'
    id="">
    <option value="" class="capitalize">All Time</option>
    @foreach (\App\Models\Sesion::select(['name', 'id'])->get() as $option)
      <option class="py-3 " value="{{ $option->id }}">
        {{ $option->name }}
      </option>
    @endforeach
  </select>
</div>
