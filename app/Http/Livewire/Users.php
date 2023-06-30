<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Exports\UserExport;
use App\Notifications\WelcomeMessage;
use Illuminate\Support\Facades\Notification;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Users extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];

    public $name, $email, $purpose, $phone,  $cid, $role, $password;

    public $update = false;
    public $form = false;

    public $selectedRole = null;
    public ?array $checked = [];
    public $perPage = 10;
    public $sortField = 'school_id';
    public $sortAsc = true;
    public $search = '';
    public $selectPage = false;

    function add()
    {
        $this->update = false;
    }

    function showForm()
    {
        $this->form = true;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'selected', 'checked']);
    }

    // sorting column
    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    function refreshInputs()
    {
        $this->name = '';
        $this->role = '';
        $this->phone = '';
        $this->email = '';
        $this->password = '';
        $this->cid = '';
    }

    public function confirmDelete($id)
    {

        $user = User::findOrFail($id);

        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    // colored each seleted rows
    function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    function save()
    {
        $users = $this->validate([
            'name' => ['required', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'numeric', 'unique:users,phone', 'digits:10', 'starts_with:9,8,7'],
            'password' => ['nullable', 'min:6', 'max:25'],
            'role' => ['required', 'not_in:select'],
        ]);

        $user = User::create(array_merge($users, [
            $users['role'] => null //role properties remove fromu users since the column donot exits
        ]));

        $user->attachRole($this->role); //role assignment
        $this->refreshInputs();

        if ($user) {
            $this->refreshInputs();
            $this->form = false;
            $this->update = false;

            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'User Added Successfully',
                'title' => 'Added',
                'timer' => 3000,
            ]);
        }
        // send welcome message
        Notification::send($user, new WelcomeMessage($user));
    }

    protected $messages = [
        'phone.digits' => "The phone number must be ten digit, by omitting the first zero",
        'phone.required' => "Telephone number cannot be empty",
        'role.required' => "Invalid selection, select a valid user role"
    ];

    // confirmation of multiple delete
    function deleteMutiple()
    {
        $checked = $this->checked;
        $this->dispatchBrowserEvent('swal:multiple');
    }

    // buck delete
    function buckDelete()
    {
        $users = User::findMany($this->checked);
        $true = $users->each->delete();

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'users has been removed from records',
                'title' => 'users deleted',
                'timer' => 3000,
            ]);
        }
        $this->refreshInputs();
        $this->checked = [];
        $this->update = false;
    }

    public function delete()
    {

        $user = User::findOrFail($this->delete);

        $true = $user->delete();

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'user has been removed',
                'title' => 'Deleted',
                'timer' => 3000,
            ]);
        }
        $this->checked = [];
        $this->update = false;
    }
    // selected all users
    function getUsersProperty()
    {
        return User::with(['roles', 'profile'])->user(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
    }

    function updatedSelectPage($value)
    {
        // dd($value);
        if ($value) {
            $this->checked = $this->users->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
    }

    //
    function updatedChecked()
    {
        $this->selectPage = false;
    }

    // export table
    function exportPDF()
    {
        return Excel::download(new UserExport($this->checked), 'users.pdf');
    }

    // export excel
    function exportCSV()
    {
        return Excel::download(new UserExport($this->checked), 'users-' . date('d-m-y') . '.xlsx');
    }
    public function render()
    {
        $users = $this->users;
        return view('livewire.users', compact(['users']))->layout('layouts.dashboard');
    }
}