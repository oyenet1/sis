@extends('layouts.dashboard')
@section('content')
    <div class="flex flex-col gap-6 px-2 py-8">
        {{-- fixed header --}}
        <header class="flex flex-col w-full gap-6 bg-background">
            {{-- headers links with numbers of staffs both total and active --}}
            <div class="flex flex-wrap items-center justify-between w-full">
                {{-- users link are here --}}
                <x-users-link />

                <div class="flex flex-col text-gray-500">
                    <p class="">Total Staff:
                        <strong class="text-black">{{ digitFormat(random_int(1000, 1200)) }}</strong>
                    </p>
                    <p class="">Active Staff:
                        <strong class="text-black">{{ digitFormat(random_int(900, 1000)) }}</strong>
                    </p>
                </div>
            </div>
        </header>

        {{-- if the active tab is staff --}}
        <template x-if="active === 'staff'">
            @livewire('staffs', ['staffs' => $staffs], key($staffs->id))
        </template>
        {{-- if the active tab is parent --}}
        <template x-if="active === 'parents'">
            @livewire('parents')
        </template>
        {{-- if the active tab is students --}}
        <template x-if="active === 'students'">
            @livewire('students')
        </template>
    </div>
@endsection
