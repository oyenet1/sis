<div class="flex justify-center px-2 space-x-1 overflow-hidden capitalize bg-white rounded-lg shadow">
  <a @click="active = 'students'"
    :class="active === 'students' ? 'text-primary border-b-4 font-medium border-primary' : ''"
    href="{{ route('students') }}"
    class="px-6 rounded {{ request()->is('users/students') ? 'text-primary border-b-4 font-medium border-primary' : '' }} py-3">Students</a>
  <a @click="active = 'parents'"
    :class="active === 'parents' ? 'text-primary border-b-4 font-medium border-primary' : ''"
    href="{{ route('parents') }}" class="px-6 py-3 rounded">Parents</a>
  <a href="{{ route('staff') }}" @click="active = 'staff'"
    :class="active === 'staff' ? 'text-primary border-b-4 font-medium border-primary' : ''"
    class="px-6 py-3 rounded {{ request()->is('users/staff') ? 'text-primary border-b-4 font-medium border-primary' : '' }} ">Staff</a>
</div>
