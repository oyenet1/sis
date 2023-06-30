<div class="relative w-full overflow-hidden text-gray-500 rounded h-14">
	<label for="school_id" class="absolute z-50 pt-2 pl-12 text-sm text-gray-500 capitalize"
		x-text="login == 'email' ? 'Email Address': 'School ID'">
	</label>
	<input type="text" value="{{ old('school_id') }}" name="school_id"
		{{ $attributes->merge(['class' => 'w-full border-0 bg-gray-100 placeholder-gray-300 h-full pt-6  pl-12 text-sm font-medium rounded-lg focus:bg-white tt focus:border-2 focus:border-primary']) }}
		:placeholder="login == 'email' ? '' : ''">
	{{-- span elements --}}
	<span class="absolute z-20 my-auto left-2 top-4">
		<svg x-cloak class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
			xmlns="http://www.w3.org/2000/svg" x-show="login == 'id'">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
				d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
			</path>
		</svg>

		<svg x-cloak xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6 bi bi-envelope text-primary"
			viewBox="0 0 16 16 " x-show="login == 'email'">
			<path
				d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
		</svg>
	</span>
</div>
