<div class="mx-auto flex w-full flex-col gap-6 px-4 py-8 lg:px-6 lg:py-6 2xl:w-[1280px] 2xl:gap-8">
    <h1 class="text-3xl font-semibold text-dark"><span class="capitalize">{{ greeting() }},</span>
        <span>{{ currentUser()->first_name }}</span>
    </h1>
    <div class="grid w-full grid-cols-1 gap-8 md:grid-cols-4 lg:grid-cols-6 lg:gap-12">
        <div class="grid p-6 m-0 rounded-lg shadow-sm text-whitelg:col-span-3 bg-primary">
            <h1 class="text-2xl font-medium text-white uppercase">
                @if (teachersClass() != null)
                    {{ teachersClass()->name . teachersClass()->section }}
                    <br>
                    <span class="text-sm">{{ teachersClass()->school->name }}</span>
                @else
                    <span class="text-xl">No class assign yet</span>
                @endif
            </h1>
        </div>
        <div class="grid w-full grid-cols-1 gap-8 md:col-span-3 md:grid-cols-3 lg:col-span-5 lg:gap-12">
            <div class="flex flex-col justify-between w-full p-4 bg-white rounded-lg shadow-sm">
                <div class="flex justify-between w-full">
                    <p class="text-lg font-medium text-dark">Total Students</p>
                    <span class="p-2 rounded-full bg-primary-light">
                        <span class="block p-2 text-dark">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </span>
                    </span>
                </div>
                <p class="text-5xl font-semibold">{{ teachersClass() ? teachersClass()->students->count() : 0 }}</p>
            </div>
            <div class="flex flex-col justify-between w-full p-4 bg-white rounded-lg shadow-sm">
                <div class="flex justify-between w-full">
                    <p class="text-lg font-medium text-dark">Active Students</p>
                    <span class="p-2 rounded-full bg-rose-100">
                        <span class="block p-2 text-secondary">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </span>
                    </span>
                </div>
                <p class="text-5xl font-semibold">
                    {{ teachersClass() ? activeClassStudents(teachersClass()->id)->count() : 0 }}</p>
            </div>
            <div class="flex flex-col justify-between w-full p-4 bg-white rounded-lg shadow-sm">
                <div class="flex justify-between w-full">
                    <p class="text-lg font-medium text-dark">Class Subject</p>
                    <span class="p-2 bg-blue-100 rounded-full">
                        <span class="block p-2 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-journal-album" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 4a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5h-5zm1 7a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3z" />
                                <path
                                    d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                <path
                                    d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                            </svg>
                        </span>
                    </span>
                </div>
                <p class="text-5xl font-semibold">
                    {{ teachersClass() ? getClassSubjectFromTimetable(teachersClass()->id)->count() : 'No subject assigned' }}
                </p>
            </div>
        </div>
    </div>
    @if (currentUser()->classes())
        <div class="relative p-4 overflow-y-auto bg-white rounded-lg shadow">
            <div class="absolute left-0 z-20 flex items-center justify-between w-full p-2 top-2 backdrop-blur-sm">
                <h1 class="pl-4 text-lg font-medium text-dark">Students</h1>
                <a href="{{ route('class.students', teachersClass() ? teachersClass()->id : '') }}"
                    class="pr-2 text-sm font-semibold tt text-secondary hover:text-primary">View All</a>
            </div>
            <div class="flex max-h-[300px] flex-col space-y-2 overflow-y-auto pt-10">
                @php
                    $students = activeClassStudents(teachersClass() ? teachersClass()->id : '');
                @endphp
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
                                                <img src="{{ $student->getFirstMediaUrl('student') }}"
                                                    alt="{{ $student->first_name . ' ' . $student->last_name }}"
                                                    class="block object-cover p-1 rounded-full aspect-square h-14 w-14">
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
                                            <div
                                                class="flex items-center justify-end p-2 space-x-6 item-center whitespace-nowrap">
                                                @if (\App\Models\Score::where('term_id', latestTerm()->id)->where('student_id', $student->id)->count())
                                                    <a href="{{ route('card', [$student->id]) }}"
                                                        class="inline-block px-6 py-1 align-middle border rounded cursor-pointer btn-primary-outline tt border-primary">
                                                        view score
                                                    </a>
                                                @else
                                                    <span
                                                        class="inline-block px-6 py-1 align-middle bg-white border rounded">
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
                    <x-empty-table
                        comment="There is no student register yet, you can add student by first creating the guardian/parent account and then use the parent email/id to register student into the system "
                        title="student">
                        <p class="max-w-xl text-center">Once you are assign to a class, and the class has students. The
                            list
                            of students
                            will be shown here.
                        </p>
                    </x-empty-table>
                @endif
            </div>
        </div>
    @endif

    {{-- timetables --}}
    <div class="{{ currentUser()->classes ? '' : 'bg-white' }} space-y-4 rounded-lg pt-6">
        <h1 class="text-3xl font-semibold text-center capitalize">Class Timetable</h1>
        @if (currentUser()->classes && currentUser()->timetables->count() > 0)
            <x-class-timetable :id="currentUser()->classes[0]->id" />
        @else
            <x-empty-table comment="There is no outstanding payment to pay. The list of all fees will display here"
                title="Timetable">
                <p class="max-w-md text-center">It looks like you are not assigned to any class or there is no timetable
                    assign to
                    your class yet. You can report this to the
                    school admin
                </p>
            </x-empty-table>
        @endif
    </div>
</div>
