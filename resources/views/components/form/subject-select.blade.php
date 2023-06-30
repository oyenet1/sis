<div class="h-12 space-y-1 ">
  <select wire:model="subject_id"
    class='w-full h-full pl-4 space-y-3 font-medium text-gray-500 placeholder-gray-500 capitalize bg-gray-100 border-0 rounded-lg focus:outline-none peer focus:bg-white tt focus:border-2 focus:border-primary'
    id="">
    <option value="select" class="text-sm capitalize">{{ $name }}*</option>
    @foreach (\App\Models\Subject::select(['id', 'name'])->get() as $option)
      <option class="py-3 capitalize" value="{{ $option->id }}">{{ $option->name }}</option>
    @endforeach
  </select>
  @error('subject_id')
    <span class="text-red-600">{{ $message }}</span>
  @enderror
</div>
