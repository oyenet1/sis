<label
  {{ $attributes->merge(['class' => 'border-2 border-grey-500 rounded-lg text-center  w-full border-dashed py-6', 'for' => 'image']) }}>
  <div class="flex flex-col justify-center mx-auto">
    <span class="block mx-auto">
      <svg class="w-20 h-12 2xl:h-[100] 2xl:w-[132]" viewBox="0 0 175 143" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M98.375 22.5L76.625 0.75H0.5V142.125H174.5V22.5H98.375ZM87.5 60.5625L125.562 98.625H98.375V142.125H76.625V98.625H49.4375L87.5 60.5625Z"
          fill="#000B17" />
      </svg>
    </span>
    <label for="image" class="mx-auto mt-4 text-center max-w-max">Drag and drop or <span
        class="cursor-pointer text-primary hover:text-secondary">browse</span>
      files
    </label>
    @error('result')
      <span class="text-red-500">{{ $message }}</span>
    @enderror
  </div>
  <input id="image" type="file" name="image" wire:model.defer="result" class="hidden">
</label>
