<div class="flex flex-col w-full gap-6 px-4 py-8 overflow-x-auto bg-white rounded-md">
  <form wire:submit.prevent='sendSingle' class="grid w-full max-w-md gap-4">
    <div class="relative ">
      <label for="on-error-email" class="text-gray-700">
        Receivers Phone
        <span class="text-red-500 required-dot">
          *
        </span>
      </label>
      <input type="text" id="on-error-email"
        class="flex-1 w-full px-4 py-2 text-base text-gray-700 placeholder-gray-400 bg-white border border-transparent border-gray-300 rounded-lg shadow-sm appearance-none ring-red-500 ring-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
        wire:model="receiver" placeholder="telephone" />
      @error('receiver')
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
          class="absolute text-red-500 right-2 bottom-3" viewBox="0 0 1792 1792">
          <path
            d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z">
          </path>
        </svg>
      @enderror
      @error('receiver')
        <p class="absolute text-sm text-red-500 -bottom-4">
          {{ $message }}
        </p>
      @enderror
    </div>

    <label class="text-gray-700" for="message">
      <textarea
        class="flex-1 w-full px-4 py-2 text-base text-gray-700 placeholder-gray-400 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
        placeholder="message" wire:model="message" rows="5" placeholder="message here" cols="40">
    </textarea>
      @error('message')
        <p class="text-sm text-red-500">
          {{ $message }}
        </p>
      @enderror
    </label>
    <button type="submit" class="px-8 py-2 -mt-2 text-white rounded bg-primary max-w-max">Send</button>
  </form>
</div>
