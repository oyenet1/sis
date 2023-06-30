<div class="w-full space-y-4">
  <form wire:submit.prevent="save" class="flex flex-col justify-center w-full gap-8">
    <div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-2">
      {{ $slot }}
    </div>
    <button type="submit"
      class="px-16 mx-auto text-sm font-normal hover:bg-dark tt max-w-max btn btn-lg submit-primary">Save and
      Continue</button>
  </form>
</div>
