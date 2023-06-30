<div class="mx-auto flex w-full flex-col gap-6 px-4 py-8 lg:px-6 lg:py-6 2xl:w-[1280px] 2xl:gap-8">
  <h1 class="text-3xl font-semibold text-dark"><span class="capitalize">{{ greeting() }},</span>
    <span>{{ currentUser()->first_name }}</span>
  </h1>

  <div class="grid w-full grid-cols-1 gap-2 md:grid-cols-4 lg:grid-cols-5 2xl:gap-8  bg-white shadow overflow-hidden rounded-lg ">
    <div class="w-full p-4 m-0 space-y-3 rounded-lg text-white shadow-sm text-whitelg:col-span-3 bg-primary">
      <h1 class="text-lg text-white capitalize">
        Total Users
      </h1>
      <p class="text-xl lg:text-2xl font-medium 2xl:text-3xl">{{ \App\Models\User::count() }}</p>
      <p class="text-xs xl:text-sm space-x-2"><span class="p-1 py-[2px] rounded-lg bg-gray-300">+{{ random_int(1,4) }} </span> <span class="text-xs xl:text-sm"> last 30days</span></p>
    </div>

    <div class=" w-full flex justify-around md:col-span-3 lg:col-span-4">
      <div class="flex flex-col justify-between w-[33%] md:w-full p-4 lg:pl-16 xl:pl-20 space-y-4 bg-white">
        <div class="flex space-y-1 justify-between flex-col w-full">
          <span class="inline-block p-2 text-primary bg-green-100 rounded-full max-w-min">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
              </path>
            </svg>
          </span>
          <h1 class="text-xl font-medium pl-[10px]">{{ \App\Models\Student::count() }}</h1>
          <p class="text  text-dark">Total students</p>
        </div>
        <p class="text-xs xl:text-sm space-x-2"><span class="p-1 py-[2px] rounded-lg bg-gray-300">+{{ random_int(1,4) }} </span> <span class="text-xs xl:text-sm"> last 30days</span></p>
      </div>
      <div class="flex flex-col justify-between w-[33%] md:w-full p-4 border-x-2 lg:pl-16 xl:pl-20 space-y-4 bg-white">
        <div class="flex space-y-1 justify-between flex-col w-full">
          <span class="inline-block p-2 text-secondary bg-red-100 rounded-full max-w-min">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
              </path>
            </svg>
          </span>
          <h1 class="text-xl font-medium pl-[10px]">{{ \App\Models\User::rolesCount([2,3,4,5,6,8,10,12,13]) }}</h1>
          <p class="text  text-dark">Staffs</p>
        </div>
        <p class="text-xs xl:text-sm space-x-2"><span class="p-1 py-[2px] rounded-lg bg-gray-300">+{{ random_int(1,4) }} </span> <span class="text-xs xl:text-sm"> last 30days</span></p>
      </div>
      <div class="flex flex-col justify-between w-[33%] md:w-full p-4 lg:pl-16 xl:pl-20 space-y-4 bg-white">
        <div class="flex space-y-1 justify-between flex-col w-full">
          <span class="inline-block p-2 text-blue-600 bg-blue-100 rounded-full max-w-min">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-journal-album" viewBox="0 0 16 16">
              <path d="M5.5 4a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5h-5zm1 7a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3z" />
              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
            </svg>
          </span>
          <h1 class="text-xl font-medium pl-[10px]">{{ \App\Models\Clas::count() }}</h1>
          <p class="text  text-dark">Classes</p>
        </div>
        <p class="text-xs xl:text-sm space-x-2"><span class="p-1 py-[2px] rounded-lg bg-gray-300">+{{ random_int(1,4) }} </span> <span class="text-xs xl:text-sm"> last 30days</span></p>
      </div>
    </div>
  </div>

  <div class="flex items-center p-4 space-x-4 overflow-x-auto bg-white rounded-lg shadow" x-data="{ active: @entangle('activeClass') }">
    @forelse (\App\Models\Clas::all() as $item)
    <button x-data="{ show: false }" class="relative px-6 py-2 text-sm uppercase border rounded-lg tt btn btn-primary-outline min-w-max border-primary" :class="active === {{ $item->id }} ? 'bg-primary text-white ' : 'bg-white text-primary'" @click="$wire.selectClass({{ $item->id }})">
      <span class="">{{ $item->name . $item->section }}</span>
    </button>
    @empty
    <p class="font-medium">No class registered yet</p>
    @endforelse
  </div>

  <div class="relative p-4 overflow-y-auto bg-white rounded-lg shadow">
    <div class="absolute left-0 z-20 flex items-center justify-between w-full p-2 top-2 backdrop-blur-sm">
      <h1 class="pl-4 text-lg font-medium text-dark">Students</h1>
      @if($students->count())
      <a href="{{ route('students')}}" class="pr-2 text-sm font-semibold tt text-secondary hover:text-primary">View All</a>
      @endif
    </div>
    <div class="flex max-h-[800px] flex-col space-y-2 overflow-y-auto pt-10">
      @if ($students->count() > 0)
      {{-- tables --}}
      <div class="w-full px-4 pb-4 overflow-x-auto bg-white rounded-lg shadow-sm">
        <table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
          <thead class="w-full pb-4 text-xl border-b">
            <tr class="font-medium">
              <th class="p-2"></th>
              <th class="p-2 text-xl font-medium text-left">Name</th>
              <th class="p-2 text-xl font-medium text-left">Student ID</th>
              <th class="p-2 text-xl font-medium text-left">Age</th>
              <th class="p-2 text-xl font-medium text-left">Gender</th>
              <th class="p-2"></th>
            </tr>
          </thead>
          <tbody class="w-full overflow-x-auto break-normal">
            @forelse ($students as $student)
            <tr class="border-white border-y-8 bg-primary-light">

              <td class="">
                <span class="flex items-center space-x-3">
                  <img src="{{ $student->getFirstMediaUrl('student') }}" alt="{{ $student->first_name . ' ' . $student->last_name }}" class="block object-cover p-1 rounded-full aspect-square h-14 w-14">
                </span>
              </td>
              <td class="p-2 whitespace-nowrap">
                <p class="capitalize">
                  {{ $student->first_name . ' ' . $student->last_name }}
                </p>
                <x-admitted>
                  {{ $student->created_at->format('d M, Y') }}
                </x-admitted>
              </td>
              <td class="p-2 whitespace-nowrap">
                {{ $student->admission_id ?? $student->student_id }}
              </td>
              <td class="p-2 capitalize">
                {{ $student->dob->diffInYears() > 0 ? $student->dob->diffInYears() . ' year(s)' : '< 1year' }}
              </td>
              <td class="p-2 capitalize whitespace-nowrap">
                {{ $student->gender }}
              </td>

              <td class="">
                <div class="flex items-center justify-end p-2 space-x-6 item-center whitespace-nowrap">
                  @if (\App\Models\Score::where('term_id', latestTerm()->id)->where('student_id', $student->id)->count())
                  <a title="click to add comment" href="{{ route('hos.comment', [$student->id]) }}" class="inline-block px-6 text-sm py-1 align-middle border rounded cursor-pointer btn-primary-outline tt border-primary">
                    Comment on scores
                  </a>
                  @else
                  <span title="You will be able to add comment to student scores when the script is marked" class="inline-block px-6 py-1 align-middle bg-white border rounded text-gray-500 cursor-not-allowed">
                    No score yet
                  </span>
                  @endif

                </div>
              </td>
            </tr>
            @empty
            <h1 class="text-2xl font-bold">No records found in the database</h1>
            @endforelse
          </tbody>
        </table>
      </div>
      @else
      <x-empty-table comment="There is no student register yet, you can add student by first creating the guardian/parent account and then use the parent email/id to register student into the system " title="student to display">
        <p class="max-w-xl text-center">Click on the class to show students above to show students
        </p>
      </x-empty-table>
      @endif
    </div>
  </div>

</div>
