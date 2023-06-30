<div class="relative flex min-h-max overflow-auto rounded-lg border bg-white shadow-sm">
	{{-- days of the week --}}
	<div
		class="left-0 bottom-0 float-left m-0 w-[210px] min-w-[210px] border-r bg-white p-0 text-dark 2xl:w-[260px] 2xl:min-w-[260px]">
		<div class="m-0 -mt-1 border-b py-8 text-center">
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
	<table class="m-0 flex h-full flex-1 border-collapse flex-col overflow-x-auto p-0">
		{{-- header --}}
		<tr class="bg-table bg-opacity-25">
			@for ($i = 0; $i < 100; $i++)
				<td class="m-0 h-[101px] w-56 border border-gray-400 text-center">
					<p class="min-w-max px-10 text-lg font-medium uppercase">Timetable</p>
				</td>
			@endfor
		</tr>

		{{-- monday timetable --}}
		<tr class="{{ isToday('mon') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
			{{-- pass id of the teachers class id here --}}
			@forelse (teacherTimeTable(1) as $timetable)
				<td title=""
					class="{{ strtolower(date('D')) == 'mon' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 border border-gray-400 text-center">
					<div class="my-[19px] space-y-1 p-0 text-center">
						{{-- ongoing --}}
						<span
							{{ strtolower(date('D')) == 'mon' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }}
							class="absolute top-0 right-0 m-2 h-2 w-2 animate-ping rounded-full text-xs"></span>
						<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
						<p class="text-sm font-medium uppercase text-secondary">
							{{ $timetable->clas->name . $timetable->clas->section . ' ' . $timetable->clas->high }}
						</p>
						<span
							class="rounded-full bg-white px-2 py-1 text-xs font-medium text-dark shadow-sm">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
						</span>
					</div>
				</td>
			@empty
				<td colspan="3" class="h-[109px] w-full bg-white text-center">
					<span class="py-[36px] text-secondary"></span>
				</td>
			@endforelse
		</tr>
		{{-- tuesday timeday --}}
		<tr class="{{ isToday('tue') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
			@forelse (teacherTimeTable(2) as $timetable)
				<td title=""
					class="{{ isToday('tue') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 h-[75px] border border-gray-400 text-center">
					<div class="my-[19px] space-y-1 p-0 text-center">
						{{-- ongoing --}}
						<span
							{{ strtolower(date('D')) == 'tue' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }}
							class="absolute top-0 right-0 m-2 h-2 w-2 animate-ping rounded-full text-xs"></span>
						<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
						<p class="text-sm font-medium uppercase text-secondary">
							{{ $timetable->clas->name . $timetable->clas->section . ' ' . $timetable->clas->high }}
						</p>
						<span
							class="rounded-full bg-white px-2 py-1 text-xs font-medium text-dark shadow-sm">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
						</span>
					</div>
				</td>
			@empty
				<td colspan="3" class="h-[109px] w-full bg-white text-center">
					<span class="py-[36px] text-secondary"></span>
				</td>
			@endforelse
		</tr>
		{{-- wednesday timeday --}}
		<tr class="{{ isToday('wed') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
			@forelse (teacherTimeTable(3) as $timetable)
				<td title=""
					class="{{ isToday('wed') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 h-[75px] border border-gray-400 text-center">
					<div class="my-[19px] space-y-1 p-0 text-center">
						{{-- ongoing --}}
						<span
							{{ strtolower(date('D')) == 'wed' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }}
							class="absolute top-0 right-0 m-2 h-2 w-2 animate-ping rounded-full text-xs"></span>
						<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
						<p class="text-sm font-medium uppercase text-secondary">
							{{ $timetable->clas->name . $timetable->clas->section . ' ' . $timetable->clas->high }}
						</p>
						<span
							class="rounded-full bg-white px-2 py-1 text-xs font-medium text-dark shadow-sm">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
						</span>
					</div>
				</td>
			@empty
				<td colspan="3" class="h-[109px] w-full bg-white text-center">
					<span class="py-[36px] text-secondary"></span>
				</td>
			@endforelse
		</tr>
		{{-- thursday timeday --}}
		<tr class="{{ isToday('thu') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
			@forelse (teacherTimeTable(4) as $timetable)
				<td title=""
					class="{{ isToday('thu') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 h-[75px] border border-gray-400 text-center">
					<div class="my-[19px] space-y-1 p-0 text-center">
						{{-- ongoing --}}
						<span
							{{ isToday('thu') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-red-600 text-white' : '' }}
							class="absolute top-0 right-0 m-2 h-2 w-2 rounded-full text-xs"></span>
						<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
						<p class="text-sm font-medium uppercase text-secondary">
							{{ $timetable->clas->name . $timetable->clas->section . ' ' . $timetable->clas->high }}
						</p>
						<span
							class="rounded-full bg-white px-2 py-1 text-xs font-medium text-dark shadow-sm">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
						</span>
					</div>
				</td>
			@empty
				<td colspan="3" class="h-[109px] w-full bg-white text-center">
					<span class="py-[36px] text-secondary"></span>
				</td>
			@endforelse
		</tr>
		{{-- friday timeday --}}
		<tr class="{{ isToday('fri') ? 'font-normal bg-primary text-white' : 'bg-gray-50' }} m-0 w-full overflow-x-auto p-0">
			@forelse (teacherTimeTable(5) as $timetable)
				<td title=""
					class="{{ isToday('fri') && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }} relative m-0 h-[75px] border border-gray-400 text-center">
					<div class="my-[19px] space-y-1 p-0 text-center">
						{{-- ongoing --}}
						<span
							{{ strtolower(date('D')) == 'fri' && toNumber($timetable->start->format('H')) <= toNumber(date('H') + 1) && toNumber($timetable->end->format('H')) >= toNumber(date('H') + 1) ? 'bg-green-600 text-white' : '' }}
							class="absolute top-0 right-0 m-2 h-2 w-2 animate-ping rounded-full text-xs"></span>
						<p class="text-sm font-semibold capitalize">{{ $timetable->subject->name }}</p>
						<p class="text-sm font-medium uppercase text-secondary">
							{{ $timetable->clas->name . $timetable->clas->section . ' ' . $timetable->clas->high }}
						</p>
						<span
							class="rounded-full bg-white px-2 py-1 text-xs font-medium text-dark shadow-sm">{{ $timetable->start->format('h:iA') . ' - ' . $timetable->end->format('h:iA') }}</span>
						</span>
					</div>
				</td>
			@empty
				<td colspan="3" class="h-[109px] w-full bg-white text-center">
					<span class="py-[36px] text-secondary"></span>
				</td>
			@endforelse
		</tr>
	</table>
</div>
