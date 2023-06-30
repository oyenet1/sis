<div class="w-full">
	<div @click="lower = true" class='relative w-full h-12 overflow-x-hidden text-gray-500 rounded-lg'
		x-data="{ lower: false }">
		<input list="opt"
			{{ $attributes->merge(['class' => 'w-full shadow-sm border-0 bg-gray-100 placeholder-gray-500 text-dark h-full pt-6  pl-4 peer focus:outline-none font-medium rounded-lg focus:bg-white tt focus:border-2 focus:border-primary', 'name' => $name, 'id' => $name]) }} />
		<label for="{{ $name }}" :class="lower ? 'text-xs pt-1' : 'pt-3'"
			class="absolute left-0 z-30 p-4 text-sm font-medium text-gray-500 capitalize cursor-text peer-focus:pt-1">
			{{ $name }}</label>
	</div>
	<datalist id="opt" class="">
		@foreach ($datas as $option)
			<option value="{{ $option->email }}">
		@endforeach
	</datalist>
	@error($name)
		<span class="mb-2 text-red-600">{{ $message }}</span>
	@enderror
</div>
