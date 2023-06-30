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
          <h1 class="text-xl font-medium pl-[10px]">{{ \App\Models\Subject::count() }}</h1>
          <p class="text  text-dark">Subjects</p>
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

  @livewire('send-result')
</div>
