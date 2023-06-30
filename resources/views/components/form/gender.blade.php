<div class="w-full h-12 space-y-1 shadow-sm">
  <select wire:model.defer="gender"
    class='w-full h-full pl-4 space-y-1 font-medium text-gray-500 placeholder-gray-500 capitalize bg-gray-100 border-0 rounded-lg focus:outline-none peer focus:bg-white tt focus:border-2 focus:border-primary'
    id="">
    <option value="select" class="text-sm" selected>Gender*</option>
    @foreach (['male', 'female'] as $option)
      <option class="py-2" value="{{ $option }}">{{ $option }}</option>
    @endforeach
  </select>
  @error('gender')
    <span class="text-red-600">{{ $message }}</span>
  @enderror
</div>
