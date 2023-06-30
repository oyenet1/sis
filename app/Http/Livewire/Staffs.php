<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Exports\UserExport;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\WelcomeMessage;
use Illuminate\Database\Eloquent\Builder;


class Staffs extends Component
{
    public $first_name, $last_name, $email, $phone, $cid, $role, $delete;
    public $code = "+234";

    // public User $staffs;

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
        $this->role = '';
        $this->phone = '';
        $this->email = '';
        $this->code = "+234";
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
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users|numeric|digits_between:10,11',
            'role' => [
                'required', Rule::notIn(['nurse', 'Nurse']),
            ]
        ]);

        $this->phone = trimPhone($this->code, $this->phone); //function from helpers,


        $user = User::create($data);
        $saved = $user->attachRole($this->role);

        try {

            if ($saved) {
                // welcome email to the users
                $user->notify(new WelcomeMessage($user));
                // send notifications to users(admins)
                // sendNotifyToAdmin($user);

                $this->form = false;
                session()->flash('success', $this->first_name . ' has been added to Staff');
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
        return Excel::download(new UserExport($this->checked), 'Staff Report on-' . date('d-m-y') . '.csv');
    }
    // export pdf
    function exportPDF(string $name = "staff")
    {
        $viewData = User::with(['roles', 'profile'])->whereKey($this->checked)->get();
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
            fn() => print($pdfContent),
            "$name.pdf"
        );
    }
    public function confirmDelete($id)
    {

        $user = User::findOrFail($id);

        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    public function delete()
    {

        $staff = User::with('roles')->findOrFail($this->delete);
        $true = $staff->delete();

        if ($true) {
            session()->flash('success', $staff->first_name . ' has been removed as staff');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        // return redirect()->route('staff');
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
        $users = User::findMany($this->checked);
        $true = $users->each->delete();

        if ($true) {
            session()->flash('success', count($this->checked) . ' Staff  deleted successfully');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        return redirect()->route('staff');
    }

    // selected all users
    function getStaffsProperty()
    {
        return User::with(['roles', 'profile'])->staff(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
    }

    // public function mount(User $staffs)
    // {
    //     $this->staff = $staffs;
    // }
    public function render()
    {
        $term = "%$this->search%";
        $staffs = User::with(['profile', 'roles'])
            ->where('first_name', 'LIKE', $term)
            ->orWhere('last_name', 'LIKE', $term)
            ->orWhere('school_id', 'LIKE', $term)
            ->orWhereHas('roles', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('name', 'LIKE', $term)->orderBy('name', 'desc');
            })
            ->orWhereHas('profile', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('status', 'LIKE', $term);
            })
            ->paginate($this->perPage);
        // $staff = $this->staffs;
        // return view('livewire.staffs');
        return view('livewire.staffs', compact(['staffs']))->layout('layouts.dashboard');
    }
}