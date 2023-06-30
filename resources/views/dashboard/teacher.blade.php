<div class="mx-auto flex w-full flex-col gap-6 px-4 py-8 lg:px-6 lg:py-6 2xl:w-[1280px] 2xl:gap-8">
    <h1 class="text-3xl font-semibold text-dark"><span class="capitalize">{{ greeting() }},</span>
        <span>{{ currentUser()->first_name }}</span>
    </h1>
    <div class="grid w-full grid-cols-1 gap-8 md:col-span-3 md:grid-cols-3 lg:col-span-5 lg:gap-12">
        <div class="flex w-full flex-col justify-between rounded-lg bg-white p-4 shadow-sm">
            <div class="flex w-full justify-between">
                <p class="text-lg font-medium text-dark">Total Students</p>
                <span class="rounded-full bg-primary-light p-2">
                    <span class="block p-2 text-dark">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </span>
                </span>
            </div>
            <p class="text-5xl font-semibold">{{ currentUser()->timetables ? getTotalStudentsByClass() : 0 }}</p>
        </div>
        <div class="flex w-full flex-col justify-between rounded-lg bg-white p-4 shadow-sm">
            <div class="flex w-full justify-between">
                <p class="text-lg font-medium text-dark">Active Classes</p>
                <span class="rounded-full bg-rose-100 p-2">
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
            <p class="text-5xl font-semibold">{{ getClassFromTimetable()->count() }}</p>
        </div>
        <div class="flex w-full flex-col justify-between rounded-lg bg-white p-4 shadow-sm">
            <div class="flex w-full justify-between">
                <p class="text-lg font-medium text-dark">Total Subject</p>
                <span class="rounded-full bg-blue-100 p-2">
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
                {!! getTeacherSubjectFromTimetable()->count() !!}
            </p>
        </div>
    </div>
    <div class="relative overflow-y-auto rounded-lg bg-white p-4 shadow">
        @php
            $students = activeClassStudents(teachersClass() ? teachersClass()->id : '');
        @endphp
        @if ($students->count() > 0)
            <div class="absolute left-0 top-2 z-20 flex w-full items-center justify-between p-2 backdrop-blur-sm">
                <h1 class="pl-4 text-lg font-medium text-dark">Students</h1>
                @if (teachersClass())
                    <a href="{{ route('class.students', teachersClass()->id) }}"
                        class="tt pr-2 text-sm font-semibold text-secondary hover:text-primary">View All</a>
                @endif

            </div>
            <div class="flex max-h-[300px] flex-col space-y-2 overflow-y-auto pt-10">

                {{-- tables --}}
                <div class="w-full overflow-x-auto rounded-lg bg-white px-4 pb-4 shadow-sm">
                    <table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
                        <thead class="w-full border-b pb-4 text-xl">
                            <tr class="font-medium">
                                <th class="p-2"></th>
                                <th class="p-2 text-left text-xl font-medium">Name</th>
                                <th class="p-2 text-left text-xl font-medium">Admission NO</th>
                                <th class="p-2 text-left text-xl font-medium">Class</th>
                                <th class="p-2 text-left text-xl font-medium">Gender</th>
                                <th class="p-2"></th>
                            </tr>
                        </thead>
                        <tbody class="w-full overflow-x-auto break-normal">
                            @forelse ($students as $student)
                                <tr class="border-y-8 border-white bg-primary-light">

                                    <td class="">
                                        <span class="flex items-center space-x-3">
                                            <img src="{{ $student->getFirstMediaUrl('student') }}"
                                                alt="{{ $student->first_name . ' ' . $student->last_name }}"
                                                class="block aspect-square h-14 w-14 rounded-full object-cover p-1">
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap p-2">
                                        <p class="capitalize">{{ $student->first_name . ' ' . $student->last_name }}</p>
                                        <x-admitted>
                                            {{ $student->created_at->format('d M, Y') }}
                                        </x-admitted>
                                    </td>
                                    <td class="whitespace-nowrap p-2">
                                        {{ $student->admission_id ?? $student->student_id }}
                                    </td>
                                    <td class="whitespace-nowrap uppercase p-2">
                                        {{ $student->clas->name . ($student->clas->high ?? $student->clas->section) }}
                                    </td>
                                    <td class="p-2 capitalize">
                                        {{ $student->gender }}
                                        {{-- {{ $student->dob->diffInYears() > 0 ? $student->dob->diffInYears() . ' year(s)' : '< 1year' }} --}}
                                    </td>

                                    {{-- <td class="">
                                        <div
                                            class="item-center flex items-center justify-end space-x-6 whitespace-nowrap p-2">
                                            <a href="/"
                                                class="btn-primary-outline tt inline-block cursor-pointer rounded border border-primary px-6 py-1 align-middle">
                                                Input result
                                            </a>
                                            <a href=""
                                                class="btn-primary tt inline-block cursor-pointer rounded p-1 px-6 align-middle">
                                                view
                                            </a>
                                        </div>
                                    </td> --}}
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
                    <p class="max-w-xl text-center">Once you are assign to a class, and the class has students. The list
                        of students
                        will be shown here.
                    </p>
                </x-empty-table>

            </div>
        @endif
    </div>
    {{-- timetables --}}
    <div class="{{ currentUser()->timetables->count() > 0 ? '' : 'bg-white' }} space-y-4 rounded-lg p-6 pt-6">
        <h1 class="text-center text-3xl font-semibold capitalize">My Timetable</h1>
        @if (currentUser()->classes && currentUser()->timetables->count() > 0)
            @include('components.teacher-timetable')
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
