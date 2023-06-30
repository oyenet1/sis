 <div class="flex items-center capitalize justify-center m-0 space-x-4 text-sm font-medium">
   <span class="text-center w-36 py-2 rounded-lg shadow-sm cursor-pointer"
     :class="type === 'member' ? 'bg-primary text-white' : 'text-gray-500 bg-gray-100'"
     @click="$wire.selectType('member')">members
   </span>
   <span class="text-center w-36 py-2 rounded-lg shadow-sm cursor-pointer"
     :class="type === 'visitor' ? 'bg-primary text-white' : 'text-gray-500 bg-gray-100'"
     @click="$wire.selectType('visitor')">visitors</span>
 </div>
