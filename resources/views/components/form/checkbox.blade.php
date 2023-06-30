<div class="flex flex-wrap items-center text-sm gap-y-2 gap-x-4 lg:col-span-2">
  <p class="w-full text-base font-medium text-gray-500">Hobbies*</p>
  @foreach ($options as $key => $hobby)
    <label class="space-x-1 capitalize cursor-pointer" for="{{ $key }}">
      <input id="{{ $key }}" class="text-primary border-primary focus:ring-0" type="checkbox"
        value="{{ $hobby }}" wire:model="hobbies.{{ $hobby }}" id="{{ $hobby }}">
      <span>{{ $hobby }}</span>
    </label>
  @endforeach
</div>
