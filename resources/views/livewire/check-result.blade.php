<div class="grid w-full gap-6 py-8 lg:py-12 max-w-7xl mx-auto" x-data="{ show: false }">
  {{-- fixed header --}}
  <header class="flex flex-col w-full gap-6 bg-background">
    <div class="flex items-center space-x-6">
      <form wire:submit.prevent='checkResult' class="flex items-center justify-start gap-2 lg:gap-4">
        {{-- <h1 class="text-sm font-medium uppercase text-dark">filter by</h1> --}}
        <div class="h-10 w-[180px] space-y-1 border border-primary rounded-lg bg-white">
          <select wire:model.defer="term_id" class='w-full h-full pl-4 space-y-2 uppercase text-sm font-medium text-gray-500 placeholder-gray-500 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none' id="">
            <option value="" class="">Select Term</option>
            @foreach (\App\Models\Term::with(['sesion'])->get() as $option)
            <option class="my-2 uppercase" value="{{ $option->id }}">
              {{ $option->name. ' - ' .$option->sesion->name }}
            </option>
            @endforeach
          </select>
          @error('term_id')
          <span class="text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>
        @if (currentUser()->hasRole('parent'))
        <div class="h-10 w-[140px] space-y-1 border border-primary rounded-lg bg-white">
          <select wire:model.defer="student_id" class='w-full h-full pl-4 space-y-2 uppercase text-sm font-medium text-gray-500 placeholder-gray-500 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none' id="">
            <option class="py-2 capitalize" value="{{ null }}">
              Select Student
            </option>
            @foreach (currentUser()->guardian->students as $student)
            <option class="py-2 capitalize" value="{{ $student->id }}">
              {{ $student->first_name . ' '. $student->last_name  }}
            </option>
            @endforeach
          </select>
          @error('student_id')
          <span class="text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>
        @elseif (currentUser()->hasRole('class teacher'))
        <div class="h-10 w-[140px] space-y-1 border border-primary rounded-lg bg-white">
          <select wire:model="student_id" class='w-full h-full pl-4 space-y-2 uppercase text-sm font-medium text-gray-500 placeholder-gray-500 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none' id="">
            <option class="py-2 capitalize" value="{{ null }}">
              Select Student
            </option>
            @foreach (currentUser()->clas->students as $student)
            <option class="py-2 capitalize" value="{{ $student->id }}">
              {{ $student->first_name . ' '. $student->last_name  }}
            </option>
            @endforeach
          </select>
          @error('student_id')
          <span class="text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>
        @else
        <div class="h-10 w-[140px] space-y-1 border border-primary rounded-lg bg-white">
          <select wire:model="clas_id" class='w-full h-full pl-4 space-y-2 uppercase text-sm font-medium text-gray-500 placeholder-gray-500 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none' id="">
            <option class="py-2 capitalize" value="{{ null }}">
              Select Class
            </option>
            @foreach (\App\Models\Clas::select('id', 'name', 'section')->get() as $clas)
            <option class="py-2 capitalize" value="{{ $clas->id }}">
              {{ $clas->name . ' '. $clas->section  }}
            </option>
            @endforeach
          </select>
          @error('clas_id')
          <span class="text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>
        <div class="h-10 w-[140px] space-y-1 border border-primary rounded-lg bg-white">
          <select wire:model="student_id" class='w-full h-full pl-4 space-y-2 uppercase text-sm font-medium text-gray-500 placeholder-gray-500 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none' id="">
            <option class="py-2 capitalize" value="{{ null }}">
              Select Student
            </option>
            @foreach (\App\Models\Student::where('clas_id', $clas_id)->select('id', 'first_name', 'last_name')->get() as $student)
            <option class="py-2 capitalize" value="{{ $student->id }}">
              {{ $student->first_name . ' '. $student->last_name  }}
            </option>
            @endforeach
          </select>
          @error('student_id')
          <span class="text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>
        @endif
        <button class="px-8 font-normal text-sm border-2 btn py-[6px] submit-secondary max-w-max whitespace-nowrap">Check
          ReportCard</button>
      </form>
    </div>
  </header>

  {{-- tables --}}
  @if($student_id && $term_id)
  <div class="w-full px-4 py-8 mx-auto overflow-x-auto bg-white rounded-lg shadow-sm max-w-7xl my-8 min-h-[600px]">
    <iframe src="/reportcard/{{ $term_id }}/{{ $student_id }}" frameborder="0" class="w-full my-auto min-h-full"></iframe>
  </div>
  @endif

</div>
