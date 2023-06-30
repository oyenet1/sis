<div class="h-12 space-y-1">
	<select wire:model.debounce="clas_id"
		class='w-full h-full pl-4 space-y-3 font-medium text-gray-500 placeholder-gray-500 uppercase bg-gray-100 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none'
		id="">
		<option value="select" class="text-sm capitalize">{{ $name }}*</option>
		@foreach (\App\Models\Clas::with('school')->get() as $option)
			<option class="py-3" value="{{ $option->id }}">
				{{ $option->name . $option->section }}
				{{ $option->high ? '- ' . $option->high : '' }}
			</option>
		@endforeach
	</select>
	@error('clas_id')
		<span class="text-red-600">{{ $message }}</span>
	@enderror
</div>
