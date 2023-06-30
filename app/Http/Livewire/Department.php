<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Models\Department as ModelDepartment;
use App\Notifications\HodAssignmentNotification;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Department extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];


    public $name, $user_id, $cid;
    public $balance = 0;
    public $update = false;
    public $form = false;
    public $selectedRole = null;
    public ?array $checked = [];
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';
    public $selectPage = false;

    function add()
    {
        $this->update = false;
    }

    function showForm()
    {

        $this->refreshInputs();
        $this->form = true;
    }

    protected $messages = [
        'user_id.unique' => 'Staff already assigned as hod of another department',
        'name.unique' => 'Department already exist',
    ];

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
        $this->user_id = '';
        $this->cid = '';
        $this->update = false;
        $this->form = false;
    }
    function save()
    {
        $data = $this->validate([
            'name' => ['required', 'unique:departments,name'],
            'user_id' => ['nullable', 'unique:departments,user_id'],
        ]);

        $assign = '';
        $department = ModelDepartment::create($data);
        if ($department) {
            if ($data['user_id']) {
                $user = User::find($data['user_id']);
                $user->notify(new HodAssignmentNotification($department));
                $assign = ', and ' . $user->first_name . ' has been assigned to be the Head of Department';
            }
            $this->refreshInputs();
            session()->flash('success', 'Department created successfully' . $assign);
        }

        return redirect()->back();
    }

    function edit(ModelDepartment $department)
    {
        $this->form = true;
        $this->update = true;
        $this->cid = $department->id;
        $this->name = $department->name;
        $this->user_id = $department->user_id;
    }

    function update()
    {
        $cid = $this->cid;
        $department = ModelDepartment::find($cid);

        $data = $this->validate([
            'name' => ['required', 'unique:departments,name,' . $department->id],
            'user_id' => ['nullable', 'unique:departments,user_id,' . $department->id],
        ]);

        if ($this->user_id === NULL || gettype($this->user_id) == '') {
            $this->user_id = NULL;
        }

        $true = ModelDepartment::find($cid)->update([
            'name' => $this->name,
            'user_id' => $this->user_id,
        ]);
        if ($true) {
            // $this->dispatchBrowserEvent('swal:success', [
            //     'icon' => 'success',
            //     'text' => 'department record updated',
            //     'title' => 'Updated Successfully',
            //     'timer' => 3000,
            // ]);
            session()->flash('success', 'department record updated');
        }
        $this->refreshInputs();
    }

    public function confirmDelete($id)
    {
        $department = ModelDepartment::findOrFail($id);
        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    // colored each seleted rows
    function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    public function delete()
    {

        $department = ModelDepartment::with('user')->findOrFail($this->delete);
        $true = $department->delete();

        if ($true) {
            session()->flash('success', strtoupper($department->name) . ' has been deleted from department');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        return redirect()->back();
    }
    // confirmation of multiple delete
    function deleteMutiple()
    {
        // $checked = $this->checked;
        $this->dispatchBrowserEvent('swal:multiple');
    }

    // buck delete
    function buckDelete()
    {
        $deparments = ModelDepartment::findMany($this->checked);
        $true = $deparments->each->delete();

        if ($true) {
            session()->flash('success', count($this->checked) . ' Department  deleted successfully');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        return redirect()->back();
    }


    public function render()
    {
        // $hods = User::whereRelation('roles', 'name', 'LIKE', '%hod%')->select(['first_name', 'id', 'last_name'])->get();
        $term = "%$this->search%";
        $departments = ModelDepartment::with(['user'])
            ->where('name', 'LIKE', $term)
            ->orWhereHas('user', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('first_name', 'LIKE', $term)
                    ->orWhere('last_name', 'LIKE', $term)
                    ->orWhere('school_id', 'LIKE', $term);
            })->latest()
            ->paginate($this->perPage);
        return view('livewire.department', compact(['departments']))->layout('layouts.dashboard');
    }
}