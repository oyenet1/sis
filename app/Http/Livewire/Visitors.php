<?php

namespace App\Http\Livewire;

use App\Exports\VisitorExport;
use Carbon\Carbon;
use App\Models\Visitor;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Visitors extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];

    public $name, $entered_at, $purpose, $left_at, $phone,  $cid;

    public $update = false;
    public $form = false;

    public ?array $selected;
    public ?array $checked = [];
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';

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
        $this->purpose = '';
        $this->phone = '';
        $this->entered_at = '';
        $this->left_at = '';
        $this->cid = '';
    }

    public function confirmDelete($id)
    {

        $visitor = Visitor::findOrFail($id);

        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }


    public function edit($id)
    {

        $visitor = Visitor::findOrFail($id);

        $this->cid = $visitor->id;
        $this->role = $visitor->role;
        $this->name = $visitor->name;
        $this->dob = $visitor->dob;
        $this->date_employed = $visitor->date_employed;
        $this->birth = $visitor->birth;
        $this->update = true;
        $this->dispatchBrowserEvent('showModal');
    }

    // colored each seleted rows
    function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    // validation


    protected $rules = [
        'name' => 'required',
        'purpose' => 'required',
        'phone' => 'required|digits:10',
        // 'entered_at' => 'nullable|time|before_or_equal:today',
        // 'left_at' => 'nullable|time|before_or_equal:today',
    ];

    function left($id)
    {
        $visitor = Visitor::find($id);

        $true = $visitor->update([
            'left_at' => Carbon::now()->addHour()
        ]);

        if ($true) {
            $this->refreshInputs();
            $this->form = false;
            $this->update = false;

            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Visitor has sign-out at ' . Carbon::now()->format('H:i A'),
                'title' => 'Left',
                'timer' => 5000,
            ]);
        }
    }


    function save()
    {
        $visitors = $this->validate();
        $visitors['entered_at'] = Carbon::now()->addHour();

        $true = Visitor::create($visitors);

        if ($true) {
            $this->refreshInputs();
            $this->form = false;
            $this->update = false;

            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Visitor Added Successfully at ' . Carbon::now()->format('H:i A'),
                'title' => 'Added',
                'timer' => 3000,
            ]);
        }
    }

    protected $messages = [
        'phone.digits' => "The phone number must be ten digit, by omitting the first zero",
        'phone.required' => "Telephone number cannot be empty"
    ];

    function update()
    {

        $cid = $this->cid;
        $visitor = $this->validate();

        $true = Visitor::find($cid)->update($visitor);

        $this->update = false;
        $this->refreshInputs();
        $this->dispatchBrowserEvent('closeModal');

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'visitor Updated Successfully',
                'title' => 'Updated',
                'timer' => 3000,
            ]);
        }
    }

    // confirmation of multiple delete
    function deleteMutiple()
    {
        $checked = $this->checked;
        $this->dispatchBrowserEvent('swal:multiple');
    }

    // buck delete
    function buckDelete()
    {
        $visitors = Visitor::findMany($this->checked);
        $true = $visitors->each->delete();

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Visitors has been removed from records',
                'title' => 'Visitors deleted',
                'timer' => 3000,
            ]);
        }
        $this->refreshInputs();
        $this->checked = [];
        $this->update = false;
    }

    public function delete()
    {

        $visitor = Visitor::findOrFail($this->delete);

        $true = $visitor->delete();

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Visitor has been removed',
                'title' => 'Deleted',
                'timer' => 3000,
            ]);
        }
        $this->checked = [];
        $this->update = false;
    }

    // export table
    function exportPDF()
    {
        return Excel::download(new VisitorExport($this->checked), 'visitors.pdf');
    }

    // export excel
    function exportCSV()
    {
        return Excel::download(new VisitorExport($this->checked), 'visitors-' . date('d-m-y') . '.xlsx');
    }
    public function render()
    {
        // $search = '%' . $this->search . '%';
        // $visitors = Visitor::where('name', 'LIKE', $search)->orWhere('purpose', 'LIKE', $search)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->withCasts(['left_at' => 'datetime:H:i: A'])->paginate($this->perPage);

        $visitors = Visitor::visitor(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
        return view('livewire.visitors', compact(['visitors']))->layout('layouts.dashboard');
    }
}