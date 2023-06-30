	<div class="h-12 space-y-1">
	<select wire:model.defer="{{ $name }}"
	class='w-full h-full pl-4 space-y-3 font-medium text-gray-500 placeholder-gray-500 capitalize bg-white border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:outline-none'>
	<option value="" class="text-sm capitalize">{{ $name }}*</option>
	@foreach ($options as $option)
	<option class="py-3" value="{{ $option }}">{{ $option }}</option>
	@endforeach
	</select>
	@error($name)
		<span class="text-red-600">{{ $message }}</span>
	@enderror
	</div>
