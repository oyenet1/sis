<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class Roles extends Component
{
    use WithPagination;
   
    protected $listeners = [
        'deleteConfirm' => 'delete',
    ];

    public $name, $display_name, $description,  $cid;
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';

    function add()
    {
        $this->update = false;
    }
    public function sortBy($field)
    {
        if ($this->sortField == $field) {
           $this->sortAsc = ! $this->sortAsc;
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
        $this->display_name = '';
        $this->name = '';
        $this->description = '';
        $this->cid = '';
    }


    public function render()
    {
        $search = '%' . $this->search . '%';
        $roles = Role::with(['users'])->where('name', 'LIKE', $search)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->paginate($this->perPage);
        return view('livewire.roles', compact(['roles']));
    }
}
