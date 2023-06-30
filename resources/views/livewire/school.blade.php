<div class="flex w-full flex-col gap-6 py-8 lg:py-12">
	{{-- form --}}
	{{-- modal forms and inputs components --}}
	<x-modal class="max-w-lg">
		<x-form title="class" :update="$update">
			{{-- <x-select name="type" :options="$types" /> --}}
			<x-form.school-type-select />
			@if ($school_id == 4)
				<div class="flex items-center space-x-4">
					@foreach ($highs as $index => $item)
						<label class="cursor-pointer capitalize" for="{{ $index }}">{{ $item }}
							<input
								class="mx-2 text-secondary focus:border-2 focus:border-secondary focus:outline-0 focus:ring-2 focus:ring-secondary"
								type="radio" wire:model="high" value="{{ $item }}" id="{{ $index }}"></label>
					@endforeach
					@error('high')
						<span class="text-red-600">{{ $message }}</span>
					@enderror
				</div>
			@endif

			{{-- class variation e.g 1-6 --}}
			@if ($school_id == 1 || $school_id == 2 || $school_id == 3 || $school_id == 4 || $school_id == 5)
				<x-select name="name" class="bg-gray-50" :options="$numbers" />
				<x-select name="section" class="bg-gray-50" :options="range('A', 'Z')" />
			@endif

			<div class="h-12 w-full space-y-1">
				<select wire:model.defer="user_id"
					class='peer tt h-full w-full space-y-2 rounded-lg border-0 bg-gray-100 pl-4 text-sm font-medium text-gray-500 placeholder-gray-500 focus:border-2 focus:border-primary focus:bg-white focus:outline-none'
					id="">
					<option value="{{ null }}" class="">Select Class Teacher*</option>
					<option value="{{ null }}" class="">Remove Teacher*</option>
					@foreach ($teachers as $option)
						<option class="py-2" value="{{ $option->id }}">{{ $option->first_name . ' ' . $option->last_name }}
						</option>
					@endforeach
				</select>
				@error('user_id')
					<span class="text-red-600">{{ $message }}</span>
				@enderror
			</div>

		</x-form>
	</x-modal>

	{{-- alert notification --}}
	@if (session('success'))
		<x-alert type="success" :message="session('success')">
			<i class="bi bi-check2-circle text-3xl"></i>
		</x-alert>
	@endif

	{{-- fixed header --}}
	<header class="flex w-full flex-col gap-6 bg-background">
		{{-- headers links with numbers of classes both total and active --}}
		<div class="flex w-full flex-wrap items-center justify-end">
			{{-- users link are here --}}

			<div class="flex flex-col text-gray-500">
				<p class="">Total Class:
					<strong class="text-black">{{ \App\Models\Clas::all()->count() }}</strong>
				</p>
			</div>
		</div>

		{{-- buttons --}}
		<div class="flex items-center justify-between">
			<div class="flex items-center space-x-6">
				<h1 class="text-3xl font-semibold capitalize text-primary">Class</h1>
				@if ($checked)
					<button class="btn btn-secondary font-normal">Select All {{ count($checked) }}</button>
					<x-button.bulk-delete />
				@else
					<x-button.add name="class" />
				@endif

			</div>

			{{-- right side --}}
			<div class="flex items-center space-x-6">
				@if ($checked)
					<x-button.generate-excel />
					<x-button.generate-report />
				@else
				@endif
				<x-search name="class" />
			</div>
		</div>
	</header>

	{{-- tables --}}
	<div class="w-full overflow-x-auto rounded-lg bg-white px-4 pb-4 shadow-sm">
		<table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
			<thead class="w-full border-b pb-4 text-xl">
				<tr class="font-medium">
					<th class="p-2"></th>
					<th class="p-2 text-left text-xl font-medium">Class name</th>
					<th class="p-2 text-xl font-medium">Section</th>
					<th class="p-2 text-left text-xl font-medium">Categories/Type</th>
					<th class="p-2 text-xl font-medium">No of student</th>
					<th class="p-2 text-left text-xl font-medium">Class Teacher</th>
					<th class="p-2"></th>
				</tr>
			</thead>
			<tbody class="w-full overflow-x-auto break-normal">
				@forelse ($classes as $class)
					<tr class="capitalize even:bg-primary-light">
						<td class="whitespace-nowrap p-2">
							<input type="checkbox" wire:model="checked" id="" value="{{ $class->id }}"
								class="block whitespace-nowrap rounded text-primary focus:outline-none focus:ring-primary">
						</td>
						<td class="whitespace-nowrap p-2 uppercase">
							{{ $class->name }}
						</td>
						<td class="p-2 text-center capitalize">
							{{ $class->section }}
						</td>
						<td class="whitespace-nowrap p-2">
							@if ($class->high)
								{{ $class->high }}
							@else
								{{ $class->school->name }}
							@endif
						</td>
						<td class="p-2 text-center capitalize">
							{{ $class->students->count() }}
						</td>
						<td class="whitespace-nowrap p-2">
							@if ($class->user)
								<span> {{ $class->user->first_name . ' ' . $class->user->last_name ?? '' }}</span>
							@else
								<span>- - -</span>
							@endif
						</td>
						<td class="whitespace-nowrap p-2">
							<div class="item-center flex space-x-2">
								<span wire:click="edit({{ $class->id }})"
									class="tt h-8 w-8 cursor-pointer rounded-full border border-blue-600 p-2 text-blue-600 hover:-translate-y-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil"
										viewBox="0 0 16 16">
										<path
											d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
									</svg>
								</span>
								<span wire:click="confirmDelete({{ $class->id }})"
									class="tt h-8 w-8 cursor-pointer rounded-full border border-red-600 p-2 text-red-600 hover:-translate-y-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3"
										viewBox="0 0 16 16">
										<path
											d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
									</svg>
								</span>
							</div>
						</td>
					</tr>
				@empty
					<h1 class="text-2xl font-bold">No records found in the database</h1>
				@endforelse
			</tbody>
		</table>

		{{-- pagnation components --}}
		<div class="mt-4">
			<x-per-page>
				{{ $classes->links() }}
			</x-per-page>
		</div>
	</div>
</div>
