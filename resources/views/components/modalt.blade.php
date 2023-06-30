<div x-cloak
  class="fixed inset-0 z-50 flex flex-col justify-between w-screen h-screen p-4 bg-black bg-opacity-50 modal background-blur-sm"
  x-data="{ form: @entangle('studentForm').defer }" x-show="studentForm">
  <div @click.away="form = false"
    {{ $attributes->merge(['class' => 'relative w-full py-6 px-4 mx-auto my-auto bg-white rounded-md shadow md:p-4 sm:max-w-xs md:max-w-lg']) }}>
    <span @click="form = false"
      class="absolute top-0 right-0 px-[10px] py-0 m-2 text-4xl rounded-full cursor-pointer text-gray-500 tt hover:bg-gray-200">
      &times;
    </span>
    {{ $slot }}
  </div>
</div>
