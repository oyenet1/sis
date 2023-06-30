<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Guardian;
use Livewire\WithPagination;
use App\Exports\ParentExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\WelcomeMessage;
use Illuminate\Database\Eloquent\Builder;

class Parents extends Component
{
    public $first_name, $last_name, $email, $address, $phone,  $cid, $title, $occupation;
    public $code = "+234";
    public $role = 'parent';

    // public User $parents;

    public $update = false;
    public $form = false;

    public $selectedRole = null;
    public ?array $checked = [];
    public $perPage = 25;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';
    public $selectPage = false;

    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];
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

    function refreshInputs()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->phone = '';
        $this->email = '';
        $this->code = "+234";
        $this->address = '';
        $this->occupation = '';
    }

    // protected $rules = [
    //     'first_name' => 'required',
    //     'last_name' => 'required',
    //     'email' => 'required|email|unique:users',
    //     'phone' => 'required|unique:users|numeric|digits_between:10,11',
    //     'role' => ['required', 'not_in:select,nurse,Nurse']
    // ];

    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'selected', 'checked']);
    }

    function save()
    {
        $data = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'nullable',
            'occupation' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users|numeric|digits_between:10,11',
            'title' => ['required', Rule::notIn(['select', '']),]
        ]);

        $this->phone = trimPhone($this->code, $this->phone); //function from helpers,


        $user = User::create($data);
        $assignedRole = $user->attachRole($this->role);
        if ($assignedRole) {
            $saved = $user->guardian()->create($data);
        }

        try {

            if ($saved) {
                // welcome email to the users
                $user->notify(new WelcomeMessage($user));

                // send notifications to users(admins)
                // sendNotifyToAdmin($user);

                $this->form = false;
                session()->flash('success', $this->first_name . ' has been added as Guardian');
                $this->refreshInputs();
            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }



        return redirect()->back();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    function add()
    {
        $this->update = false;
    }

    function showForm()
    {
        $this->form = true;
    }

    // colored each seleted rows
    function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    function updatedSelectPage($value)
    {
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

    // export excel
    function exportCSV()
    {
        return Excel::download(new ParentExport($this->checked), 'parent Report on-' . date('d-m-y') . '.csv');
    }

    // export pdf
    function exportPDF(string $name = "parent")
    {
        $viewData = Guardian::with(['roles', 'profile'])->whereKey($this->checked)->get();
        $data = $viewData->toArray();
        // dd($data);

        // if images are not showing
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);

        $load = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $load->getDomPDF()->setHttpContext($context);
        $pdfContent = $load->loadView('reports.report', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$name.pdf"
        );
    }

    public function confirmDelete($id)
    {

        $user = Guardian::findOrFail($id);

        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    public function delete()
    {

        $parent = Guardian::with('user')->findOrFail($this->delete);
        $true = $parent->delete();

        if ($true) {
            $parent->user()->delete();
            session()->flash('success', $parent->first_name . ' has been removed Guardian');
        }
        $this->refreshInputs();
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        // return redirect()->route('parent');
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
        $users = Guardian::findMany($this->checked);
        $true = $users->each->delete();

        if ($true) {
            session()->flash('success', count($this->checked) . ' parent  deleted successfully');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        return redirect()->route('students');
    }

    // selected all users
    function getparentsProperty()
    {
        return Guardian::with(['roles', 'profile'])->parent(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
    }

    public function render()
    {
        $titles = ['mr', 'mrs', 'dr', 'prof.', 'eng.', 'madam', 'sir', 'lady', 'lord'];
        $term = "%$this->search%";
        $parents = Guardian::with(['user', 'students'])->where('first_name', 'LIKE', $term)
            ->orWhere('last_name', 'LIKE', $term)
            ->orWhere('parent_id', 'LIKE', $term)
            ->orWhere('email', 'LIKE', $term)
            ->paginate($this->perPage);
        return view('livewire.parents', compact(['parents', 'titles']))->layout('layouts.dashboard');
    }
}