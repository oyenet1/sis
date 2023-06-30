<?php

namespace App\Http\Livewire;

use App\Models\Clas;
use App\Models\User;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\PDF;
use App\Exports\ClassExport;
use App\Models\School as ModelSchool;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Notifications\ClassTeacherAssignmentNotification;

class School extends Component
{
    public $name, $school_id, $high, $section,  $cid, $user_id;
    public $numbers = ['reception', 'nursery 1', 'nursery 2', 'year 1', 'year 2', 'year 3', 'year 4', 'year 5', 'year 6', 'year 7', 'year 8', 'year 9', 'year 10', 'year 11', 'year 12'];
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

    function refreshInputs()
    {
        $this->name = '';
        $this->school_id = '';
        $this->high = '';
        $this->section = '';
        $this->user_id = '';
        $this->update = false;
        $this->form = false;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'selected', 'checked', 'exportCSV()']);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatingSearch()
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

    // edit
    function edit($id)
    {
        $class = Clas::findOrFail($id);
        $this->update = true;
        $this->showForm();
        $this->cid = $class->id;
        $this->name = $class->name;
        $this->section = $class->section;
        $this->school_id = $class->school_id;
        $this->high = $class->high;
        $this->user_id = $class->user_id;
    }

    function update()
    {
        $class = Clas::findOrFail($this->cid);
        $data = $this->validate([
            'name' => 'required',
            'school_id' => 'required',
            // 'user_id' => ['nullable', 'unique:clas,user_id,' . $this->cid, 'integer', Rule::notIn(['select'])],
            'user_id' => ['nullable', 'integer', Rule::notIn(['select'])],
            'section' => 'nullable',
            'high' => ['required_if:school_id,4']
        ]);

        if ($data['school_id'] != 4) {
            $data['high'] = null;
        }

        $assign = '';
        $school = $class->update($data);
        if ($school) {
            if ($data['user_id']) {
                $user = User::find($data['user_id']);
                $user->notify(new ClassTeacherAssignmentNotification($class));
                $assign = ', and ' . $user->first_name . ' has been assigned to be the class teacher';
            }
            $this->refreshInputs();
            session()->flash('success', 'Class updated successfully' . $assign);
        }

        return redirect()->back();
    }


    // export excel
    function exportCSV()
    {
        return Excel::download(new ClassExport($this->checked), 'Class Report on-' . date('d-m-y') . '.csv');
    }

    // export pdf
    function exportPDF(string $name = "Class")
    {
        $viewData = Clas::with(['user', 'department'])->whereKey($this->checked)->get();
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
        $pdfContent = $load->loadView('reports.class', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "$name" . '-' . date('d-m-Y') . ".pdf"
        );
        redirect()->back();
    }

    protected $messages = [
        'school_id.required' => 'Invalid school type',
        'name.required_if' => 'Kindly select the class variation',
        'high.required_if' => 'Pls select department',
        'user_id.unique' => 'The class teacher has already been assigned to another class',
    ];
    function save()
    {
        $data = $this->validate([
            'name' => 'required',
            'school_id' => 'required',
            // 'user_id' => ['nullable', 'unique:clas,user_id', 'integer', Rule::notIn(['select'])],
            'user_id' => ['nullable', 'integer', Rule::notIn(['select'])],
            'section' => 'nullable',
            'high' => ['required_if:school_id,4']
        ]);
        if ($data['user_id'] != null) {
            $data['user_id'] = intval($data['user_id']);
        } else {
            $data['user_id'] = null;
        }

        $assign = ' without class teacher';

        // dd($data);
        $school = Clas::create($data);
        if ($school) {
            if ($data['user_id']) {
                $user = User::find($data['user_id']);
                $user->notify(new ClassTeacherAssignmentNotification($school));
                $assign = ', and ' . $user->first_name . ' has been assigned to be the class teacher';
            }
            $this->refreshInputs();
            session()->flash('success', 'Class created successfully' . $assign);
        }

        return redirect()->back();
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

    public function confirmDelete($id)
    {

        $user = Clas::findOrFail($id);

        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    public function delete()
    {

        $class = Clas::with('user')->findOrFail($this->delete);
        $true = $class->delete();

        if ($true) {
            session()->flash('success', strtoupper($class->school->short . ' ' . $class->name) . ' has been removed from class');
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
        $users = Clas::findMany($this->checked);
        $true = $users->each->delete();

        if ($true) {
            session()->flash('success', count($this->checked) . ' class  deleted successfully');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        return redirect()->back();
    }
    public function render()
    {
        $teachers = teachers();
        $highs = ['science', 'commercial', 'art'];
        $term = "%$this->search%";
        $classes = Clas::with(['user', 'department', 'school'])
            ->where('name', 'LIKE', $term)
            ->orWhere('section', 'LIKE', $term)
            ->orWhere('high', 'LIKE', $term)
            ->orWhereHas('user', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('first_name', 'LIKE', $term)
                    ->orWhere('last_name', 'LIKE', $term)
                    ->orWhere('school_id', 'LIKE', $term);
            })->orWhereHas('school', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('name', 'LIKE', $term)
                    ->orWhere('short', 'LIKE', $term);
            })->latest()
            ->paginate($this->perPage);
        return view('livewire.school', compact(['classes', 'highs', 'teachers']))->layout('layouts.dashboard');
    }
}