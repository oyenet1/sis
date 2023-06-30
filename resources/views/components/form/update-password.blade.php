<form wire:submit.prevent="updatePassword" class="flex flex-col justify-center w-full gap-8">
  @if ($student->email === currentUser()->email)
    <h1 class="pb-4 text-2xl font-semibold border-b">Updated Password</h1>
  @else
    <h1 class="pb-4 text-2xl font-semibold border-b">Authentication</h1>
  @endif
  <div class="grid w-full grid-cols-1 gap-6">
    @if ($student->email === currentUser()->email)
      <x-forms.password wire:model='password' name="password" label="Old password">
        @error('password')
          <span class="text-red-600 test-sm">{{ $message }}</span>
        @enderror
      </x-forms.password>
    @endif
    <x-forms.password wire:model='new_password' name="password" label="new password">
      @error('new_password')
        <span class="text-red-600 test-sm">{{ $message }}</span>
      @enderror
    </x-forms.password>
    <x-forms.password wire:model='new_password_confirmation' name="new_password_confirmation" label="Confirm password">
    </x-forms.password>
  </div>
  <button type="submit"
    class="px-16 mx-auto text-sm font-normal hover:bg-dark tt max-w-max btn btn-lg submit-primary">Update
    Password</button>
</form>
