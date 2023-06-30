<li class="p-0">
  <a href="/home"
    class="{{ request()->is('home') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-ui-checks-grid"></i>
    </span>
    {{-- <span class="transition transform -rotate-180 icon">
            <i class="text-2xl bi bi-ui-checks-grid"></i>
          </span> --}}
    <span class="text" :class="sidebar ? '' : 'hidden'">dashboard</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('profile', currentUser()->id) }}"
    class="{{ request()->is('profile/*') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-person-check"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">profile</span>
  </a>
</li>

{{-- admin panel --}}
@if (in_array(currentUserFirstRole(), ['superadministrator', 'admin']))
<li class="p-0">
  <a href="{{ route('staff') }}"
    class="{{ request()->is('school/users*') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-people"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">users</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('gate') }}"
    class="{{ request()->is('admin/roles') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-shield-lock"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Gates</span>
  </a>
</li>
{{-- <li class="{{ request()->is('academics/*') ? 'active-parent' : '' }} p-0" :class="sidebar ? 'border-primary' : ''"
x-data="{ dropdown: false }">
<a href="#" @click="dropdown = !dropdown"
  class="{{ request()->is('academics/*') ? 'active-parent' : '' }} mx-auto flex w-full items-center justify-between space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
  :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
  <p class="relative flex items-center space-x-3 2xl:space-x-4">
    <span class="">
      <i class="text-2xl bi bi-mortarboard"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Academics</span>
  </p>
  <span class="tt" :class="sidebar ? '' : 'hidden'">
    <svg :class="dropdown ? 'rotate-180' : ''" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
    </svg>
  </span>
</a>
<ul class="flex flex-col p-0 -space-y-2" :class="sidebar ? 'border-primary' : 'hidden'" x-show="dropdown">
  <li class="p-0">
    <a href="{{ route('session') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
      class="{{ request()->is('academics/session') ? 'active-children' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4">
      <span class="text-sm" :class="sidebar ? '' : 'hidden'">Session</span>
    </a>
  </li>
  <li class="p-0">
    <a href="{{ route('department') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
      class="{{ request()->is('academics/department') ? 'active-children' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4">
      <span class="text-sm" :class="sidebar ? '' : 'hidden'">Department</span>
    </a>
  </li>
  <li class="p-0">
    <a href="{{ route('classes') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
      class="{{ request()->is('academics/classes') ? 'active-children' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4">
      <span class="text-sm" :class="sidebar ? '' : 'hidden'">Classes</span>
    </a>
  </li>
  <li class="p-0">
    <a href="{{ route('subjects') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
      class="{{ request()->is('academics/subjects') ? 'active-children' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4">
      <span class="text-sm" :class="sidebar ? '' : 'hidden'">Subject</span>
    </a>
  </li>
  <li class="p-0">
    <a href="{{ route('timetable') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
      class="{{ request()->is('academics/timetables') ? 'active-children' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4">
      <span class="text-sm" :class="sidebar ? '' : 'hidden'">Timetables</span>
    </a>
  </li>
</ul>
</li> --}}

{{-- academics in separate links  --}}
<li class="p-0">
  <a href="{{ route('session') }}"
    class="{{ request()->is('academics/session') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-calendar-range"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Session</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('department') }}"
    class="{{ request()->is('academics/department') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-building"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Department</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('classes') }}"
    class="{{ request()->is('academics/classes') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-easel"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Class</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('subjects') }}"
    class="{{ request()->is('academics/subjects') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-journal-album"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">subjects</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('timetable') }}"
    class="{{ request()->is('academics/timetables') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-alarm"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">timetable</span>
  </a>
</li>
@endif
@if (in_array(currentUserFirstRole(), ['superadministrator', 'admin', 'exam officer']))
<li class="p-0">
  <a href="{{ route('broadsheet') }}"
    class="{{ request()->is('broadsheet') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-check2-circle"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Broadsheet</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('sendresult') }}"
    class="{{ request()->is('sendresult') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-journal-text"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Send Result</span>
  </a>
</li>
@endif
@if (in_array(currentUserFirstRole(), ['teacher']))
<li class="p-0">
  <a href="{{ route('scores') }}"
    class="{{ request()->is('school/scores') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-check2-circle"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Scores</span>
  </a>
</li>
@endif

@if (teachersClass())
<li class="p-0">
  <a href="{{ route('teachers.class', teachersClass()->id) }}"
    class="{{ request()->is('school/*/myclass') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-easel2"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">My Class</span>
  </a>
</li>
{{-- <li class="p-0">
        <a href="{{ route('class.students', teachersClass()->id) }}"
class="{{ request()->is('school/*/student') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2
hover:bg-primary-light hover:text-primary 2xl:space-x-4"
:class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
<span class="">
  <i class="text-2xl bi bi-people"></i>
</span>
<span class="text" :class="sidebar ? '' : 'hidden'">Students</span>
</a>
</li> --}}
@endif

