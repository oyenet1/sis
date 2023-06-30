<div class="flex flex-col w-full gap-6 py-8 lg:py-12">
	{{-- form --}}
	{{-- modal forms and inputs components --}}
	<x-modal class="max-w-lg">
		@if (!$sf)
			<div class="w-full gap-4 px-4 mx-auto mt-4 overflow-y-auto lg:px-12">
				<div class="w-full">
					<h4 class="mx-auto text-2xl font-bold text-center capitalize lg:text-3xl">
						Add Student
					</h4>
				</div>
				<form wire:submit.prevent="continue"
					class="flex flex-col w-full gap-6 mx-auto my-4 overflow-y-auto max-h-max min-h-fit" x-data="{ login: 'email', id: true }">
					<span class="px-4 text-sm text-center">You need to add parent details before you can add student. Parent
						can be
						added
						by id or email address</span>
					<h1 class="text-lg font-medium text-center lg:text-xl 2xl:text-2xl">Parent Information</h1>
					{{-- toggle id and emails --}}
					<div class="flex items-center justify-center m-0 space-x-4 text-sm font-medium">
						<span class="px-4 py-2 capitalize rounded-lg cursor-pointer"
							:class="login === 'email' ? 'bg-background text-primary' : 'text-primary'" @click="login = 'email'">Parent
							email</span>
						<span class="px-4 py-2 capitalize rounded-lg cursor-pointer"
							:class="login === 'id' ? 'bg-background text-primary' : 'text-primary'" @click="login = 'id'">Parent
							id</span>

					</div>
					<div class="w-full">
						{{-- <div @click="lower = true" class='relative w-full h-12 overflow-x-hidden text-gray-500 rounded-lg'
							x-data="{ lower: false }">
							<input wire:model.defer="parent"
								class='w-full h-full pt-6 pl-4 font-medium placeholder-gray-500 uppercase bg-gray-100 border-0 rounded-lg peer tt text-dark focus:border-2 focus:border-primary focus:bg-white focus:outline-none'
								type="text" , id="parent" />
							<label for="parent" :class="lower ? 'text-xs pt-1' : 'pt-3'"
								class="absolute left-0 z-50 p-4 text-sm font-medium text-gray-500 capitalize cursor-text peer-focus:pt-1"
								x-text="login == 'id' ? 'parent id': 'parent email'">
							</label>
						</div> --}}

						<x-single-datalist wire:model.defer="parent" name="Parent/Guardian" :datas="$parents" />
						<p class="p-1 text-sm 2xl:text-base">If parent is not registered yet. <a href="{{ route('parents') }}"
								class="tt text-primary hover:text-secondary">Add
								Parent</a>
						</p>
						@error('parent')
							<span class="text-red-600">{{ $message }}</span>
						@enderror
					</div>
					<button wire:loading.attr="disabled"
						class="tt submit-primary mx-auto block w-[331px] py-2 font-normal capitalize hover:bg-primary"
						type="submit">Continue
						<img wire:loading.delay wire:target='continue' src="/img/spin-white.svg" alt="" class="h-11 w-11">
					</button>
				</form>
			</div>
		@else
			<div class="w-full gap-4 px-4 mx-auto mt-4 overflow-y-auto lg:px-12">
				<div class="w-full">
					<h4 class="mx-auto text-2xl font-bold text-center capitalize lg:text-3xl">
						Add Student
					</h4>
				</div>

				<!-- Modal body -->
				<form wire:submit.prevent="save" class="flex flex-col w-full gap-6 mx-auto my-4 overflow-y-auto max-h-max min-h-fit"
					x-data="{ login: 'id', id: true }">
					<span class="text-sm text-center">Make sure that the parent information is correct</span>

					<div class="w-full space-y-1">
						<h1 class="text-lg font-medium text-center lg:text-xl 2xl:text-2xl">Parent Information</h1>
						<p
							class="w-full p-3 pl-4 font-medium placeholder-gray-500 uppercase bg-gray-100 border-0 rounded-lg cursor-not-allowed peer tt text-dark focus:border-2 focus:border-primary focus:bg-white focus:outline-none"
							@disabled(true)>
							{{ $parentD->first_name . ' ' . $parentD->last_name }}
						</p>
						<p class="p-1 text-sm 2xl:text-base">If parent's/guardian's information is not correct, kindly click
							<span class="cursor-pointer tt text-secondary hover:text-secondary" wire:click="toggleForm">here</span> to
							change it
						</p>
					</div>
					<h1 class="text-lg font-medium text-center lg:text-xl 2xl:text-2xl">Student Information</h1>
					<div class="flex items-center justify-between w-full gap-4">
						<x-input label="First Name*" name="first_name" type="text" wire:model.defer="first_name" class="w-[98%]" />
						<x-input label="Last Name*" name="last_name" type="text" wire:model.defer="last_name" class="w-[98%]" />
					</div>
					{{-- gender --}}
					<x-form.gender />
					<x-form.dob wire:model="dob" name="dob" label="Date of Birth*" />
					<x-clas-select />

					<button wire:loading.attr="disabled"
						class="tt submit-primary mx-auto w-[331px] py-2 font-normal capitalize hover:bg-primary" type="submit">save
						<img wire:loading.delay wire:target='save' src="/img/spin-white.svg" alt="" class="h-11 w-11">
					</button>
				</form>
			</div>
		@endif
	</x-modal>

	{{-- alert notification --}}
	@if (session('success'))
		<x-alert type="success" :message="session('success')">
			<i class="text-3xl bi bi-check2-circle"></i>
		</x-alert>
	@endif

	{{-- fixed header and search bar --}}
	<section class="flex flex-col w-full gap-6 bg-background" x-data="{ active: 'students' }">
		{{-- headers links with numbers of students both total and active --}}
		<div class="flex flex-wrap items-center justify-end w-full">
			{{-- users link are here --}}
			{{-- <x-users-link /> --}}

			<div class="flex flex-col text-gray-500">
				<p class="">Total students:
					<strong class="text-black">{{ teachersClass() ? activeClassStudents(teachersClass()->id)->count() : '0' }}</strong>
				</p>
			</div>
		</div>
		{{-- buttons --}}
		<div class="flex items-center justify-between">
			<div class="flex items-center space-x-6">
				<h1 class="text-3xl font-semibold capitalize text-primary">student</h1>
				@if (currentUser()->hasRole(['superadministrator', 'admin']))
					<x-button.add name="student" />
				@endif
			</div>

			{{-- right side --}}
			<div class="flex items-center space-x-6">
				@if ($checked)
					<x-button.generate-excel />
					<x-button.generate-report />
				@else
				@endif
				<x-search name="student" />
			</div>
		</div>
	</section>

	@if ($students->count() > 0)
		{{-- tables --}}
		<div class="w-full px-4 pb-4 overflow-x-auto bg-white rounded-lg shadow-sm">
			<table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
				<thead class="w-full pb-4 text-xl border-b">
					<tr class="font-medium">
						<th class="p-2"></th>
						<th class="p-2 text-xl font-medium text-left">Name</th>
						<th class="p-2 text-xl font-medium text-left">Student ID</th>
						<th class="p-2 text-xl font-medium text-left">Class</th>
						<th class="p-2 text-xl font-medium text-left">DOB</th>
						<th class="p-2 text-xl font-medium text-left">Status</th>
						<th class="p-2"></th>
					</tr>
				</thead>
				<tbody class="w-full overflow-x-auto break-normal">
					@forelse ($students as $student)
						{{-- only show the students where the class is in that class texher --}}
						@if ($student->clas_id != teachersClass()->id)
							@continue
						@endif
						<tr class="even:bg-primary-light">

							<td class="">
								<span class="flex items-center space-x-3">
									<input type="checkbox" wire:model="checked" id="" value="{{ $student->id }}"
										class="block rounded whitespace-nowrap text-primary focus:outline-none focus:ring-primary">
									<img src="{{ $student->getFirstMediaUrl('student') }}"
										alt="{{ $student->first_name . ' ' . $student->last_name }}"
										class="block object-cover p-1 rounded-full aspect-square h-14 w-14">
								</span>
							</td>
							<td class="p-2 whitespace-nowrap">
								<p class="capitalize">{{ $student->first_name . ' ' . $student->last_name }}</p>
								<x-admitted>
									{{ $student->created_at->format('d M, Y') }}
								</x-admitted>
							</td>
							<td class="p-2 whitespace-nowrap">
								{{ $student->student_id }}
							</td>
							<td class="p-2 uppercase">
								@if ($student->clas)
									<span>{{ $student->clas->name ? $student->clas->school->short . ' ' . $student->clas->name . $student->clas->section : $student->clas->school->short }}</span>
								@endif
							</td>
							<td class="p-2 capitalize">
								{{ $student->dob->format('d M, Y') }}
							</td>
							<td class="p-2 whitespace-nowrap">

								@if ($student->status === 'active')
									<span
										class="block w-20 py-2 text-sm font-normal text-center capitalize bg-opacity-25 rounded-lg shadow-sm bg-secondary text-secondary">{{ $student->status }}</span>
								@elseif($student->status == 'graduated')
									<span
										class="block w-20 py-2 text-sm font-normal text-center text-green-600 capitalize bg-green-600 bg-opacity-25 rounded-lg shadow-sm">{{ $student->status }}</span>
								@else
									<span
										class="block w-20 py-2 text-sm font-normal text-center capitalize bg-opacity-25 rounded-lg shadow-sm bg-primary text-primary">{{ $student->status }}</span>
								@endif
							</td>
							<td class="p-2 whitespace-nowrap">
								<div class="flex space-x-2 item-center">
									<a href="{{ route('students.profile', [$student->guardian->first_name, $student->last_name]) }}"
										class="w-8 h-8 p-2 text-blue-600 border border-blue-600 rounded-full cursor-pointer tt hover:-translate-y-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
											class="my-auto bi bi-eye" viewBox="0 0 16 16">
											<path
												d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
											<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
										</svg>
									</a>
									<span wire:click="confirmDelete({{ $student->id }})"
										class="w-8 h-8 p-2 text-red-600 border border-red-600 rounded-full cursor-pointer tt hover:-translate-y-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
											class="bi bi-trash3" viewBox="0 0 16 16">
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
					{{ $students->links() }}
				</x-per-page>
			</div>
		</div>
	@else
		<x-empty-table
			comment="There is no student register yet, you can add student by first creating the guardian/parent account and then use the parent email/id to register student into the system "
			title="student">
			<p class="max-w-xl text-center">There is no student register yet, you can add student by first creating the
				guardian/parent account and then use the parent email/id to register student into the system
			</p>
		</x-empty-table>
	@endif

</div>
