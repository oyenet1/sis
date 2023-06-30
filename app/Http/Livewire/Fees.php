<?php

namespace App\Http\Livewire;

use App\Models\Fee;
use App\Models\Term;
use Livewire\Component;
use App\Exports\FeeExport;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class Fees extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];


    public $amount, $clas_id, $term_id, $type,  $cid;
    public $update = false;
    public $form = false;

    public $selectedRole = null;
    public ?array $checked = [];
    public $perPage = 25;
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
        $this->form = true;
    }
    function sortField($field)
    {
        // $this->sortField = $field;
        dd($field);
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
        $this->amount = '';
        $this->type = '';
        $this->term_id = '';
        $this->clas_id = '';
        $this->cid = '';
        $this->showForm();
    }

    public function confirmDelete($id)
    {

        $fee =   Fee::find($id);

        if ($fee->payments->count()) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'warning',
                'text' => ucfirst('The fee already had payment'),
                'title' => 'Deleting Not Allowed',
                'timer' => 4000,
            ]);
        } else {
            $user = Fee::findOrFail($id);

            $this->delete = $id;
            $this->dispatchBrowserEvent('swal:confirm');
        }
    }

    // colored each seleted rows
    function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    function save()
    {
        $fees = $this->validate([
            'amount' => 'required|numeric|min:1|max:10000000',
            'term_id' => ["nullable", Rule::notIn(['select', 'select type', 'term'])],
            'type' => ['required', Rule::notIn(['select', 'select type', 'type'])],
            'clas_id' => ["nullable", Rule::notIn(['select', 'select type', 'type'])],
        ]);

        if (!$fees['term_id']) {
            $fees['term_id'] = Term::latest()->first()->id;
        }

        $true = Fee::create($fees);

        if ($true) {
            $this->refreshInputs();
            $this->form = false;
            $this->update = false;

            session()->flash('success', 'Fee Recorded successfully');
        }

        return redirect()->back();
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
        $fees = Fee::findMany($this->checked);

        if ($fees->payments->count()) {
            // dd($fees);
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'warning',
                'text' => 'One or more of the selected records already has payment',
                'title' => 'Bulk Not Allowed',
                'timer' => 4000,
                'button' => false,
            ]);
        } else {
            $true = $fees->each->delete();

            if ($true) {
                session()->flash('success', count($this->checked) . ' records  deleted successfully');
            }
            $this->resetPage();
            $this->checked = [];
            $this->update = false;
            $this->search = '';
        }

        return redirect()->back();
    }

    function edit($id)
    {
        $fee =  Fee::find($id);

        if ($fee->payments->count()) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'warning',
                'text' => 'You can only edit fees without payment',
                'title' => 'Editing Not Allowed',
                'timer' => 4000,
                'button' => false,
            ]);
        } else {
            $fee = Fee::findOrFail($id);
            $this->form = true;
            $this->cid = $fee->id;
            $this->update = true;
            $this->amount = $fee->amount;
            $this->term_id = $fee->term_id;
            $this->clas_id = $fee->clas_id;
            $this->type = $fee->type;
        }
    }

    function update()
    {
        $cid = $this->cid;

        $fee = $this->validate([
            'amount' => 'required|numeric|min:1|max:10000000',
            'term_id' => "nullable",
            'type' => ['required', Rule::notIn(['select', 'select type', 'type'])],
            'clas_id' => "nullable",
        ]);
        $true = Fee::find($cid)->update($fee);
        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'fee record updated',
                'title' => 'Updated Successfully',
                'timer' => 3000,
            ]);
        }
        $this->refreshInputs();
        $this->checked = [];
        $this->update = false;
        $this->form = false;
    }

    public function delete()
    {

        $fee = Fee::findOrFail($this->delete);

        $true = $fee->delete();

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'fee has been removed',
                'title' => 'Deleted',
                'timer' => 3000,
            ]);
        }
        $this->checked = [];
        $this->update = false;
    }
    // selected all fees
    function getfeesProperty()
    {
        return Fee::with(['clas.school', 'term.sesion', 'payments'])->search(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
    }

    function updatedSelectPage($value)
    {
        // dd($value);
        if ($value) {
            $this->checked = $this->fees->pluck('id')->toArray();
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
    // function exportPDF()
    // {
    //     return Excel::download(new FeeExport($this->checked), 'fees.pdf');
    // }

    // export pdf
    function exportPDF(string $name = "Fee")
    {
        $viewData = Fee::whereKey($this->checked)->latest()->get();
        $data = $viewData->toArray();
        dd($data);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);

        $load = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $load->getDomPDF()->setHttpContext($context);
        $pdfContent = $load->loadView('reports.fee', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$name" . '-' . date('d-m-Y') . ".pdf"
        );

        redirect()->back();
    }

    function say($data)
    {
        dd($data);
    }

    // export excel
    function exportCSV()
    {
        return Excel::download(new FeeExport($this->checked), 'fees-' . date('d-m-y') . '.xlsx');
    }

    public function render()
    {
        $fees = $this->fees;
        return view('livewire.fees', compact(['fees']))->layout('layouts.dashboard');
    }
}