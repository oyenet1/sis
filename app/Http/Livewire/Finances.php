<?php

namespace App\Http\Livewire;

use App\Models\Finance;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\PDF;
use Livewire\WithPagination;
use App\Exports\FinanceExport;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class Finances extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];


    public $amount, $date, $description, $image, $type,  $cid;
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
        $this->amount = '';
        $this->type = '';
        $this->description = '';
        $this->image = '';
        $this->balance = '';
        $this->date = '';
        $this->cid = '';
        $this->showForm();
    }

    public function confirmDelete($id)
    {

        $last =   \App\Models\Finance::latest()->first();
        $current =   \App\Models\Finance::find($id);

        if ($last->id !== $current->id) {
            // session()->flash('error', 'You can only edit or delete the last records');
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'error',
                'text' => 'You can only edit or delete the last records',
                'title' => 'Not Allowed',
                'timer' => 3000,
            ]);
        } else {
            $user = Finance::findOrFail($id);

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
        $finances = $this->validate([
            'amount' => 'required|numeric|min:1|max:10000000',
            'description' => 'required|min:10|max:2500',
            'image' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg',
            'type' => ['required', Rule::notIn(['select', 'select type'])],
            'date' => "required|date|before_or_equal:today",
        ]);

        $current = Finance::latest()->first();
        $currentBalance = $current->amount ?? 0;
        $lastBalance = $current->balance ?? 0;

        if ($this->image != null) {
            $finances['image'] = $this->image->storePublicly('finances');
        }

        if ($this->type == 'income') {
            $finances['balance'] = $lastBalance + $this->amount;
        } else {
            $finances['balance'] = $lastBalance - $this->amount;
        }

        $true = Finance::create($finances);

        if ($true) {
            $this->refreshInputs();
            $this->form = false;
            $this->update = false;

            session()->flash('success', 'Amount recorded successfully');
        }

        return redirect()->back();
    }

    protected $rules = [
        'amount' => 'required|interger|min:1|max:10000000',
        'description' => 'required|min:10|max:2500',
        'image' => 'nullable|mimes:pdf,doc,docx,png.jpg,jpeg',
        'type' => "required|Rule::notIn(['select', 'select type'])",
        'date' => "required|date|before:tomorrow",
    ];

    protected $messages = [
        'type.required' => "Invalid selection! Kindly select Income or expenses",
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
        $finances = Finance::findMany($this->checked);
        $true = $finances->each->delete();

        if ($true) {
            session()->flash('success', count($this->checked) . ' records  deleted successfully');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        return redirect()->back();
    }

    function edit($id)
    {
        $last =   \App\Models\Finance::latest()->first();
        $current =   \App\Models\Finance::find($id);

        if ($last->id !== $current->id) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'warning',
                'text' => 'You can only edit or delete the last records',
                'title' => 'Not Allowed',
                'timer' => 3000,
                'button' => false,
            ]);
        } else {
            $finance = Finance::findOrFail($id);
            $this->form = true;
            $this->cid = $finance->id;
            $this->update = true;
            $this->amount = $finance->amount;
            $this->date = $finance->date;
            $this->balance = $finance->balance;
            $this->type = $finance->type;
            $this->description = $finance->description;
        }
    }

    function update()
    {
        $cid = $this->cid;

        $finance = $this->validate([
            'amount' => 'required|numeric|min:1|max:10000000',
            'description' => 'required|min:10|max:2500',
            'image' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg',
            'type' => ['required', Rule::notIn(['select', 'select type'])],
            'date' => "required|date|before_or_equal:today",
        ]);
        $true = Finance::find($cid)->update($finance);
        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'finance record updated',
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

        $finance = Finance::findOrFail($this->delete);

        $true = $finance->delete();

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'finance has been removed',
                'title' => 'Deleted',
                'timer' => 3000,
            ]);
        }
        $this->checked = [];
        $this->update = false;
    }
    // selected all finances
    function getfinancesProperty()
    {
        return Finance::search(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
    }

    function updatedSelectPage($value)
    {
        // dd($value);
        if ($value) {
            $this->checked = $this->finances->pluck('id')->toArray();
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
    //     return Excel::download(new FinanceExport($this->checked), 'finances.pdf');
    // }

    // export pdf
    function exportPDF(string $name = "Finance")
    {
        $viewData = Finance::whereKey($this->checked)->latest()->get();
        $data = $viewData->toArray();

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);

        $load = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $load->getDomPDF()->setHttpContext($context);
        $pdfContent = $load->loadView('reports.finance', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$name" . '-' . date('d-m-Y') . ".pdf"
        );

        redirect()->back();
    }

    // export excel
    function exportCSV()
    {
        return Excel::download(new FinanceExport($this->checked), 'finances-' . date('d-m-y') . '.xlsx');
    }

    public function render()
    {
        $finances = $this->finances;
        return view('livewire.finances', compact(['finances']))->layout('layouts.dashboard');
    }
}