<?php

namespace App\Http\Livewire;

use App\Models\Clas;
use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use Livewire\WithPagination;
use App\Exports\StudentExport;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\Guardian as RulesGuardian;

class ClassStudents extends Component
{
    public Clas $school;
    public $first_name, $last_name, $clas_id, $email, $dob, $phone,  $cid, $title, $gender, $parent, $parentD;
    public $code = "+234";
    public $role = 'student';

    // public User $parents;

    function mount()
    {
        if (session('form')) {
            $this->form = true;
        }
    }

    public $update = false;
    public $form = false;
    public $sf = false;

    function toggleForm()
    {
        $this->sf = false;
        $this->parent = '';
        $this->form = false;
        $this->resetPage();
        return redirect()->route('students')->with('form', true);
    }


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

    protected $messages = [
        'clas_id.required' => 'Invalid class, pls select class',
        'clas_id.not_in' => 'The selected class is invalid',
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
    function continue()
    {
        $parent = $this->validate([
            'parent' => ['required', new RulesGuardian],
        ]);
        $this->parent = trim($this->parent);
        $this->parentD = Guardian::where('parent_id', $this->parent)->orWhere('email', $this->parent)->first();
        $this->sf = true;
        // dd($this->parentD);
    }
    function refreshInputs()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->phone = '';
        $this->email = '';
        $this->code = "+234";
        $this->parent = '';
        $this->dob = '';
        $this->clas_id = '';
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
            'dob' => 'required|before_or_equal:today',
            'email' => 'nullable',
            'clas_id' => ['required', Rule::notIn(['select', null]),],
            'phone' => 'nullable',
            'gender' => ['required', Rule::notIn(['select', 'gender']),]
        ]);

        $student = $this->parentD->students()->create($data);

        if ($student) {
            // dd($student);
            Student::where('id', $student->id)->update(['clas_id' => $this->clas_id]);
        }

        try {

            if ($student) {
                // welcome email to the parent of the child
                // $user->notify(new WelcomeMessage($user));

                // send notifications to users(admins)
                // sendNotifyToAdmin($user);

                $this->form = false;
                session()->flash('success', $this->first_name . ' has been registered as student');
                $this->refreshInputs();
            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }

        return $this->dispatchBrowserEvent('reload');
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
        return Excel::download(new StudentExport($this->checked), 'Student Report on-' . date('d-m-y') . '.csv');
    }

    // export pdf
    function exportPDF(string $name = "student")
    {
        $viewData = Student::with(['clas', 'guardian'])->whereKey($this->checked)->get();
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
        $pdfContent = $load->loadView('reports.student', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$name.pdf"
        );
    }

    public function confirmDelete($id)
    {

        $user = Student::findOrFail($id);

        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    public function delete()
    {

        $student = Student::findOrFail($this->delete);
        $true = $student->delete();

        if ($true) {
            if ($student->user) {
                dd('student associtaed with user');
                $student->user()->delete();
            }
            session()->flash('success', $student->first_name . ' ' . $student->last_name . ' has been deleted');
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
        $users = Student::findMany($this->checked);
        $true = $users->each->delete();

        if ($true) {
            session()->flash('success', count($this->checked) . ' students  deleted successfully');
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
        return Student::with(['roles', 'profile'])->parent(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
    }
    public function render()
    {
        $parents = userByRole(9);
        $titles = ['mr', 'mrs', 'dr', 'prof.', 'eng.', 'madam', 'sir', 'lady', 'lord'];
        $term = "%$this->search%";
        $students = Student::with(['clas', 'guardian'])->where('first_name', 'LIKE', $term)
            ->orWhere('last_name', 'LIKE', $term)
            ->orWhere('student_id', 'LIKE', $term)
            ->orWhere('email', 'LIKE', $term)
            ->paginate($this->perPage);
        return view('livewire.class-students', compact(['students', 'parents']))->layout('layouts.dashboard');
    }
}