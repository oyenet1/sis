<div class="w-full" x-data="{ update: @entangle('update') }">
	{{-- profile page --}}
	<div x-show="!update" class="flex flex-col w-full gap-6 py-8 lg:py-12">
		@if (session('success'))
			<x-alert type="success" :message="session('success')">
				<i class="text-3xl bi bi-check2-circle"></i>
			</x-alert>
		@endif
		{{-- upload image form --}}
		<x-modal class="max-w-sm">
			<form wire:submit.prevent='changeProfileImage' class="w-full" x-data="{ src: '/img/avatar.png' }">
				<div class="flex items-center py-4 mx-auto space-x-4 max-w-max">
					<div class="relative">
						<label for='image'
							class="absolute top-0 bg-white rounded-full shadow cursor-pointer tt max-max-max right-2 max-h-max hover:bg-gray-100">
							{{-- <i class="mx-auto text-sm bi bi-pencil"></i> --}}
							<svg xmlns="http://www.w3.org/2000/svg" class="m-1" width="24" height="24"
								style="fill: rgba(0, 57, 115, 1);transform: ;msFilter:;">
								<path
									d="M8.707 19.707 18 10.414 13.586 6l-9.293 9.293a1.003 1.003 0 0 0-.263.464L3 21l5.242-1.03c.176-.044.337-.135.465-.263zM21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586 19.414 9 21 7.414z">
								</path>
							</svg>
						</label>
						<input type="file" wire:model.defer="image" id="image" class="hidden"
							@change="src= URL.createObjectURL($event.target.files[0])">
						<img :src="src" alt="{{ $student->student_id }}"
							class="object-cover w-20 h-20 mt-2 border border-gray-200 rounded-full shadow-sm lg:h-24 lg:w-24 xl:h-28 xl:w-28">
					</div>
					<div class="flex flex-col">
						<div class="flex items-center w-full space-x-3">
							<button class="font-normal text-white btn tt bg-primary hover:bg-secondary" type="submit">Upload
								Image</button>
							<button type="button" class="font-normal btn tt hover:bg-gray-200" wire:click="resetImage"
								@click="src = '/img/avatar-1.jpg'">Reset</button>
						</div>
						<p class="w-60">
							@if ($errors->any())
								@error('image')
									<span class="w-24 text-sm leading-tight text-red-600" style="line-height: 0px">{{ $message }}</span>
								@enderror
							@else
								<span class="line max-w-[200px] leading-tight" style="line-height: 0px">Image allowed
									png,jpeg,
									jpg</span>
							@endif
						</p>
					</div>
				</div>
			</form>
		</x-modal>

		<div class="w-full p-0 mx-auto space-y-8 max-w-7xl xl:w-11/12 xl:space-y-12 2xl:w-3/4">
			<div class="flex items-center justify-between">
				<div class="flex items-center space-x-6">
					<h1 class="text-3xl font-semibold capitalize text-primary">Profile</h1>
				</div>
				{{-- profile header --}}
				<x-profile-header />
			</div>

			{{-- profile --}}
			<div class="grid w-full grid-cols-1 gap-8 lg:grid-cols-3">
				<div class="relative flex flex-col w-full col-span-1 p-8 pb-4 bg-white rounded-lg shadow lg:pt-12 2xl:p-12">
					<span
						class="btn btn-sm absolute top-0 right-0 m-4 border-0 bg-[#F38111] px-4 font-normal capitalize text-white text-opacity-100">{{ $student->status }}</span>
					<div class="relative mx-auto max-w-max">
						<span wire:click='openForm'
							class="absolute top-0 bg-white rounded-full shadow cursor-pointer tt max-max-max right-2 max-h-max hover:bg-gray-100">
							<svg xmlns="http://www.w3.org/2000/svg" class="m-1" width="24" height="24"
								style="fill: rgba(0, 57, 115, 1);transform: ;msFilter:;">
								<path
									d="M8.707 19.707 18 10.414 13.586 6l-9.293 9.293a1.003 1.003 0 0 0-.263.464L3 21l5.242-1.03c.176-.044.337-.135.465-.263zM21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586 19.414 9 21 7.414z">
								</path>
							</svg>
						</span>
						<img src="{{ $student->getFirstMediaUrl('student') }}" alt="{{ $student->student_id }}"
							class="object-cover w-20 h-20 mt-2 border border-gray-200 rounded-full shadow-sm lg:h-24 lg:w-24 xl:h-28 xl:w-28">
					</div>
					<div class="w-full mt-4 space-y-1 text-center">
						<h1 class="text-2xl font-semibold capitalize text-dark">
							{{ $student->first_name . ' ' . $student->last_name }}
						</h1>
						<x-admitted>
							{{ $student->created_at ? $student->created_at->format('d M, Y') : '' }}
						</x-admitted>
					</div>
					<table class="w-full my-6">
						<tbody class="w-full">
							<tr class="py-1 font-medium text-black text-opacity-50">
								<td class="py-1" style="word-wrap: normal; word-break: keep-all">Student-Id:</td>
								<td class="py-1 uppercase text-dark">{{ $student->student_id }}</td>
							</tr>
							<tr class="py-1 font-medium text-black text-opacity-50">
								<td class="py-1">Age:</td>
								<td class="py-1 uppercase text-dark">{{ $student->dob ? $student->dob->diffInYears() : '' }}</td>
							</tr>
							<tr class="py-1 font-medium text-black text-opacity-50 capitalize">
								<td class="py-1">Gender:</td>
								<td class="py-1 uppercase text-dark">{{ $student->gender }}</td>
							</tr>
							<tr class="py-1 font-medium text-black text-opacity-50">
								<td class="py-1">School:</td>
								@if ($student->clas)
									<td class="py-1 uppercase text-dark">{{ strtok($student->clas->school->name, ' ') }}</td>
								@else
									<td class="py-1">Class not assign yet</td>
								@endif

							</tr>
							<tr class="py-1 font-medium text-black text-opacity-50">
								<td class="py-1">Class:</td>
								@if ($student->clas)
									<td class="py-1 uppercase text-dark">
										{{ $student->clas->school->short . ' ' . $student->clas->name . $student->clas->section }}
									</td>
								@else
									<td class="py-1">Class not assign yet</td>
								@endif

							</tr>
							<tr class="py-1 font-medium text-black text-opacity-50">
								<td class="py-1">Email:</td>
								<td class="py-1 break-all text-dark">{{ $student->email }}</td>
							</tr>
							<tr class="py-1 font-medium text-black text-opacity-50">
								<td class="py-1">Telephone:</td>
								<td class="py-1 uppercase text-dark">{{ $student->phone }}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="flex flex-col w-full gap-6 lg:col-span-2 2xl:gap-8">
					<div class="grid w-full grid-cols-2 gap-6 2xl:gap-8">
						<div class="p-8 bg-white rounded-lg shadow-md">
							<h1 class="mb-4 text-2xl font-semibold text-dark">Student Bio-data</h1>
							<table class="w-full p-4 lg:p-6">
								<tbody class="flex-col w-full">
									<tr class="py-1 font-medium text-black text-opacity-50">
										<td class="py-1">Date of Birth:</td>
										<td class="py-1 capitalize text-dark">{{ formatDate($student->dob) }}</td>
									</tr>
									<tr class="py-1 font-medium text-black text-opacity-50">
										<td class="py-1 capitalize">Blood group:</td>
										<td class="py-1 capitalize text-dark">{{ $student->blood ?? 'null' }}</td>
									</tr>
									<tr class="py-1 font-medium text-black text-opacity-50 capitalize">
										<td class="py-1">Disability:</td>
										<td class="py-1 capitalize text-dark">{{ $student->disability ?? 'null' }}</td>
									</tr>
									<tr class="py-1 font-medium text-black text-opacity-50">
										<td class="py-1">Religion:</td>
										<td class="py-1 capitalize text-dark">{{ $student->religion ?? 'null' }}
										</td>
									</tr>
									<tr class="py-1 font-medium text-black text-opacity-50">
										<td class="py-1">Hobbies:</td>
										<td class="py-1 capitalize text-dark">
											<p class="flex flex-wrap items-center justify-start gap-2 text-sm">
												@if ($student->hobbies)
													@forelse($student->hobbies as $key => $hobby)
														<span class="">{{ $hobby }}</span>
													@empty
														<span class="">null</span>
													@endforelse
												@endif
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="p-8 bg-white rounded-lg shadow-md">
							<h1 class="mb-4 text-2xl font-semibold capitalize text-dark">Guardian Information</h1>
							<table class="w-full p-4 lg:p-6">
								<tbody class="flex-col w-full">
									<tr class="py-1 space-x-2 font-medium text-black text-opacity-50">
										<td class="py-1">Name:</td>
										<td class="py-1 capitalize text-dark">
											{{ $student->guardian->title . ' ' . $student->guardian->first_name . ' ' . $student->guardian->last_name }}
										</td>
									</tr>
									<tr class="py-1 space-x-2 font-medium text-black text-opacity-50">
										<td class="py-1">Phone:</td>
										<td class="py-1 uppercase text-dark">{{ $student->guardian->phone }}</td>
									</tr>
									<tr class="py-1 space-x-2 font-medium text-black text-opacity-50">
										<td class="py-1">Email:</td>
										<td class="py-1 text-dark">{{ $student->guardian->email }}</td>
									</tr>
									<tr class="py-1 space-x-2 font-medium text-black text-opacity-50">
										<td class="py-1">Occupation:</td>
										<td class="py-1 capitalize text-dark">{{ $student->guardian->occupation }}
										</td>
									</tr>
									<tr class="py-1 space-x-2 font-medium text-black text-opacity-50">
										<td class="py-1">Address:</td>
										<td class="py-1 text-dark">
											{{ $student->guardian->address }}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="max-h-[220px] min-h-[150px] overflow-y-auto rounded-lg bg-white p-8 shadow-md">
						@if ($fees->count() > 0 && $fees)
							<div class="flex items-center justify-between">
								<h1 class="text-2xl font-semibold text-dark">Fee</h1>
							</div>
							<table class="w-full p-4 mt-4 lg:p-6">
								<tbody class="flex-col w-full">
									@foreach ($fees as $fee)
										<tr class="w-full py-1 font-medium text-black">
											<td class="py-2 capitalize">{{ $fee->type }}</td>
											<td class="py-2 text-dark">&#8358 {{ moneyFormat($fee->amount) }}</td>
											<td class="py-2 text-center text-dark">
												@if (in_array($fee->id, $paid))
													<span class="text-green-600 cursor-not-allowed"><i class="text-2xl bi bi-check2-circle"></i></span>
												@else
													<button wire:click="pay({{ $fee->id }})"
														class="px-4 py-1 mx-auto font-normal text-white capitalize rounded tt bg-secondary hover:-translate-y-1">pay</button>
												@endif

											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@else
							<x-empty-table comment="There is no outstanding fee to pay. The list of all fees will display here"
								title="fee">
								<p class="max-w-xs text-center">There is no outstanding fee to pay. The list of all fees will display
									here
								</p>
							</x-empty-table>
						@endif
					</div>
				</div>
			</div>

			{{-- payments --}}
			<div class="p-8 bg-white rounded-lg shadow-md">
				@if ($payments->count() > 0 && $payments)
					<div class="flex items-center justify-between mb-4">
						<h1 class="text-2xl font-semibold text-dark">Payment History</h1>
						<x-session-select />
					</div>
					<table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
						<thead class="w-full pb-4 text-xl border-b">
							<tr class="z-10 font-medium">
								<th wire:click="sortBy('term_id')"
									class="p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
									<span class="">Payment Type</span>
								</th>
								<th wire:click="sortBy('amount')"
									class="items-center p-2 text-center transition duration-300 transform cursor-pointer hover:text-primary">
									<span class="">Amount</span>
								</th>
								<th wire:click="sortBy('method')"
									class="items-center p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
									<span class="">Method</span>
								</th>
								<th class="items-center p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
									<span class="">Date</span>
								</th>

								<th class="p-2 transition duration-300 transform cursor-pointer hover:text-primary">
									<span class="">Status</span>
								</th>
								<th></th>
							</tr>
						</thead>
						<tbody class="w-full overflow-x-auto break-normal">
							@forelse ($payments as $payment)
								<tr class="capitalize even:bg-primary-light">
									<td class="p-2 uppercase">
										{{ $payment->fee->type }}
									</td>
									<td class="p-2 text-center capitalize">
										<span class="p-2 mx-auto text-center bg-opacity-25 rounded shadow-sm bg-secondary text-secondary">
											&#8358 {{ moneyFormat($payment->fee->amount) }}</span>
									</td>
									<td class="p-2 uppercase">

										{{ $payment->method->name }}
									</td>
									<td class="p-2 text-sm capitalize">
										{{ formatDateTime($payment->created_at) }}
									</td>
									<td class="p-2 text-center capitalize">
										@if ($payment->status === 'processing')
											<span
												class="block w-24 py-2 mx-auto text-sm font-normal text-center capitalize bg-opacity-25 rounded-lg shadow-sm bg-secondary text-secondary">{{ $payment->status }}</span>
										@elseif($payment->status == 'successful')
											<span
												class="block w-24 py-2 mx-auto text-sm font-normal text-center text-green-600 capitalize bg-green-600 bg-opacity-25 rounded-lg shadow-sm">{{ $payment->status }}</span>
										@elseif($payment->status == 'cancelled')
											<span
												class="block w-24 py-2 mx-auto text-sm font-normal text-center text-gray-600 capitalize bg-gray-600 bg-opacity-25 rounded-lg shadow-sm">{{ $payment->status }}</span>
										@else
											<span
												class="block w-24 py-2 mx-auto text-sm font-normal text-center capitalize bg-opacity-25 rounded-lg shadow-sm bg-primary text-primary">{{ $payment->status }}</span>
										@endif
									</td>

									<td class="p-2 whitespace-nowrap">
										<div class="flex space-x-2 item-center">
											<span wire:click="printReceipt({{ $payment->id }})"
												class="w-8 h-8 p-2 border rounded-full cursor-pointer tt border-primary text-primary hover:-translate-y-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
													class="bi bi-printer" viewBox="0 0 16 16">
													<path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
													<path
														d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
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
				@else
					<x-empty-table comment='There is no outstanding payment to pay. The list of all fees will display here'
						title="payment">
						<p class="max-w-xs text-center">There is no outstanding payment to pay. The list of all payement made will
							display
							here
						</p>
					</x-empty-table>
				@endif
			</div>
			{{-- timetables --}}
			<div class="space-y-4 rounded-lg">
				<h1 class="text-3xl font-semibold text-center capitalize">Time table</h1>
				@if ($student->clas && $student->clas->timetables->count() > 0)
					<x-student-timetable :student="$student" />
				@else
					<x-empty-table comment="There is no outstanding payment to pay. The list of all fees will display here"
						title="Timetable">
						<p class="max-w-xs text-center">There is no timetable assign to your class yet. You can report this to the
							school admin
						</p>
					</x-empty-table>
				@endif
			</div>
		</div>
	</div>

	<div x-show="update" class="flex flex-col w-full gap-6 py-8 lg:py-12">
		{{-- alert notification --}}
		@if (session('success'))
			<x-alert type="success" :message="session('success')">
				<i class="text-3xl bi bi-check2-circle"></i>
			</x-alert>
		@endif
		<div class="w-full p-0 mx-auto space-y-8 max-w-7xl xl:w-11/12 xl:space-y-12 2xl:w-3/4" x-data="{ profile: @entangle('profile') }">
			<div class="flex items-center justify-between">
				<h1 class="text-3xl font-semibold capitalize text-primary">Profile Setting</h1>
				<button wire:click="edit" class="px-8 text-sm font-normal btn btn-primary">View Profile</button>
			</div>
			<div class="flex gap-8 overflow-x-auto">
				<div class="w-100 w-[250px] rounded-lg p-4 lg:w-72 2xl:w-80">
					{{-- profile navigation --}}
					<x-profile-link :student="$student" />
				</div>
				<div class="flex flex-col flex-1 rounded-lg">
					@if ($profile === 'personal')
						<div class="w-full space-y-4 2xl:space-y-8">
							<form wire:submit.prevent='changeProfileImage' class="w-full" x-data="{ src: '/img/avatar.png' }">
								<div class="flex items-center py-4 space-x-4 max-w-max">
									<div class="relative">
										<label for='img'
											class="absolute top-0 bg-white rounded-full shadow cursor-pointer tt max-max-max right-2 max-h-max hover:bg-gray-100">
											{{-- <i class="mx-auto text-sm bi bi-pencil"></i> --}}
											<svg xmlns="http://www.w3.org/2000/svg" class="m-1" width="24" height="24"
												style="fill: rgba(0, 57, 115, 1);transform: ;msFilter:;">
												<path
													d="M8.707 19.707 18 10.414 13.586 6l-9.293 9.293a1.003 1.003 0 0 0-.263.464L3 21l5.242-1.03c.176-.044.337-.135.465-.263zM21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586 19.414 9 21 7.414z">
												</path>
											</svg>
										</label>
										<input type="file" wire:model.defer="image" id="img" class="hidden"
											@change="src= URL.createObjectURL($event.target.files[0])">
										<img :src="src" alt="{{ $student->student_id }}"
											class="object-cover w-20 h-20 mt-2 border border-gray-200 rounded-full shadow-sm lg:h-24 lg:w-24 xl:h-28 xl:w-28">
									</div>
									<div class="flex flex-col">
										<div class="flex items-center w-full space-x-3 text-sm">
											<button class="font-normal text-white btn tt bg-primary hover:bg-secondary" type="submit">Upload
												Image</button>
											<button type="button" class="px-6 font-normal btn tt border-primary text-primary hover:bg-gray-200"
												wire:click="resetImage" @click="src = '/img/avatar.png'">Reset</button>
										</div>
										<p class="pt-2 w-60">
											@if ($errors->any())
												@error('image')
													<span class="w-24 text-sm leading-tight text-red-600" style="line-height: 0px">{{ $message }}</span>
												@enderror
											@else
												<span class="line max-w-[200px] leading-tight" style="line-height: 0px">Image allowed
													png,jpeg,
													jpg</span>
											@endif
										</p>
									</div>
								</div>
							</form>
							<div class="w-full space-y-4">
								<h1 class="pb-4 text-2xl font-semibold border-b">Personal Information</h1>
								<x-update-form>
									<x-input label="First Name*" name="first_name" type="text" wire:model.defer="first_name" />
									<x-input label="Last Name*" name="last_name" type="text" wire:model.defer="last_name" />
									<x-form.gender />
									<x-form.dob wire:model.defer="dob" name="dob" label="Age" />
									<x-input label="Phone" name="phone" type="text" wire:model.defer="phone" />
									<x-input label="Email" name="email" type="text" wire:model.defer="email" />
								</x-update-form>
							</div>
						</div>
					@endif
					{{-- @elseif($profile === 'bio')
            <div class="w-full">
              <div class="w-full space-y-4">
                <h1 class="pb-4 text-2xl font-semibold border-b">Student Bio-Data</h1>
                <div class="w-full space-y-4">
                  <form wire:submit.prevent="updateBio" class="flex flex-col justify-center w-full gap-8">
                    <div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-2">
                      <x-clas-select />
                      <x-input label="Blood Broup*" name="blood" type="text" wire:model.defer="blood" />
                      <x-select :options="$faith" label="Religion*" name="religion" wire:model.defer="religion" />
                      <x-select label="disability" :options="$disabilities" name="disability"
                        wire:model.defer="disability" />
                      <x-form.checkbox :options="$options" />
                      <label
                        class="w-full py-6 text-center border-2 border-dashed rounded-lg border-grey-500 lg:col-span-2"
                        for='image'>
                        <div class="flex flex-col justify-center mx-auto">
                          <span class="block mx-auto">
                            <svg class="w-20 h-12 2xl:h-[100] 2xl:w-[132]" viewBox="0 0 175 143" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M98.375 22.5L76.625 0.75H0.5V142.125H174.5V22.5H98.375ZM87.5 60.5625L125.562 98.625H98.375V142.125H76.625V98.625H49.4375L87.5 60.5625Z"
                                fill="#000B17" />
                            </svg>
                          </span>
                          <label for="image" class="mx-auto mt-4 text-center max-w-max">Drag and drop or <span
                              class="cursor-pointer text-primary hover:text-secondary">browse</span>
                            files
                          </label>
                          @error('result')
                            <span class="text-red-500">{{ $message }}</span>
                          @enderror
                        </div>
                        <input id="image" type="file" name="result" wire:model.defer="result"
                          class="hidden">
                      </label>

                    </div>
                    <button type="submit"
                      class="px-16 mx-auto text-sm font-normal hover:bg-dark tt max-w-max btn btn-lg submit-primary">Save
                      and
                      Continue</button>
                  </form>
                </div>
              </div>
            </div>
          @else
            <div class="w-full" x-show="profile == 'auth'">
              <x-form.update-password :student="$student">

              </x-form.update-password>
            </div>
          @endif --}}
				</div>
			</div>
		</div>
	</div>
</div>
