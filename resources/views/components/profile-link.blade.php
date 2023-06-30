<div class="p-0 m-0 space-y-1">
	<a href="{{ route('students.profile', [$student->guardian->first_name, $student->last_name]) }}"
		:class="profile == 'personal' ? 'bg-primary-light' : 'bg-transparent'"
		class="flex items-center justify-between w-full p-3 font-medium rounded-lg cursor-pointer text-primary">
		<button>Personal Information</button>
		<span
			class="{{ ($student->phone || $student->email) && $student->updated_at > $student->created_at ? '' : 'hidden' }}">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-lg"
				viewBox="0 0 16 16">
				<path
					d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
			</svg>
		</span>
	</a>
	<a href="{{ route('students.biodata', [$student->last_name]) }}"
		:class="profile == 'bio' ? 'bg-primary-light' : 'bg-transparent'"
		class="flex items-center justify-between w-full p-3 font-medium capitalize rounded-lg cursor-pointer text-primary">
		<button class="capitalize">Student bio-data</button>
		<span class="{{ $student->clas || $student->blood ? '' : 'hidden' }}">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-lg"
				viewBox="0 0 16 16">
				<path
					d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
			</svg>
		</span>
	</a>

	{{-- @if ($student->clas && ($student->clas->school->short == 'sss' || $student->clas->school->short == 'jss'))
		<div @click="profile = 'auth'" :class="profile == 'auth' ? 'bg-primary-light' : 'bg-transparent'"
			class="flex items-center justify-between w-full p-3 font-medium capitalize rounded-lg cursor-pointer text-primary">
			<button class="capitalize">Authentication</button>
			@if ($student->studentAccount && $student->studentAccount->email_verified_at)
				<span>
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-lg"
						viewBox="0 0 16 16">
						<path
							d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
					</svg>
				</span>
			@endif
		</div>
	@endif --}}
</div>