{{-- accountant panel --}}
@if (in_array(currentUserFirstRole(), ['superadministrator', 'accountant']))
<li class="p-0">
  <a href="{{ route('fees') }}"
    class="{{ request()->is('finances/fees') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-coin"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Fees</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('payments') }}"
    class="{{ request()->is('finances/payments') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-wallet"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Payment</span>
  </a>
</li>

<li class="p-0">
  <a href="{{ route('finances') }}"
    class="{{ request()->is('finances') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-wallet2"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Finances</span>
  </a>
</li>
@endif

@if (in_array(currentUserFirstRole(), ['hos', 'admin', 'superadministrator']))
{{-- <li class="p-0">
  <a href="{{ route('messages', [currentUser()->email]) }}" class="{{ request()->is('messages/*') ? 'active' : '' }}
mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4" :class="sidebar
? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
<span class="">
  <i class="text-2xl bi bi-envelope-check"></i>
</span>
<span class="text" :class="sidebar ? '' : 'hidden'">message</span>
</a>
</li>
later --}}
{{-- <li class="p-0">
		<a href="{{ route('leave.action') }}"
class="{{ request()->is('leave-action') ? 'active' : '' }} mx-auto flex w-full items-center justify-between py-2
hover:bg-primary-light hover:text-primary"
:class="sidebar ? 'pl-6 border-primary pr-4' : 'px-3 rounded-lg max-w-min border-none'">
<p class="relative flex items-center space-x-3 2xl:space-x-4">
  <span class="">
    <i class="text-2xl bi bi-clock-history"></i>

  </span>

  <span class="text" :class="sidebar ? '' : 'hidden'">Leaves Request</span>
</p>
<p :class="sidebar ? '' : 'hidden'"
  class="flex flex-col justify-around text-sm text-white align-middle rounded-full align-end aspect-square bg-secondary">
  <span class="block px-2">{{ leave() }}</span>
</p>
</a>
</li> --}}
@endif

{{-- not for student, parent and founder --}}
@if (currentUserFirstRole() != 'founder' &&
currentUserFirstRole() != 'student' &&
currentUserFirstRole() != 'parent' &&
currentUserFirstRole() != 'president')
<li class="p-0">
  <a href="{{ route('documents') }}"
    class="{{ request()->is('documents') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
        </path>
      </svg>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Documents</span>
  </a>
</li>
@endif

{{-- hos and department alone panel --}}
@if (in_array(currentUserFirstRole(), ['hod', 'hos']))
@if (currentUserFirstRole() == 'hos')
<li class="p-0">
  <a href="{{ route('session') }}"
    class="{{ request()->is('academics/session') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-clock-history"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Session</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('department') }}"
    class="{{ request()->is('academics/department') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-house-door"></i>
    </span>
    <span class="capitalize text" :class="sidebar ? '' : 'hidden'">department</span>
  </a>
</li>
@endif
<li class="p-0">
  <a href="{{ route('classes') }}"
    class="{{ request()->is('academics/classes') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-window-plus"></i>
    </span>
    <span class="capitalize text" :class="sidebar ? '' : 'hidden'">classes</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('timetable') }}"
    class="{{ request()->is('academics/timetables') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-stopwatch"></i>
    </span>
    <span class="capitalize text" :class="sidebar ? '' : 'hidden'">timetable</span>
  </a>
</li>
<li class="p-0">
  <a href="{{ route('subjects') }}"
    class="{{ request()->is('academics/subjects') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-book"></i>
    </span>
    <span class="capitalize text" :class="sidebar ? '' : 'hidden'">subjects</span>
  </a>
</li>
@endif
@if (in_array(currentUserFirstRole(), ['nurse', 'teacher', 'accountant', 'class teacher']))
<li class="p-0">
  <a href="{{ route('leave') }}"
    class="{{ request()->is('leave') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-speedometer2"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Leave</span>
  </a>
</li>
@endif

{{-- coming soon --}}
<li class="p-0">
  {{-- <a href="{{ route('chats') }}"
  class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center
  {{ request()->is('chats') ? 'active' : '' }} space-x-3 2xl:space-x-4"
  :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
  <span class="">
    <i class="text-2xl bi bi-chat-left"></i>
  </span>
  <span class="text" :class="sidebar ? '' : 'hidden'">chat</span>
  </a>
</li>
<li class="p-0">
  <a href=""
    class="{{ request()->is('/attendance') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-calendar2-check"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Attendance</span>
  </a>
</li>
--}}
@php
$user = currentUser();
@endphp
@if ($user->hasRole('exam officer'))
<li class="p-0">
  <a href="{{ route('checkresult') }}"
    class="{{ request()->is('checkresult') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-gear"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Check Report Card</span>
  </a>
</li>
@endif
@if (currentUserFirstRole() == 'superadministrator')
<li class="p-0">
  <a href="/settings"
    class="{{ request()->is('/settings') ? 'active' : '' }} mx-auto flex w-full items-center space-x-3 py-2 hover:bg-primary-light hover:text-primary 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-gear"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Settings</span>
  </a>
</li>
@endif