<div class="flex flex-col w-full gap-6 py-8 lg:py-12">
    {{-- form --}}
    {{-- modal forms and inputs components --}}
    <x-modal class="max-w-lg">
        <x-form title="term" :update="$update">
            <div class="w-full h-12 space-y-1">
                <select wire:model.defer="name"
                    class='w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 bg-gray-100 border-0 rounded-lg focus:outline-none peer focus:bg-white tt focus:border-2 focus:border-primary'
                    id="">
                    <option value="select" class="">Term*</option>
                    @foreach (['first', 'second', 'third'] as $option)
                        <option class="py-2 uppercase" value="{{ $option }}">{{ $option . ' ' . 'term' }}
                        </option>
                    @endforeach
                </select>
                @error('name')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <x-input label="Start*" class="cursor-pointer" name="start" type="date" wire:model.defer="start" />
            <x-input label="End*" class="cursor-pointer" name="end" type="date" wire:model.defer="end" />
            <x-input label="School Open days" class="cursor-pointer" name="dso" type="number"
                wire:model.defer="dso" />
        </x-form>
    </x-modal>

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


    {{-- fixed header --}}
    <header class="flex flex-col w-full gap-6 bg-background">
        {{-- headers links with numbers of sessions both total and active --}}
        <div class="flex flex-wrap items-center justify-end w-full">
            {{-- users link are here --}}


            <div class="flex flex-col text-gray-500">
                <p class="">Total Session Run:
                    <strong class="text-dark">{{ \App\Models\Sesion::all()->count() }}</strong>
                </p>
                <p class="">Current Session: <br>
                    <strong class="text-dark uppercase pl-4">{{ currentSession() }}</strong>
                </p>
            </div>
        </div>

        {{-- buttons --}}
        <div class="flex items-center justify-between ">
            <div class="flex items-center space-x-6">
                <h1 class="text-3xl font-semibold capitalize text-primary">Session</h1>
                <button class="text-sm btn btn-primary tt" wire:click="addSession()">Add session</button>
            </div>

            {{-- right side --}}
            <div class="flex items-center space-x-6">
                @if ($checked)
                    <x-button.generate-report />
                @else
                @endif
                <x-search name="session" />
            </div>
        </div>

        <div class="flex items-center py-2 space-x-4 overflow-x-auto" x-data="{ active: @entangle('activeSession') }">
            @forelse ($sessions as $index => $item)
                <button class="px-8 hover:bg-primary hover:text-white tt border border-primary py-2 rounded-lg  text-sm"
                    :class="active === {{ $item->id }} ? 'bg-primary text-white ' : 'bg-white text-primary'"
                    @click="active = {{ $item->id }}">{{ $item->name }}</button>
            @empty
                <p class="font-medium">No session yet, kindly create one by clicking the add session button</p>
            @endforelse
        </div>
    </header>

    {{-- tables --}}
    @if ($session)
        <div class="w-full pb-8 lg:pb-12 overflow-x-auto border-l-8 border-green-600 bg-white rounded-lg shadow-sm">
            <div class="bg-white w-">
                <button class="btn btn-secondary px-8 m-4 font-normal text-sm" wire:click="showForm()">Add term</button>
            </div>

            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 text-lg w-full text-left">
                        <th class="p-2 py-3 pl-4 2xl:pl-8">Term</th>
                        <th class="p-2 py-3">Start</th>
                        <th class="p-2 py-3">End</th>
                        <th>Days school Opened</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y-2">
                    @forelse ($session->terms as $term)
                        <tr class="border-t-2">
                            <td class="pl-4 2xl:pl-8 capitalize">{{ $term->name . ' ' }} term</td>
                            <td class="p-2">{{ formatDate($term->start) }}</td>
                            <td class="p-2">{{ formatDate($term->end) }}</td>
                            <td class="p-2">{{ $term->dso ?? $term->start->diffInDays($term->end) }}</td>
                            <th>
                                <span wire:click="edit({{ $term->id }})"
                                    class="w-8 h-8 p-2 text-blue-600 border inline-block border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="my-auto bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                </span>
                            </th>
                        </tr>
                    @empty
                        <p class="px-4 text-lg">No term yet, kindly add one</p>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
