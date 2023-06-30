<div class="grid w-full gap-6 py-8 lg:py-12">
  {{-- form --}}
  {{-- modal forms and inputs components --}}
  <x-modal class="max-w-lg">
    <x-form title="scores" :update="$update" header="Assign">
      <div class="grid grid-cols-2 gap-4 px-4 md:gap-8">
        <x-input label="CA1" name="ca1" type="number" step=".01" wire:model.defer="ca1" />
        <x-input label="CA2" name="ca2" type="number" step=".01" wire:model.defer="ca2" />
        <x-input label="bm" name="bm" type="number" step=".01" wire:model.defer="bm" />
        <x-input label="pm" name="pm" type="number" step=".01" wire:model.defer="pm" />
      </div>
      <div class="px-4">
        <x-input label="em" name="em" type="number" step=".01" wire:model.defer="em" />
      </div>
    </x-form>
  </x-modal>

  {{-- alert notification --}}
  @if (session('success'))
  <x-alert type="success" :message="session('success')">
    <i class="text-3xl bi bi-check2-circle"></i>
  </x-alert>
  @elseif (session('error'))
  <x-alert type="error" :message="session('error')">
    <i class="text-3xl bi bi-check2-circle"></i>
  </x-alert>
  @else
  @endif

  @php
  $list = [];
  @endphp
  {{-- fixed header --}}
  <header class="flex flex-col w-full gap-6 bg-background">
    {{-- headers links with numbers of subjects both total and active --}}
    <div class="flex flex-wrap items-center justify-between w-full">
      <div class="flex items-center space-x-6">
        <h1 class="text-3xl font-semibold capitalize text-primary -pb-4">scores</h1>
      </div>
    </div>
    <div class="flex items-center space-x-6">
      <form wire:submit.prevent='filter' class="flex items-center justify-start gap-2 lg:gap-4">
        {{-- <h1 class="text-sm font-medium uppercase text-dark">filter by</h1> --}}
        <div class="h-12 w-[180px] space-y-1 border border-primary rounded-lg bg-white">
          <select wire:model="sesion" class='w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 capitalize border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none' id="">
            <option value="" class="">Select Session</option>
            @foreach (\App\Models\Sesion::select(['id', 'name'])->get() as $option)
            <option class="my-2 capitalize" value="{{ $option->id }}">
              {{ $option->name }}
            </option>
            @endforeach
          </select>
          @error('sesion')
          <span class="text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>
        <div class="h-12 w-[140px] space-y-1 border border-primary rounded-lg bg-white">
          <select wire:model="term" class='w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 capitalize border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none' id="">
            <option class="py-2 capitalize" value="{{ null }}">
              Select Term
            </option>
            @forelse (\App\Models\Term::where('sesion_id', $sesion)->get() as $option)
            <option class="py-2 capitalize" value="{{ $option->id }}">
              {{ $option->name . ' ' . 'Term' }}
            </option>
            @empty
            <option class="py-2 capitalize" value="{{ null }}">
              No term found
            </option>
            @endforelse
          </select>
          @error('term')
          <span class="text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>
        <button class="px-8 font-normal border-2 btn submit-secondary max-w-max whitespace-nowrap">Check
          Score</button>
      </form>
    </div>

    {{-- list of subject and class the teachers take --}}
  </header>
  <div class="flex w-full items-center p-4 space-x-4 overflow-x-auto bg-white rounded-lg shadow" x-data="{ active: @entangle('activeClass') }">
    @forelse (\App\Models\Timetable::with(['subject', 'clas'])->where('user_id', currentUser()->id)->get() as $item)
    @php $added = $item->subject_id + $item->clas_id @endphp
    @if(in_array($added, $list))
    @continue
    @else
    @php array_push($list, $added) @endphp
    @endif
    <button x-data="{ show: false }" class="relative px-6 py-2 text-sm uppercase border rounded-lg tt btn btn-primary-outline min-w-max border-primary" :class="active === {{ $item->id }} ? 'bg-primary text-white ' : 'bg-white text-primary'" @click="$wire.selectClass({{ $item->subject->id }}, {{ $item->clas->id }}, {{ $item->id }})">
      <span class="">{{ $item->subject->name . ' - ' . $item->clas->name . $item->clas->section }}</span>
    </button>
    @empty
    <p class="font-medium">No class registered yet</p>
    @endforelse
  </div>
  <div class="w-full">
    @if ($currentClass)
    <h1 class="text-xl font-semibold text-center uppercase">
      {{ $currentClass->clas->name . $currentClass->clas->section }} {{ $currentClass->subject->name }}
      Scoresheet for <span class="uppercase">{{ currentTerm() }}</span>
    </h1>
    @endif
  </div>

  @if (count($checked))
  <div>
    <button wire:click="confirmSubmit()" class="text-white bg-primary submit">Submit Scores</button>
  </div>
  @endif

  {{-- tables --}}
  <div class="w-full px-4 pb-4 mx-auto overflow-x-auto bg-white rounded-lg shadow-sm max-w-7xl ">

    <table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
      <thead class="w-full pb-4 border-b border-gray-500">
        <tr class="z-10 text-sm text-center text-gray-500 uppercase border-b border-gray-500">
          {{-- <th class="pl-2 text-left">
                        <input type="checkbox" wire:model="selectPage"
                            class="text-teal-600 rounded text-emerald-600 focus:outline-none focus:ring-primary">
                    </th> --}}
          <td></td>
          <th class="text-left">Student Name ({{ count($checked) }})</th>
          <th>ca1 <br> (10%)</th>
          <th>ca2 <br> (10%)</th>
          <th>pm <br> (20%)</th>
          <th>bm <br> (20%)</th>
          <th>em <br> (40%)</th>
          <th>total <br> (100%)</th>
          <th>grd</th>
          <th>pos</th>
          <th>out of</th>
          <th class="text-left">comment</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="w-full break-normal">
        @forelse ($scores as $score)
        <tr class="border-b border-primary">
          <td class="p-2">
            @if (!$score->submitted)
            <input type="checkbox" wire:model="checked" id="" value="{{ $score->id }}" class="rounded text-primary focus:outline-none focus:ring-primary">
            @else
            <span class="text-green-500"><i class="bi bi-calendar2-check"></i></span>
            @endif

          </td>
          <td class="p-1">
            {{ $score->student->first_name . ' ' . $score->student->last_name }} <br>
            <span class="text-xs font-medium text-gray-500">{{ $score->student->admission_id }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="px-2 py-1 border border-black w-200px">
              {{ number_format($score->ca1, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="px-2 py-1 border border-black w-200px">
              {{ number_format($score->ca2, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="px-2 py-1 border border-black w-200px">
              {{ number_format($score->pm, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="px-2 py-1 border border-black w-200px">
              {{ number_format($score->bm, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="px-2 py-1 border border-black w-200px">
              {{ number_format($score->em, 2) }}</span>
          </td>
          <td class="p-1 text-center">
            <span class="{{ grdColor(grd($score->total)) }} px-2 font-medium py-1 border border-black w-200px">
              {{ number_format($score->total, 2) }}</span>
          </td>
          <td class="text-center">
            <b class="px-2 py-1 border border-black w-200px {{ grdColor(grd($score->total)) }}">{{ grd($score->total) }}</b>
          </td>
          <td class="text-center"> <span class="{{ $loop->last ? 'bg-red-600 text-white' : 'border' }} px-2 py-1  border-black w-200px {{ $loop->iteration == 1 ? 'bg-green-600 text-white' : 'border' }}">{{ $loop->iteration }}</span>
          </td>
          <td class="text-center"> <span class="px-2 py-1 border border-black w-200px">{{ $scores->count() }}</span>
          </td>
          <td class="text-sm uppercase"> <span class="px-2 py-1 font-medium border border-black w-200px">{{ $score->total > 0 ? comment($score->total) : '' }}</span>
          </td>


          <td class="text-center">
            @if (!$score->submitted)
            <span wire:click="editScore({{ $score->id }})" class="inline-block p-1 text-blue-600 border border-blue-600 rounded-full cursor-pointer hover:bg-blue-600 hover:text-white">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
              </svg>
            </span>
            @else
            <span class="inline-block text-green-500 cursor-not-allowed">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z" />
              </svg>
            </span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td>Click on the subject to show the score of students</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
