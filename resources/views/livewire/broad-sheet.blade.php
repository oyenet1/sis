<div class="grid w-full gap-6 py-8 lg:py-12 max-w-7xl mx-auto" x-data="{ show: false }">
    {{-- fixed header --}}
    <header class="flex flex-col w-full gap-6 bg-background">
        <div class="flex items-center space-x-6">
            <form wire:submit.prevent='generateScoresheet' class="flex items-center justify-start gap-2 lg:gap-4">
                {{-- <h1 class="text-sm font-medium uppercase text-dark">filter by</h1> --}}
                <div class="h-10 w-[180px] space-y-1 border border-primary rounded-lg bg-white">
                    <select wire:model.defer="clas_id"
                        class='w-full h-full pl-4 space-y-2 uppercase text-sm font-medium text-gray-500 placeholder-gray-500 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none'
                        id="">
                        <option value="" class="">Select Class</option>
                        @foreach (\App\Models\Clas::select(['id', 'name', 'section'])->get() as $option)
                            <option class="my-2 uppercase" value="{{ $option->id }}">
                                {{ $option->name . $option->section }}
                            </option>
                        @endforeach
                    </select>
                    @error('clas_id')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="h-10 w-[140px] space-y-1 border border-primary rounded-lg bg-white">
                    <select wire:model.defer="subject_id"
                        class='w-full h-full pl-4 space-y-2 uppercase text-sm font-medium text-gray-500 placeholder-gray-500 capitalize border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none'
                        id="">
                        <option class="py-2 capitalize" value="{{ null }}">
                            Select Subject
                        </option>
                        @forelse (\App\Models\Subject::all() as $subject)
                            <option class="py-2 capitalize" value="{{ $subject->id }}">
                                {{ $subject->name }}
                            </option>
                        @empty
                            <option class="py-2 capitalize" value="{{ null }}">
                                No subject found
                            </option>
                        @endforelse
                    </select>
                    @error('subject_id')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <button
                    class="px-8 font-normal text-sm border-2 btn py-[6px] submit-secondary max-w-max whitespace-nowrap">Generate
                    Scoresheet</button>
            </form>
        </div>
    </header>

    {{-- tables --}}
    <div class="w-full px-4 py-8 mx-auto overflow-x-auto bg-white rounded-lg shadow-sm max-w-7xl my-8 min-h-[600px]">
        <iframe src="/scoresheet/{{ $clas_id }}/{{ $subject_id }}" frameborder="0"
            class="w-full my-auto min-h-full"></iframe>
    </div>
</div>
