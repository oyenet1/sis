<?php

namespace App\Http\Livewire;

use App\Models\Guardian;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Guard extends Component
{
    public $school_id, $role_id, $cid;
    public $search = '';

    public $role, $user;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'revokeConfirm' => 'revoke',
        'revokeRole' => 'removeSingleRole',
        'deleteMutipleConfirm' => 'buckDelete'
    ];

    function refreshInputs()
    {
        $this->school_id = '';
        $this->role_id = '';
        $this->role = '';
        $this->user = '';
        $this->cid = '';
    }
    use WithPagination;
    public $perPage = 25;

    function addRole()
    {
        $data = $this->validate([
            'school_id' => ['required', 'exists:users,school_id'],
            'role_id' => ['required', Rule::notIn(['', null]),]
        ]);

        $user = User::where('school_id', $data['school_id'])->first();

        // add to guardian if a parent role is added
        if ($this->role_id == 10) {
            $this->addGuardian($user);
        }

        if (in_array(intval($data['role_id']), objectID($user->roles))) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'error',
                'text' => $user->first_name  . ' ' . $user->last_name . ' already assigned with this role',
                'title' => 'Role Denied',
                'timer' => 4000,
                'button' => false,
            ]);
        } else {
            $saved = $user->attachRole($this->role_id);
            try {
                if ($saved) {
                    session()->flash('success', $user->first_name . ' has been assigned to role');
                    $this->refreshInputs();
                }
            } catch (\Throwable $e) {
                dd($e->getMessage());
            }
        }
    }

    // remove single role warning
    function deleteRole(Role $role, User $user)
    {
        // $user = User::find($id);
        $this->role = $role;
        $this->user = $user;
        $this->dispatchBrowserEvent('swal:role');
    }

    // permanently removing single addRole 
    function removeSingleRole()
    {
        $this->user->roles()->detach($this->role->id);
        session()->flash('success', 'Priviledges removed successfully');
        $this->refreshInputs();
        $this->dispatchBrowserEvent('reload');
    }

    // remove all roles and priviledges
    public function revoke()
    {

        $user = User::with('roles')->findOrFail($this->delete);
        $true = $user->detachRoles($user->roles);

        if ($true) {
            session()->flash('success', 'All roles and priviledges has been removed');
        }
        $this->resetPage();
        $this->refreshInputs();
    }


    // remove all roles
    function revokeAll($id)
    {
        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:roles');
    }

    protected $messages = [
        'school_id.required' => 'Invalid users, only put the users id in the form field',
        'school_id.exist' => 'No users(staff, parents, students) found with the provided id',
        'role_id.required' => 'Invalid Role selected',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    function addGuardian($user)
    {
        $this->user = $user;
        $data = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'user_id' => $user->id,
            'email' => $user->email,
            'phone' => $user->phone,
        ];
        // $parent = Guardian::where('email', $this->user->email)->first();
        // if (!$parent) {
        // }

        Guardian::updateOrCreate(
            ['email' => $user->email],
            $data
        );
    }

    public function render()
    {
        $term = "%$this->search%";
        $users = User::with('roles')
            ->orWhere('first_name', 'LIKE', $term)
            ->orWhere('last_name', 'LIKE', $term)
            ->orWhereHas('roles', function (Builder $builder) use ($term) {
                $builder->where('name', 'like', $term);
            })
            ->orderBy('school_id')
            ->paginate($this->perPage);
        return view('livewire.guard', compact(['users']))->layout('layouts.dashboard');
    }
}