<div class="relative w-full overflow-hidden text-gray-500 rounded h-11">
  <input type="email" name="email"
    class="w-full h-full py-2 pl-8 text-sm font-medium placeholder-gray-500 border-gray-300 rounded focus:border-2 focus:border-primary"
    placeholder="Enter your staff ID">
  {{-- span elements --}}
  <svg class="absolute z-20 w-6 h-6 my-auto left-2 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
    </path>
  </svg>
  @error('email')
    <span class="text-sm text-red-500">{{ $message }}</span>
  @enderror
</div>
