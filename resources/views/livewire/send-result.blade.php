 {{-- loading state --}}
 {{-- <div wire:loading wire:target='send' style="height: 100vh; width: 100vw!important; z-index:999999" class="fixed h-screen flex justify-center items-center">
   <div class="p-8 flex flex-col space-y-4">
    <span class="block"><img src="/img/spin-white.svg" alt="" class="w-20 h-20"></span>
    <p class="text-2xl">Email sending ....</p>
   </div>
 </div> --}}
 <div class="w-full">
   {{-- alert notification --}}
   @if (session('success'))
   <x-alert type="success" :message="session('success')">
     <i class="text-3xl bi bi-check2-circle"></i>
   </x-alert>
   @elseif (session('error'))
   <x-alert type="error" :message="session('error')">
     <i class="text-3xl bi bi-exclamation-triangle"></i>
   </x-alert>
   @else
   @endif
   <h1 class="text-2xl font-semibold py-4">Send Result</h1>
   <div class="w-full px-4 pb-4 space-y-4 overflow-x-auto bg-white rounded-lg shadow-sm">
     @php
     $clas = \App\Models\Clas::withCount('students')->get();
     @endphp
     @if ($clas->count() > 0)
     <table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
       <thead class="w-full pb-4 text-xl border-b">
         <tr class="z-10">
           <td>No</td>
           <th class="items-center p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
             <span class="">class</span>

           </th>
           <th class=" p-2 text-center transition duration-300 transform cursor-pointer hover:text-primary">
             <span class="">Student</span>
           </th>
           {{-- <th>Status</th> --}}
           <th>Action</th>
         </tr>
       </thead>
       <tbody class="w-full overflow-x-auto break-normal bg-white">
         @forelse ($clas as $clas)
         <tr class="capitalize bg-white border-y">
           <td>{{ $loop->iteration }}</td>
           <td class="p-2 uppercase">
             <p class="">{{ $clas->name . $clas->section}}</p>
           </td>

           <td class="p-2 capitalize text-center">
             {{ $clas->students_count }}
           </td>
           {{-- <td class="p-2 capitalize">

           </td> --}}

           <td class="p-1 text-center">
             <button wire:click="send({{ $clas->id }})" class="relative px-4 py-2 text-sm font-normal capitalize rounded-lg btn btn-primary">
               Send Result
             </button>
           </td>
         </tr>

         @empty
         <h1 class="text-2xl font-bold">No records found in the database</h1>
         @endforelse
       </tbody>
     </table>
     @else
     <x-empty-table comment="There is no class created yet" title="Class">
       <p class="max-w-xs text-center">There is no class created yet
       </p>
     </x-empty-table>
     @endif
   </div>
 </div>
