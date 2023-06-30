<div class="grid w-full gap-6 py-8 lg:py-12">
	{{-- alert notification --}}
	@if (session('success'))
		<x-alert type="success" :message="session('success')">
			<i class="text-3xl bi bi-check2-circle"></i>
		</x-alert>
	@elseif (session('error'))
		<x-alert type="error" :message="session('error')">
			<i class="text-3xl bi bi-check2-circle"></i>
		</x-alert>
	@else
	@endif

	{{-- fixed header --}}
	<header class="flex flex-col w-full gap-6 bg-background">
		{{-- headers links with numbers of subjects both total and active --}}
		<div class="flex flex-wrap items-center justify-between w-full">
			<h1 class="text-3xl font-semibold capitalize text-primary">Roles</h1>
			<div class="flex flex-col -space-y-2 text-gray-500">
				<p class="">Total Roles:
					<strong class="text-dark">{{ \App\Models\Role::count() }}</strong>
				</p>
				<p class="">Total Users:
					<strong class="text-dark">{{ \App\Models\User::count() - 1 }}</strong>
				</p>
				<p class="">Users with Roles:
					<strong class="text-dark">{{ \App\Models\User::has('roles')->count() - 1 }}</strong>
				</p>
			</div>
		</div>

		{{-- buttons --}}
		<div class="flex items-center justify-between">
			<div class="flex items-center space-x-6">
				<div>
					<form wire:submit.prevent='addRole' class="flex items-start justify-start gap-2 lg:gap-4">
						<div class="w-[150px]">
							<x-input label="User ID*" name="school_id" class="w-full" type="text" wire:model.defer="school_id" />
						</div>
						<x-form.role-select />
						<button
							class="font-normal border-2 btn submit-secondary tt max-w-max whitespace-nowrap hover:border-dark hover:bg-dark">Assign
							Role</button>
					</form>
				</div>
			</div>

			{{-- right side --}}
			<div class="flex items-center space-x-6">
				<x-search name="users" />
			</div>
		</div>
	</header>

	{{-- tables --}}
	<div class="w-full px-4 pb-4 overflow-x-auto bg-white rounded-lg shadow-sm">
		@if ($users->count() > 0)
			<table class="w-full space-y-2 overflow-x-auto whitespace-nowrap">
				<thead class="w-full pb-4 text-xl border-b">
					<tr class="z-10">
						<td></td>
						<th class="items-center p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
							<span class="">Users</span>

						</th>
						<th class="w-1/2 p-2 text-left transition duration-300 transform cursor-pointer hover:text-primary">
							<span class="">Roles</span>
						</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="w-full overflow-x-auto break-normal bg-white">
					@forelse ($users as $user)
						@if ($user->id === 1)
							@continue
						@endif
						<tr class="capitalize bg-white border-y">
							<td>{{ $loop->iteration - 1 }}</td>
							<td class="p-2 capitalize">
								<p class="">{{ $user->title . ' ' . $user->first_name . ' ' . $user->last_name }}</p>
								<p class="text-sm font-medium text-gray-500">
									{{ $user->school_id }}
								</p>
							</td>

							<td class="p-2 capitalize">
								<div class="flex flex-wrap items-center space-x-4">
									@forelse ($user->roles as $index => $role)
										<button wire:click="deleteRole({{ $role->id }}, {{ $user->id }})"
											class="relative px-3 py-2 text-sm capitalize rounded-lg shadow-sm tt border-primary bg-primary-light text-primary">
											<span class="">{{ $role->name }}</span>
											<span class="cursor-pointer hover:text-red-600"><i class="bi bi-x-lg"></i></span>
										</button>
									@empty
										<p class="font-medium text-gray-500">No role assign yet, kindly add one with the above form</p>
									@endforelse
								</div>
							</td>

							<td class="flex justify-end p-2 whitespace-nowrap">
								<button wire:click="revokeAll({{ $user->id }})" x-data="{ show: false }" @mouseenter="show = true"
									@mouseleave="show = false"
									class="relative px-4 py-2 text-sm font-normal capitalize rounded-lg btn btn-primary">
									Revoke All
								</button>
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
					{{ $users->links() }}
				</x-per-page>
			</div>
		@else
			<x-empty-table comment="There is no user with a role. Assign role to a user with the form above" title="Role">
				<p class="max-w-xs text-center">There is no user with a role. Assign role to a user with the form above
				</p>
			</x-empty-table>
		@endif
	</div>
</div>
