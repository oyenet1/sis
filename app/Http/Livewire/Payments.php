<?php

namespace App\Http\Livewire;

use App\Models\Fee;
use App\Models\Finance;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\PaymentExport;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class Payments extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];


    public $status, $fee_id, $student_id, $method_id,  $cid;
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
        $this->method_id = '';
        $this->status = '';
        $this->student_id = '';
        $this->fee_id = '';
        $this->cid = '';
        $this->showForm();
    }

    public function confirmDelete($id)
    {

        $Payment =   Payment::find($id);

        if ($Payment->payments->count()) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'warning',
                'text' => ucfirst('The Payment already had payment'),
                'title' => 'Deleting Not Allowed',
                'timer' => 4000,
            ]);
        } else {
            $user = Payment::findOrFail($id);

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
        $payments = $this->validate([
            'method_id' => ["required", Rule::notIn(['select', '', null])],
            'student_id' => ["required", Rule::notIn(['select', '', null])],
            'status' => ['nullable'],
            'fee_id' => ["required", Rule::notIn(['select', '', null])],
        ]);
        $payments['status'] = 'processing';
        $true = Payment::create($payments);
        $description = $true->fee->type . ' paid for ' . $true->student->first_name . ' ' . $true->student->last_name;
        $addIncome = addPaymentToFinance($true->fee->amount, $description); //add payment to finace

        if ($addIncome) {
            $true->update(['status' => 'successful']);
            $true->fee->increment('total', $true->fee->amount);


            $this->refreshInputs();
            $this->form = false;
            $this->update = false;

            session()->flash('success', 'Payment Recorded successfully');
        }

        return redirect()->back();
    }

    function addPaymentToFinance($amount, $description)
    {
        $finance = Finance::latest()->first();
        $lastBalance = $finance->balance ?? 0;

        $finance = [
            'amount' => $amount,
            'balance' => $lastBalance + $amount,
            'description' => $description,
            'type' => 'income',
            'date' => Carbon::now(),
        ];

        return Finance::create($finance);
    }

    protected $messages = [
        'fee_id.required' => 'Invalid Selection: Select what you are paying for',
        'student_id.required' => 'Pls select the student you are paying for',
        'method_id.required' => 'Invalid method, Select your payment method',
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
        $Payments = Payment::findMany($this->checked);

        if ($Payments->payments->count()) {

            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'warning',
                'text' => 'One or more of the selected records already has payment',
                'title' => 'Bulk Not Allowed',
                'timer' => 4000,
                'button' => false,
            ]);
        } else {
            $true = $Payments->each->delete();

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
        $Payment =  Payment::find($id);

        if ($Payment->method->count()) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'warning',
                'text' => 'You can only edit Payments without payment',
                'title' => 'Editing Not Allowed',
                'timer' => 4000,
                'button' => false,
            ]);
        } else {
            $Payment = Payment::findOrFail($id);
            $this->form = true;
            $this->cid = $Payment->id;
            $this->update = true;
            $this->method_id = $Payment->method_id;
            $this->student_id = $Payment->student_id;
            $this->fee_id = $Payment->fee_id;
            $this->status = $Payment->status;
        }
    }

    function update()
    {
        $cid = $this->cid;

        $Payment = $this->validate([
            'method_id' => 'required|numeric|min:1|max:10000000',
            'student_id' => "nullable",
            'type' => ['required', Rule::notIn(['select', 'select type', 'type'])],
            'fee_id' => "nullable",
        ]);
        $true = Payment::find($cid)->update($Payment);
        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Payment record updated',
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

        $Payment = Payment::findOrFail($this->delete);

        $true = $Payment->delete();

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Payment has been removed',
                'title' => 'Deleted',
                'timer' => 3000,
            ]);
        }
        $this->checked = [];
        $this->update = false;
    }
    // selected all Payments
    function getPaymentsProperty()
    {
        return Payment::search(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
    }

    function updatedSelectPage($value)
    {
        // dd($value);
        if ($value) {
            $this->checked = $this->Payments->pluck('id')->toArray();
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
    //     return Excel::download(new PaymentExport($this->checked), 'Payments.pdf');
    // }

    // export pdf
    function exportPDF(string $name = "Payment")
    {
        $viewData = Payment::whereKey($this->checked)->latest()->get();
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
        $pdfContent = $load->loadView('reports.Payment', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$name" . '-' . date('d-m-Y') . ".pdf"
        );

        redirect()->back();
    }

    // export excel
    function exportCSV()
    {
        return Excel::download(new PaymentExport($this->checked), 'Payments-' . date('d-m-y') . '.xlsx');
    }

    public function render()
    {
        $payments = $this->payments;
        return view('livewire.payments', compact(['payments']))->layout('layouts.dashboard');
    }
}