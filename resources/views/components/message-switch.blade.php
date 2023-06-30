<div class="flex justify-around px-2 overflow-hidden capitalize bg-white rounded-lg shadow">
  <button type="button" @click="$wire.selectType('member')"
    :class="type === 'member' ? 'text-primary border-b-4 font-medium border-primary' : ''"
    class="px-6 rounded {{ request()->is('users/students') ? 'text-primary border-b-4 font-medium border-primary' : '' }} py-3">Members</button>
  <button type="button" @click="$wire.selectType('visitor')"
    :class="type === 'visitor' ? 'text-primary border-b-4 font-medium border-primary' : ''"
    class="px-6 py-3 rounded">Visitors</button>
</div>
