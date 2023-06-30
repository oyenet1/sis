<div class="w-full">
	<div class="flex flex-col w-full gap-6 py-8 lg:py-12">
		{{-- alert notification --}}
		@if (session('success'))
			<x-alert type="success" :message="session('success')">
				<i class="text-3xl bi bi-check2-circle"></i>
			</x-alert>
		@endif
		<div class="w-full p-0 mx-auto space-y-8 max-w-7xl xl:w-11/12 xl:space-y-12 2xl:w-3/4" x-data="{ profile: @entangle('profile').defer }">
			<div class="flex items-center justify-between">
				<h1 class="text-3xl font-semibold capitalize text-primary">Profile Setting</h1>
				<a href="{{ route('students.profile', [$student->guardian->first_name, $student->last_name]) }}"
					class="px-8 text-sm font-normal btn btn-primary">Back</a>
			</div>
			<div class="flex gap-8 overflow-x-auto">
				<div class="w-100 w-[250px] rounded-lg p-4 lg:w-72 2xl:w-80">
					{{-- profile navigation --}}
					<x-profile-link :student="$student" />
				</div>
				<div class="flex flex-col flex-1 rounded-lg">
					@if ($profile === 'bio')
						<div class="w-full">
							<div class="w-full space-y-4">
								<div class="flex justify-between">
									<h1 class="pb-4 text-2xl font-semibold border-b">Student Bio-Data</h1>
									@if (!$student->user_id &&
									    $student->clas &&
									    ($student->clas->school->short == 'jss' || $student->clas->school->short == 'sss'))
										<button wire:click="createAccountForStudent"
											class="px-6 py-2 text-sm font-normal text-center text-white capitalize rounded-lg cursor-pointer tt bg-secondary hover:bg-primary">
											create
											login
											account</button>
									@endif
								</div>
								<div class="w-full space-y-4">
									<form wire:submit.prevent="updateBio" class="flex flex-col justify-center w-full gap-8">
										<div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-2">
											<x-clas-select />
											<x-input label="Blood Broup*" name="blood" type="text" wire:model="blood" />
											<x-form.faith-select wire:model="religion" />
											<x-form.disability-select wire:model="disability" />
											<x-form.checkbox :options="$options" />
											{{-- <label
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
                        <input id="image" type="file" name="result" wire:model.defer="result" class="hidden">
                      </label> --}}
											@error('result')
												<span class="text-sm text-red-600">{{ $message }}</span>
											@enderror
										</div>
										<button type="submit"
											class="px-16 mx-auto text-sm font-normal tt btn btn-lg submit-primary max-w-max hover:bg-dark">Save
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
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
