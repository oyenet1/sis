<div class="h-12 w-[150px] space-y-1">
	<select wire:model.defer="role_id"
		class='w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 capitalize bg-white border-0 rounded-lg shadow-sm peer tt focus:border-2 focus:border-primary focus:outline-none'
		id="">
		<option value="" class="">Role</option>
		@foreach (\App\Models\Role::select(['id', 'name'])->get() as $option)
			@if ($option->id === 1)
				@continue
			@endif
			<option class="py-2 capitalize" value="{{ $option->id }}">
				{{ $option->name }}
			</option>
		@endforeach
	</select>
	@error('role_id')
		<span class="text-red-600">{{ $message }}</span>
	@enderror
</div>
