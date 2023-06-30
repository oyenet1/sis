<div class="flex flex-col w-full gap-6 py-8 lg:py-12">
	{{-- form --}}
	{{-- modal forms and inputs components --}}
	<x-modal class="max-w-lg">
		<x-form title="timetable" header="create" :update="$update">
			<x-form.class-select />
			<x-form.subject-select />
			<x-form.teacher-select name="teacher" />

			<div class="grid w-full grid-cols-3 gap-4">
				<x-form.day />
				<x-input label="Start*" class="cursor-pointer" name="start" type="time" wire:model="start" />
				<x-input label="End*" class="cursor-pointer" name="end" type="time" wire:model="end" />
			</div>
		</x-form>
	</x-modal>

	{{-- alert notification --}}
	@if (session('success'))
		<x-alert type="success" :message="session('success')">
			<i class="text-3xl bi bi-check2-circle"></i>
		</x-alert>
	@endif

	{{-- fixed header and search bar --}}
	<section class="flex flex-col w-full gap-6 bg-background" x-data="{ active: 'students' }">
		{{-- buttons --}}
		<div class="flex items-center justify-between">
			<div class="flex items-center space-x-6">
				<h1 class="text-3xl font-semibold capitalize text-primary">Timetable</h1>
				<x-button.add precede='create' name="timetable" />
			</div>

			{{-- right side --}}
			<div class="flex items-center space-x-6">
				<form wire:submit.prevent='filter' class="flex items-center justify-start gap-2 lg:gap-4">
					<h1 class="text-sm font-medium uppercase text-dark">filter by</h1>
					<div class="h-12 w-[180px] space-y-1">
						<select wire:model.debounce="filterOne"
							class='w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 capitalize bg-gray-100 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none'
							id="">
							<option value="" class="">Select</option>
							@foreach ($fValues as $key => $option)
								<option class="my-2 capitalize" value="{{ $key }}">
									{{ $option }}
								</option>
							@endforeach
						</select>
						@error('filterOne')
							<span class="text-sm text-red-600">{{ $message }}</span>
						@enderror
					</div>
					<div class="h-12 w-[140px] space-y-1">
						<select wire:model="filterTwo"
							class='w-full h-full pl-4 space-y-2 text-sm font-medium text-gray-500 placeholder-gray-500 capitalize bg-gray-100 border-0 rounded-lg peer tt focus:border-2 focus:border-primary focus:bg-white focus:outline-none'
							id="">
							@if ($filterOne == 'subject_id')
								{
								@forelse (\App\Models\Subject::select(['id', 'name'])->get() as $option)
									<option class="py-2 capitalize" value="{{ $option->id }}">
										{{ $option->name }}
									</option>
								@empty
									<option class="py-2 capitalize" value="{{ null }}">
										No subject found
									</option>
								@endforelse
								}
							@elseif($filterOne == 'teacher_id')
								{
								@forelse (teachers() as $option)
									<option class="py-2 capitalize" value="{{ $option->school_id }}">
										{{ $option->title . ' ' . $option->first_name . ' ' . $option->last_name . ' - (' . $option->school_id . ')' }}
									</option>
								@empty
									<option class="py-2 capitalize" value="{{ null }}">
										No subject found
									</option>
								@endforelse
								}
							@else{
								<option class="py-2 capitalize" value="{{ null }}">
									Select
								</option>
								}
							@endif
						</select>
						@error('filterTwo')
							<span class="text-sm text-red-600">{{ $message }}</span>
						@enderror
					</div>
					<button class="px-8 font-normal border-2 btn submit-secondary max-w-max whitespace-nowrap">Filter</button>
				</form>
			</div>
		</div>
	</section>

	{{-- tables --}}
	<div class="grid w-full grid-cols-1 p-4 space-y-6 overflow-x-auto bg-white rounded-lg shadow-sm max-h-max"
		x-data="{ type: @entangle('type') }">
		<template x-if="type === 'class'">
			{{-- list of subject --}}
			<div class="relative space-y-6 2xl:space-y-8">
				<div class="flex items-center p-4 space-x-4 overflow-x-auto bg-white rounded-lg shadow" x-data="{ active: @entangle('activeClass') }">
					@forelse (\App\Models\Clas::with(['school'])->get() as $item)
						<button x-data="{ show: false }"
							class="relative px-6 py-2 text-sm uppercase border rounded-lg tt btn btn-primary-outline min-w-max border-primary"
							:class="active === {{ $item->id }} ? 'bg-primary text-white ' : 'bg-white text-primary'"
							@click="$wire.selectClass({{ $item->id }})">
							<span class="">{{ $item->name . $item->section }}</span>
						</button>
					@empty
						<p class="font-medium">No class registered yet</p>
					@endforelse
				</div>
				<div class="relative flex overflow-auto bg-white border rounded-lg shadow-sm min-h-max">
					{{-- days of the week --}}
					<div
						class="left-0 bottom-0 float-left m-0 w-[210px] min-w-[210px] border-r bg-white p-0 text-dark 2xl:w-[260px] 2xl:min-w-[260px]">
						<div class="py-8 m-0 -mt-1 text-center border-b">
							<p class="-rotate-[25deg] text-sm font-semibold uppercase">today's date <br> {{ date('dS M Y') }}</p>
						</div>
						@foreach (['mon' => 'monday', 'tue' => 'tuesday', 'wed' => 'wednesday', 'thu' => 'thursday', 'fri' => 'friday'] as $key => $day)
							<div
								class="{{ $key == strtolower(date('D')) ? 'font-normal bg-primary text-white' : '' }} m-0 border-b py-10 text-center">
								<p class="text-lg font-semibold capitalize">{{ $day }}</p>
							</div>
						@endforeach
					</div>
					{{-- the timetable starts here --}}
					<table class="flex flex-col flex-1 h-full p-0 m-0 overflow-x-auto border-collapse">
						{{-- header --}}
						<tr class="bg-opacity-25 bg-table">
							@for ($i = 0; $i < 100; $i++)
								<td class="m-0 h-[101px] w-56 border border-gray-300 text-center">
									<p class="px-10 text-lg font-medium uppercase min-w-max">Timetable</p>
								</td>
							@endfor
						</tr>

						@if ($activeClass)
							{{-- monday timetable --}}
							<tr
								class="{{ isToday('mon') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
								@forelse (classTimeTable($activeClass, 1) as $timetable)
									<td @mouseleave="hover=false" @mouseenter="hover=true" x-data="{ hover: false }"
										class="{{ strtolower(date('D')) == 'mon' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 border border-gray-300 text-center">
										<div class="my-[19px] space-y-1 p-0 text-center">
											{{-- ongoing --}}
											<span
												{{ strtolower(date('D')) == 'mon' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }}
												class="absolute top-0 right-0 w-2 h-2 m-2 text-xs rounded-full animate-ping"></span>
											<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
											<p class="text-sm">
												{{ $timetable->user->title . ' ' . $timetable->user->first_name . ' ' . $timetable->user->last_name }}
											</p>
											<span
												class="px-2 py-1 text-xs font-medium bg-white rounded-full shadow-sm text-dark">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
											</span>
										</div>
										{{-- edit icons --}}
										<div x-show="hover"
											class="absolute inset-0 flex items-center justify-center w-full h-full bg-white bg-opacity-90">
											<div class="flex space-x-2 item-center">
												<span wire:click="edit({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-blue-600 border border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="my-auto bi bi-eye" viewBox="0 0 16 16">
														<path
															d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
														<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
													</svg>
												</span>
												<span wire:click="confirmDelete({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-red-600 border border-red-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="bi bi-trash3" viewBox="0 0 16 16">
														<path
															d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
													</svg>
												</span>
											</div>
										</div>
									</td>
								@empty
									<td colspan="3" class="h-[109px] w-full bg-white text-center">
										<span class="py-[36px] text-secondary"></span>
									</td>
								@endforelse
							</tr>
							{{-- tuesday timeday --}}
							<tr
								class="{{ isToday('tue') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
								@forelse (classTimeTable($activeClass, 2) as $timetable)
									<td @mouseenter="hover=true" @mouseleave="hover=false" x-data="{ hover: false }"
										class="{{ isToday('tue') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 h-[75px] border border-gray-300 text-center">
										<div class="my-[19px] space-y-1 p-0 text-center">
											{{-- ongoing --}}
											<span
												{{ strtolower(date('D')) == 'tue' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }}
												class="absolute top-0 right-0 w-2 h-2 m-2 text-xs rounded-full animate-ping"></span>
											<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
											<p class="text-sm">
												{{ $timetable->user->title . ' ' . $timetable->user->first_name . ' ' . $timetable->user->last_name }}
											</p>
											<span
												class="px-2 py-1 text-xs font-medium bg-white rounded-full shadow-sm text-dark">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
											</span>
										</div>
										<div x-show="hover"
											class="absolute inset-0 flex items-center justify-center w-full h-full bg-white bg-opacity-90">
											<div class="flex space-x-2 item-center">
												<span wire:click="edit({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-blue-600 border border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="my-auto bi bi-eye" viewBox="0 0 16 16">
														<path
															d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
														<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
													</svg>
												</span>
												<span wire:click="confirmDelete({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-red-600 border border-red-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="bi bi-trash3" viewBox="0 0 16 16">
														<path
															d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
													</svg>
												</span>
											</div>
										</div>
									</td>
								@empty
									<td colspan="3" class="h-[109px] w-full bg-white text-center">
										<span class="py-[36px] text-secondary"></span>
									</td>
								@endforelse
							</tr>
							{{-- wednesday timeday --}}
							<tr
								class="{{ isToday('wed') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
								@forelse (classTimeTable($activeClass, 3) as $timetable)
									<td @mouseenter="hover=true" @mouseleave="hover=false" x-data="{ hover: false }"
										class="{{ isToday('wed') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 h-[75px] border border-gray-300 text-center">
										<div class="my-[19px] space-y-1 p-0 text-center">
											{{-- ongoing --}}
											<span
												{{ strtolower(date('D')) == 'wed' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }}
												class="absolute top-0 right-0 w-2 h-2 m-2 text-xs rounded-full animate-ping"></span>
											<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
											<p class="text-sm">
												{{ $timetable->user->title . ' ' . $timetable->user->first_name . ' ' . $timetable->user->last_name }}
											</p>
											<span
												class="px-2 py-1 text-xs font-medium bg-white rounded-full shadow-sm text-dark">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
											</span>
										</div>
										<div x-show="hover"
											class="absolute inset-0 flex items-center justify-center w-full h-full bg-white bg-opacity-90">
											<div class="flex space-x-2 item-center">
												<span wire:click="edit({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-blue-600 border border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="my-auto bi bi-eye" viewBox="0 0 16 16">
														<path
															d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
														<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
													</svg>
												</span>
												<span wire:click="confirmDelete({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-red-600 border border-red-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="bi bi-trash3" viewBox="0 0 16 16">
														<path
															d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
													</svg>
												</span>
											</div>
										</div>
									</td>
								@empty
									<td colspan="3" class="h-[109px] w-full bg-white text-center">
										<span class="py-[36px] text-secondary"></span>
									</td>
								@endforelse
							</tr>
							{{-- thursday timeday --}}
							<tr
								class="{{ isToday('thu') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
								@forelse (classTimeTable($activeClass, 4) as $timetable)
									<td x-data="{ hover: false }" @mouseenter="hover=true" @mouseleave="hover=false"
										class="{{ isToday('thu') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 h-[75px] border border-gray-300 text-center">
										<div class="my-[19px] space-y-1 p-0 text-center">
											{{-- ongoing --}}
											<span
												{{ isToday('thu') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-red-600 text-white' : '' }}
												class="absolute top-0 right-0 w-2 h-2 m-2 text-xs rounded-full"></span>
											<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
											<p class="text-sm">
												{{ $timetable->user->title . ' ' . $timetable->user->first_name . ' ' . $timetable->user->last_name }}
											</p>
											<span
												class="px-2 py-1 text-xs font-medium bg-white rounded-full shadow-sm text-dark">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
											</span>
										</div>
										<div x-show="hover"
											class="absolute inset-0 flex items-center justify-center w-full h-full bg-white bg-opacity-90">
											<div class="flex space-x-2 item-center">
												<span wire:click="edit({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-blue-600 border border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="my-auto bi bi-eye" viewBox="0 0 16 16">
														<path
															d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
														<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
													</svg>
												</span>
												<span wire:click="confirmDelete({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-red-600 border border-red-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="bi bi-trash3" viewBox="0 0 16 16">
														<path
															d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
													</svg>
												</span>
											</div>
										</div>
									</td>
								@empty
									<td colspan="3" class="h-[109px] w-full bg-white text-center">
										<span class="py-[36px] text-secondary"></span>
									</td>
								@endforelse
							</tr>
							{{-- friday timeday --}}
							<tr
								class="{{ isToday('fri') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
								@forelse (classTimeTable($activeClass, 5) as $timetable)
									<td x-data="{ hover: false }" @mouseenter="hover=true" @mouseleave="hover=false"
										class="{{ isToday('fri') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 h-[75px] border border-gray-300 text-center">
										<div class="my-[19px] space-y-1 p-0 text-center">
											{{-- ongoing --}}
											<span
												{{ strtolower(date('D')) == 'fri' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }}
												class="absolute top-0 right-0 w-2 h-2 m-2 text-xs rounded-full animate-ping"></span>
											<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
											<p class="text-sm">
												{{ $timetable->user->title . ' ' . $timetable->user->first_name . ' ' . $timetable->user->last_name }}
											</p>
											<span
												class="px-2 py-1 text-xs font-medium bg-white rounded-full shadow-sm text-dark">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
											</span>
										</div>
										<div x-show="hover"
											class="absolute inset-0 flex items-center justify-center w-full h-full bg-white bg-opacity-90">
											<div class="flex space-x-2 item-center">
												<span wire:click="edit({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-blue-600 border border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="my-auto bi bi-eye" viewBox="0 0 16 16">
														<path
															d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
														<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
													</svg>
												</span>
												<span wire:click="confirmDelete({{ $timetable->id }})"
													class="w-8 h-8 p-2 text-red-600 border border-red-600 rounded-full cursor-pointer tt hover:-translate-y-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
														class="bi bi-trash3" viewBox="0 0 16 16">
														<path
															d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
													</svg>
												</span>
											</div>
										</div>
									</td>
								@empty
									<td colspan="3" class="h-[109px] w-full bg-white text-center">
										<span class="py-[36px] text-secondary"></span>
									</td>
								@endforelse
							</tr>
						@else
							<div class="flex items-center justify-center w-full h-full p-12">
								<p class="pt-12 my-12 text-lg font-medium text-center uppercase text-secondary lg:my-24 lg:pt-24 lg:text-xl">
									Click
									on Class to
									display
									Timetable
								</p>
							</div>
						@endif
					</table>
				</div>
		</template>
		<template x-if="type != 'class'">
			<p>others</p>
		</template>
	</div>
</div>
