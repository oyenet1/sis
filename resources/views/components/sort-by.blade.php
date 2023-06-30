<div class="relative w-32 p-0 cursor-pointer" @click.away="sort = false" x-data="{ sort: false }" @mouseenter="sort= true">
  <p class="h-full w-full  px-3 py-3 text-xs font-medium bg-white border-none rounded-lg shadow text-gray-500">Sort By
  </p>
  <svg class="absolute  font-bold top-3 h-[12px] right-2 icons-svg text-primary" viewBox="0 0 14 10" fill="none"
    xmlns="http://www.w3.org/2000/svg">
    <path
      d="M0.75 0.75C0.75 0.551088 0.829018 0.360322 0.96967 0.21967C1.11032 0.0790175 1.30109 0 1.5 0H12.5C12.6989 0 12.8897 0.0790175 13.0303 0.21967C13.171 0.360322 13.25 0.551088 13.25 0.75C13.25 0.948912 13.171 1.13968 13.0303 1.28033C12.8897 1.42098 12.6989 1.5 12.5 1.5H1.5C1.30109 1.5 1.11032 1.42098 0.96967 1.28033C0.829018 1.13968 0.75 0.948912 0.75 0.75ZM2.75 4.75C2.75 4.55109 2.82902 4.36032 2.96967 4.21967C3.11032 4.07902 3.30109 4 3.5 4H10.5C10.6989 4 10.8897 4.07902 11.0303 4.21967C11.171 4.36032 11.25 4.55109 11.25 4.75C11.25 4.94891 11.171 5.13968 11.0303 5.28033C10.8897 5.42098 10.6989 5.5 10.5 5.5H3.5C3.30109 5.5 3.11032 5.42098 2.96967 5.28033C2.82902 5.13968 2.75 4.94891 2.75 4.75ZM4.75 8.75C4.75 8.55109 4.82902 8.36032 4.96967 8.21967C5.11032 8.07902 5.30109 8 5.5 8H8.5C8.69891 8 8.88968 8.07902 9.03033 8.21967C9.17098 8.36032 9.25 8.55109 9.25 8.75C9.25 8.94891 9.17098 9.13968 9.03033 9.28033C8.88968 9.42098 8.69891 9.5 8.5 9.5H5.5C5.30109 9.5 5.11032 9.42098 4.96967 9.28033C4.82902 9.13968 4.75 8.94891 4.75 8.75Z"
      fill="#003973" />
  </svg>
  {{-- <div x-show="sort"
    class="absolute text-gray-500 top-0 mt-12 divide-y divide-dashed bg-opacity-75 backdrop-blur-sm bg-blend-saturation divide-gray-200 space-y-2 w-48 p-4 rounded-lg bg-white shadow-sm">
    @foreach ($options as $option)
      <p class="text-sm pt-2 tt hover:translate-x-2 cursor-pointer">{{ $option }}</p>
    @endforeach
  </div> --}}
  {{ $slot }}
</div>
