<div class="w-full h-12 space-y-1">
	<select wire:model="clas_id"
		class='w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 uppercase bg-gray-100 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none'
		id="">
		<option value={{ null }} class="">Class*</option>
		@foreach (\App\Models\Clas::with(['school'])->get() as $option)
			<option class="py-2 capitalize" value="{{ $option->id }}">
				{{ $option->name . $option->section }}
			</option>
		@endforeach
	</select>
	@error('clas_id')
		<span class="text-red-600">{{ $message }}</span>
	@enderror
</div>
