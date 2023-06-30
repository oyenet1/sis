<div class="w-full">
	<div class='relative w-full overflow-hidden text-gray-500 rounded-lg h-14' x-data="{ show: false }">
		<label for="{{ $label }}" class="absolute z-50 pt-2 pl-12 text-sm text-gray-500 capitalize">
			{{ $label }}</label>
		<input id="{{ $label }}" :type="show ? 'text' : 'password'" value="{{ old('password') }}" placeholder=""
			name="{{ $name }}"
			{{ $attributes->merge(['class' => 'w-full border-0 bg-gray-100 placeholder-primary  h-full pt-7  pl-12 text-sm font-medium rounded-lg focus:bg-white tt focus:border-2 focus:border-primary']) }}>
		<span class="absolute w-6 h-6 rotate-180 tt left-2 top-4 text-primary">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
				</path>
			</svg>
		</span>

		<span x-cloak class="absolute transition duration-300 cursor-pointer right-2 top-4 hover:text-black"
			@click="show = !show">
			<svg :class="show ? 'block' : 'hidden'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
				xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
				</path>
			</svg>
			<svg :class="show ? 'hidden' : 'block'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
				xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
				</path>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
				</path>
			</svg>
		</span>
	</div>
	{{ $slot }}
</div>
