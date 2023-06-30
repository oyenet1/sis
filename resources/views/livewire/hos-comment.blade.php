<div class="mx-auto flex w-full flex-col gap-6 px-4 py-8 lg:px-6 lg:py-6 2xl:w-[1280px] 2xl:gap-8">
  <div class="flex flex-col items-center justify-between md:flex-row">
    <div class="flex flex-col space-x-8 md:flex-row">
      <h1 class="text-3xl font-semibold capitalize text-primary -pb-4">Head of School Comment</h1>

    </div>
    <a href="{{ route('home') }}" class="px-6 py-1 text-sm bg-white border rounded border-primary text-primary hover:bg-primary hover:text-white tt">Go
      to
      Dashboard</a>
  </div>

  {{-- alert notification --}}
  @if (session('success'))
  <x-alert type="success" :message="session('success')">
    <i class="text-3xl bi bi-check2-circle"></i>
  </x-alert>
  @endif

  <div class="grid w-full">
    @error('date')
    <span class="text-sm block p-1 bg-white rounded max-w-max shadow-sm text-red-600">{{ $message }}</span>
    @enderror
    <form wire:submit.prevent='saveDate' class="flex space-x-0 items-end">
      <div class="space-y-1">
        <label for="" class="text-dark">Next year resumtion date</label><br>
        <input type="date" wire:model="date" class="rounded py-2 text-sm px-3 border border-primary"><br>
      </div>
      <button class="px-8 py-[6px] font-normal border-2 btn-sm submit-secondary max-w-min">
        Save</button>
    </form>
  </div>
  <h1 class="text-xl font-semibold text-center capitalize">
    REPORT SHEET FOR <span class="uppercase">{{ currentTerm() }}</span> </h1>

  <div class="grid grid-cols-1 gap-8 p-8 bg-white rounded-lg shadow xl:gap-12 2xl:gap-20 lg:grid-cols-4">
    <div class="space-y-2 lg:col-span-3">
      <h1 class="text-xl font-semibold uppercase text-dark">
        {{ $student->first_name . ' ' . $student->last_name }}</h1>
      <div class="grid w-full grid-cols-1 gap-8 md:grid-cols-2 2xl:gap-20">
        <div class="p-3 border rounded border-dark">
          <table class="w-full">
            <tbody class="w-full">
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1" style="word-wrap: normal; word-break: keep-all">Admission No:</td>
                <td class="py-1 uppercase text-dark">
                  {{ $student->admission_id ?? $student->student_id }}</td>
              </tr>
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1">Class:</td>
                <td class="py-1 uppercase text-dark">
                  {{ $student->clas->name . $student->clas->section }}
                </td>
              </tr>
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1">Session:</td>
                <td class="py-1 uppercase text-dark">
                  {{ latestTerm()->sesion->name }}
                </td>
              </tr>
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1">Term:</td>
                <td class="py-1 uppercase text-dark">
                  {{ latestTerm()->name }}
                </td>
              </tr>
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1">No in Class:</td>
                <td class="py-1 uppercase text-dark">
                  {{ $student->clas->students->count() }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="p-3 border rounded border-dark">
          <table class="w-full">
            <tbody class="w-full">
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1" style="word-wrap: normal; word-break: keep-all">Final Position</td>
                <td class="py-1 lowercase text-dark">
                  {{ ordinal(positionInClass($student->clas_id, latestTerm()->id, $student->id)) }}
                </td>
              </tr>
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1">Final Average:</td>
                <td class="py-1 uppercase text-dark">
                  {{ studentFinalAverage($student->id, latestTerm()->id) }}
                </td>
              </tr>
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1">Class Average:</td>
                <td class="py-1 uppercase text-dark">
                  {{ classFinalAverage($student->clas_id, latestTerm()->id) }}
                </td>
              </tr>
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1">Highest Ave. in Class:</td>
                <td class="py-1 uppercase text-dark">
                  {{ classHighestAverage($student->clas_id, latestTerm()->id) }}
                </td>
              </tr>
              <tr class="py-1 font-medium text-black text-opacity-50">
                <td class="py-1">Lowest Ave. in Class:</td>
                <td class="py-1 uppercase text-dark">
                  {{ classLowestAverage($student->clas_id, latestTerm()->id) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div>
      <h1 class="font-semibold text-gray-500 uppercase">Final Grade: <span class="text-dark">{{ grd(studentFinalAverage($student->id, latestTerm()->id)) }}</span></h1>
      <div class="flex justify-between mt-8">
        <h1 class="font-semibold capitalize text-dark">Attendance</h1>
      </div>
      <div class="">
        <table class="w-full " :class=" attend ? 'hidden' : ''">
          <tbody class="w-full">
            @php
            $studentAttendance = $student->studentAttendance($student->id, latestTerm()->id);
            @endphp
            <tr class="py-1 font-medium text-black text-opacity-50">
              <td class="py-1" style="word-wrap: normal; word-break: keep-all">Days School Opens:</td>
              <td class="py-1 text-right uppercase text-dark">
                {{ latestTerm()->dso ?? latestTerm()->start->diffInDays(latestTerm()->end) }}</td>
            </tr>
            <tr class="py-1 font-medium text-black text-opacity-50">
              <td class="py-1">Day<span class="text-sm">(s)</span> Present:</td>
              <td class="py-1 text-right uppercase text-dark">
                {{ $studentAttendance }}
              </td>
            </tr>
            <tr class="py-1 font-medium text-black text-opacity-50">
              <td class="py-1">Day<span class="text-sm">(s)</span> Absent:</td>
              <td class="py-1 text-right uppercase text-dark">
                {{ intval(latestTerm()->dso ?? latestTerm()->start->diffInDays(latestTerm()->end)) - $studentAttendance}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- subjects scores --}}
  <div class="w-full px-4 pb-4 mx-auto overflow-x-auto bg-white rounded-lg shadow-sm max-w-7xl ">
    @php
    $scores = studentScores($student->id, latestTerm()->id);
    @endphp
    <table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
      <thead class="w-full pb-4 border-b border-gray-500">
        <tr class="z-10 text-sm text-center text-gray-500 uppercase border-b border-gray-500">
          <td></td>
          <th class="text-left">Subject</th>
          <th>ca1 <br> (10%)</th>
          <th>ca2 <br> (10%)</th>
          <th>pm <br> (20%)</th>
          <th>bm <br> (20%)</th>
          <th>em <br> (40%)</th>
          <th>total <br> (100%)</th>
          <th>grd</th>
          <th>pos</th>
          <th>out of</th>
          <th class="text-xs">low <br> in <br> class</th>
          <th class="text-xs">high <br> in <br> class</th>
          <th>class <br>avg</th>
          <th class="text-left">comment</th>
        </tr>
      </thead>
      <tbody class="w-full overflow-x-auto break-normal">
        @foreach ($scores as $score)
        <tr class="border-b border-primary">
          <td class="p-2">
            {{ $loop->iteration }}

          </td>
          <td class="p-1">
            {{ $score->subject->name }} <br>

          </td>
          <td class="p-1 text-center">
            <span class="inline-block py-1 border px-2 border-black w-[50px]">
              {{ number_format($score->ca1, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="inline-block py-1 border px-2 border-black w-[50px]">
              {{ number_format($score->ca2, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="inline-block py-1 border px-2 border-black w-[50px]">
              {{ number_format($score->pm, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="inline-block py-1 border px-2 border-black w-[50px]">
              {{ number_format($score->bm, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="inline-block py-1 border px-2 border-black w-[50px]">
              {{ number_format($score->em, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="{{ grdColor(grd($score->total)) }} px-2 font-medium py-1 border border-black w-[50px]">
              {{ number_format($score->total, 2) }}</span>
          </td>
          <td class="text-center">
            <b class="inline-block py-1 border px-2 border-black w-[40px] {{ grdColor(grd($score->total)) }}">{{ grd($score->total) }}</b>
          </td>
          <td class="text-center"> <span class="border inline-block py-1  border-black w-[40px] {{ $score->total == highInClass($score->subject_id, $score->term_id, $score->clas_id, $score->total) && $score->total > 0 ? 'bg-green-600 text-white' : 'border' }}">{{ positionInSubject($score->subject_id, $score->term_id, $score->clas_id, $score->total) }}</span>
          </td>
          <td class="text-center"> <span class="inline-block py-1 border px-2 border-black w-[40px]">{{ $score->clas->students->count() }}</span>
          </td>
          <td class="text-center">
            <b class="inline-block py-1 border px-2 border-black w-[40px]">{{ lowInClass($score->subject_id, $score->term_id, $score->clas_id, $score->total) }}</b>
          </td>
          <td class="text-center">
            <b class="inline-block py-1 border px-2 border-black w-[40px]">{{ highInClass($score->subject_id, $score->term_id, $score->clas_id, $score->total) }}</b>
          </td>
          <td class="text-center">
            <b class="inline-block py-1 border px-2 border-black w-[50px]">{{ classAverage($score->subject_id, $score->term_id, $score->clas_id, $score->total) }}</b>
          </td>
          <td class="text-sm uppercase"> <span class="inline-block py-1 font-medium border px-2 border-black min-w-[40px]">{{ $score->total > 0 ? comment($score->total) : '' }}</span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{-- affective trait and psychomotor --}}
  <div class="grid grid-cols-1 gap-8 md:grid-cols-2 2xl:gap-20">
    <div class=" rounded-lg">
      <table class="w-full bg-white border-2 border-dark uppercase">
        <tr>
          <th class="text-left py-2 text-lg border-2 border-dark px-3">affective trait</th>
          <th class="py-2 border-2 text-lg border-dark px-3">rating</th>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">punctuality</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->punctuality: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">attendance</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->attendance: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">reliability</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->reliability: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">neatness</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->neatness: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">politeness</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->politeness: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">honesty</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->honesty: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">relationship</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->relationship: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">self control</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->self_control: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">attentiveness</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->attentiveness: '' }}</td>
        </tr>
        <tr class="border-2 border-dark">
          <td class="p-2 border-2 border-dark">perseverance</td>
          <td class="p-2 border-2 border-dark text-center">{{ affectiveTrait($student->id, latestTerm()->id) ? affectiveTrait($student->id, latestTerm()->id)->perseverance: '' }}</td>
        </tr>
      </table>
      <div class="text-dark uppercase font-medium pt-2">
        <p>Next term begins: <span class="font-medium text-secondary"> {{ latestTerm()->resumption ? latestTerm()->resumption->date->format('d M, Y'):'date no set' }}</span></p>
      </div>
    </div>
    <div class="flex flex-col gap-8 p-0">
      <div class=" bg-white">
        <table class="w-full bg-white border-2 border-dark uppercase">
            <tr>
              <th class="text-left py-2 text-lg border-2 border-dark px-3">psychomotors</th>
              <th class="py-2 border-2 text-lg border-dark px-3">rating</th>
            </tr>
            <tr class="border-2 border-dark">
              <td class="p-2 border-2 border-dark">handwriting</td>
              <td class="p-2 border-2 border-dark text-center">{{ pyschomotors($student->id, latestTerm()->id) ? pyschomotors($student->id, latestTerm()->id)->handwriting: '' }}</td>
            </tr>
            <tr class="border-2 border-dark">
              <td class="p-2 border-2 border-dark">games</td>
              <td class="p-2 border-2 border-dark text-center">{{ pyschomotors($student->id, latestTerm()->id) ? pyschomotors($student->id, latestTerm()->id)->games: '' }}</td>
            </tr>
            <tr class="border-2 border-dark">
              <td class="p-2 border-2 border-dark">sports</td>
              <td class="p-2 border-2 border-dark text-center">{{ pyschomotors($student->id, latestTerm()->id) ? pyschomotors($student->id, latestTerm()->id)->sports: '' }}</td>
            </tr>
            <tr class="border-2 border-dark">
              <td class="p-2 border-2 border-dark">drawing</td>
              <td class="p-2 border-2 border-dark text-center">{{ pyschomotors($student->id, latestTerm()->id) ? pyschomotors($student->id, latestTerm()->id)->drawing: '' }}</td>
            </tr>
            <tr class="border-2 border-dark">
              <td class="p-2 border-2 border-dark">crafts</td>
              <td class="p-2 border-2 border-dark text-center">{{ pyschomotors($student->id, latestTerm()->id) ? pyschomotors($student->id, latestTerm()->id)->crafts: '' }}</td>
            </tr>
            <tr class="border-2 border-dark">
              <td class="p-2 border-2 border-dark">music</td>
              <td class="p-2 border-2 border-dark text-center">{{ pyschomotors($student->id, latestTerm()->id) ? pyschomotors($student->id, latestTerm()->id)->music: '' }}</td>
            </tr>
          </table>
      </div>
      <div>
        <form class="w-full space-y-2" wire:submit.prevent="saveComment">
          <x-form.textarea class="bg-white" name="remarks" placeholder="Head of school comment here" />

          <button type="submit" class="inline-block tt hover:bg-dark float-right text-sm text-white bg-primary rounded px-6 py-2">save</button>
        </form>
      </div>
    </div>
  </div>
</div>
