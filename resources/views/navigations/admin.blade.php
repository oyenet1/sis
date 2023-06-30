<li class="p-0 ">
  <a href="/home"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('home') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-ui-checks-grid"></i>
    </span>
    {{-- <span class="transition transform -rotate-180 icon">
            <i class="text-2xl bi bi-ui-checks-grid"></i>
          </span> --}}
    <span class="text" :class="sidebar ? '' : 'hidden'">{{ $role }}</span>
  </a>
</li>
<li class="p-0 ">
  <a href="/profile"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('profile') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-person-check"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">profile</span>
  </a>
</li>

<li class="p-0">
  <a href="{{ route('fees') }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('finances/fees') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-coin"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Fees</span>
  </a>
</li>
<li class="p-0 ">
  <a href="{{ route('payments') }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('finances/payments') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-wallet"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Payment</span>
  </a>
</li>

<li class="p-0 ">
  <a href="{{ route('finances') }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('finances') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-wallet2"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Finances</span>
  </a>
</li>

<li class="p-0 {{ request()->is('academics/*') ? 'active-parent' : '' }}" :class="sidebar ? 'border-primary' : ''"
  x-data="{ dropdown: false }">
  <a href="#" @click="dropdown = !dropdown"
    class="flex justify-between w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('academics/*') ? 'active-parent' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <p class="relative flex items-center space-x-3 2xl:space-x-4">
      <span class="">
        <i class="text-2xl bi bi-mortarboard"></i>
      </span>
      <span class="text" :class="sidebar ? '' : 'hidden'">Academics</span>
    </p>
    <span class="tt" :class="sidebar ? '' : 'hidden'">
      <svg :class="dropdown ? 'rotate-180' : ''" class="w-6 h-6" fill="none" stroke="currentColor"
        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
      </svg>
    </span>
  </a>
  <ul class="flex flex-col p-0 -space-y-2" :class="sidebar ? 'border-primary' : 'hidden'" x-show="dropdown">
    <li class="p-0">
      <a href="{{ route('session') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
        class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('academics/session') ? 'active-children' : '' }} space-x-3 2xl:space-x-4">
        <span class="text-sm" :class="sidebar ? '' : 'hidden'">Session</span>
      </a>
    </li>
    <li class="p-0">
      <a href="{{ route('department') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
        class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('academics/department') ? 'active-children' : '' }} space-x-3 2xl:space-x-4">
        <span class="text-sm" :class="sidebar ? '' : 'hidden'">Department</span>
      </a>
    </li>
    <li class="p-0">
      <a href="{{ route('classes') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
        class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('academics/classes') ? 'active-children' : '' }} space-x-3 2xl:space-x-4">
        <span class="text-sm" :class="sidebar ? '' : 'hidden'">Classes</span>
      </a>
    </li>
    <li class="p-0">
      <a href="{{ route('subjects') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
        class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('academics/subjects') ? 'active-children' : '' }} space-x-3 2xl:space-x-4">
        <span class="text-sm" :class="sidebar ? '' : 'hidden'">Subject</span>
      </a>
    </li>
    <li class="p-0">
      <a href="{{ route('timestable') }}" :class="sidebar ? 'pl-16' : 'pl-4'"
        class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('academics/timetables') ? 'active-children' : '' }} space-x-3 2xl:space-x-4">
        <span class="text-sm" :class="sidebar ? '' : 'hidden'">Timetables</span>
      </a>
    </li>
  </ul>
</li>
<li class="p-0 ">
  <a href="{{ route('messages', [currentUser()->email]) }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('messages/*') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-envelope-check"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">message</span>
  </a>
</li>
<li class="p-0 ">
  <a href="{{ route('leave.action') }}"
    class="flex w-full py-2 mx-auto justify-between hover:bg-primary-light hover:text-primary items-center {{ request()->is('leave-action') ? 'active' : '' }} "
    :class="sidebar ? 'pl-6 border-primary pr-4' : 'px-3 rounded-lg max-w-min border-none'">
    <p class="relative flex items-center space-x-3 2xl:space-x-4">
      <span class="">
        <i class="text-2xl bi bi-clock-history"></i>

      </span>

      <span class="text" :class="sidebar ? '' : 'hidden'">Leaves Request</span>
    </p>
    <p :class="sidebar ? '' : 'hidden'"
      class="flex flex-col justify-around text-sm text-white align-middle rounded-full aspect-square align-end bg-secondary">
      <span class="block px-2">{{ leave() }}</span>
    </p>
  </a>
</li>

<li class="p-0 ">
  <a href="{{ route('staff') }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('school/users*') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-people"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">users</span>
  </a>
</li>

<li class="p-0 ">
  <a href="{{ route('leave') }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light
        hover:text-primary items-center {{ request()->is('leave') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-speedometer2"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Leave</span>
  </a>
</li>

<li class="p-0 ">
  <a href="{{ route('documents') }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('/gate') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
        </path>
      </svg>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Documents</span>
  </a>
</li>

<li class="p-0 ">
  <a href="{{ route('chats') }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('chats') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-chat-left"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">chat</span>
  </a>
</li>


<li class="p-0 ">
  <a href="{{ route('gate') }}"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('admin/roles') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-shield-lock"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Gates</span>
  </a>
</li>
<li class="p-0 ">
  <a href="/profile"
    class="flex w-full py-2 mx-auto hover:bg-primary-light hover:text-primary items-center {{ request()->is('/attendance') ? 'active' : '' }} space-x-3 2xl:space-x-4"
    :class="sidebar ? 'pl-6 border-primary' : 'px-3 rounded-lg max-w-min border-none'">
    <span class="">
      <i class="text-2xl bi bi-calendar2-check"></i>
    </span>
    <span class="text" :class="sidebar ? '' : 'hidden'">Attendance</span>
  </a>
</li>
