<?php

namespace App\Http\Livewire;

use App\Models\Clas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Subject as ModelsSubject;
use App\Models\SubjectTeacher;
use App\Models\User;

class Subject extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];


    public $name, $short, $department_id, $subject_id, $clas_id, $user_id, $cid;
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

    protected $messages = [
        'name.unique' => 'Subject already exist',
        'user_id.required' => 'Invalid subject teacher.',
        'clas_id.required' => 'The assign class cannot be empty',
        'subject_id.required' => 'Invalid subject',
    ];
    function addSubject()
    {
        $data = $this->validate([
            'name' => 'required|unique:subjects,name',
            'department_id' => 'nullable'
        ]);
        $subject =  ModelsSubject::create($data);

        try {

            if ($subject) {
                $this->form = false;
                session()->flash('success', ucfirst($subject->name) . ' added as subject');
                $this->refreshInputs();
            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }



        return redirect()->route('subjects');
    }
    public function deleteSubject($id)
    {
        $subject = ModelsSubject::findOrFail($id);
        $true = $subject->delete();

        if ($true) {
            $this->form = false;
            session()->flash('success', ucfirst($subject->name) . ' deleted from subject list');
            $this->refreshInputs();
        }
        $this->checked = [];
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
        $this->subject_id = '';
        $this->clas_id = '';
        $this->user_id = '';
        $this->cid = '';
    }

    public function confirmDelete($id)
    {

        $subject =   SubjectTeacher::find($id);
        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    // colored each seleted rows
    function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    function save()
    {
        $subjects = $this->validate([
            'user_id' => ["required", Rule::notIn(['select', 'select type', '', null])],
            'subject_id' => ['required', Rule::notIn(['select', 'select type', '', null])],
            'clas_id' => ["required", Rule::notIn(['select', 'select type', '', null])],
        ]);
        $duplicateAssignment = SubjectTeacher::where('subject_id', $subjects['subject_id'])->where('clas_id', $subjects['clas_id'])->first();

        if ($duplicateAssignment) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'error',
                'text' => 'The selected class and subject as been assigned to ' . strtoupper($duplicateAssignment->user->title . ' ' . $duplicateAssignment->user->first_name),
                'title' => 'Assignment not permitted',
                'timer' => 4000,
                'button' => false,
            ]);
        } else {
            $true = SubjectTeacher::create($subjects);
            if ($true) {
                $this->refreshInputs();
                $this->form = false;
                $this->update = false;
                $subject = ModelsSubject::find($true->subject_id);
                $teacher = User::find($true->user_id);
                $clas = Clas::find($true->clas_id);

                $message = $teacher->title . ' ' . $teacher->first_name . ' has been assigned to teach ' .  strtoupper($clas->school->short . ' ' . $clas->name . $clas->section . ' ' . $subject->name);

                session()->flash('success', $message);
            }
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
        $subjects = SubjectTeacher::findMany($this->checked);

        if ($subjects) {
            $true = $subjects->each->delete();

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
        $subject = SubjectTeacher::findOrFail($id);
        $this->form = true;
        $this->cid = $subject->id;
        $this->update = true;
        $this->subject_id = $subject->subject_id;
        $this->user_id = $subject->user_id;
        $this->clas_id = $subject->clas_id;
    }

    function update()
    {
        $cid = $this->cid;

        $subjectTeacher = SubjectTeacher::find($cid);

        $subjects = $this->validate([
            'user_id' => ["required", Rule::notIn(['select', 'select type', '', null])],
            'subject_id' => ['required', Rule::notIn(['select', 'select type', '', null])],
            'clas_id' => ["required", Rule::notIn(['select', 'select type', '', null])],
        ]);
        $duplicateAssignment = SubjectTeacher::where('subject_id', $subjects['subject_id'])->where('clas_id', $subjects['clas_id'])->first();

        if ($duplicateAssignment) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'error',
                'text' => 'The selected class and subject as been assigned to ' . strtoupper($duplicateAssignment->user->title . ' ' . $duplicateAssignment->user->first_name),
                'title' => 'Assignment not permitted',
                'timer' => 4000,
                'button' => false,
            ]);
        } else {
            $true = $subjectTeacher->update($subjects);
            if ($true) {
                $this->refreshInputs();
                $this->form = false;
                $this->update = false;

                session()->flash('success', 'Subject Teacher updated successfully');
            }
        }

        return redirect()->back();
    }

    public function delete()
    {

        $subject = SubjectTeacher::findOrFail($this->delete);
        $true = $subject->delete();

        if ($true) {
            $this->form = false;
            session()->flash('success', 'Teacher assigned has been removed');
            $this->refreshInputs();
        }
        $this->checked = [];
        $this->update = false;
    }
    // selected all subjects
    function getsubjectsProperty()
    {
        return SubjectTeacher::with(['subject', 'user', 'clas'])->search(trim($this->search))->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc')->paginate($this->perPage);
    }

    function updatedSelectPage($value)
    {
        // dd($value);
        if ($value) {
            $this->checked = $this->subjects->pluck('id')->toArray();
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
    //     return Excel::download(new subjectExport($this->checked), 'subjects.pdf');
    // }

    // export pdf
    function exportPDF(string $name = "subject")
    {
        $viewData = ModelsSubject::whereKey($this->checked)->latest()->get();
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
        $pdfContent = $load->loadView('reports.subject', ['data' => $data])->output();
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
        return Excel::download(new subjectExport($this->checked), 'subjects-' . date('d-m-y') . '.xlsx');
    }

    public function render()
    {
        $subjects = $this->subjects;
        return view('livewire.subject', compact(['subjects']))->layout('layouts.dashboard');
    }
}