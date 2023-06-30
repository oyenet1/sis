<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use Livewire\Component;
use App\Models\Timetable;
use Illuminate\Validation\Rule;

class TimeTables extends Component
{
    public $timetables;
    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];
    public $cid, $clas_id, $subject_id, $user_id, $day_id, $start, $end;
    public $update = false;
    public $form = false;
    public $activeClass = null;
    public $filterOne = 'select';
    public $filterTwo = 'select';

    public $type = 'class';

    public ?array $fValues = ['subject_id' => 'subject', 'teacher_id' => 'teacher'];
    public ?array $sValues = [];


    function add()
    {
        $this->update = false;
    }

    function selectClass($value)
    {
        $this->activeClass = $value;
    }


    function showForm()
    {
        $this->form = true;
    }

    function filter()
    {
        // dd($this->filterOne, $this->filterTwo);
        $data = $this->validate([
            'filterOne' => ['required', Rule::notIn(['select', null])],
            'filterTwo' => ['required', Rule::notIn(['select', null])],
        ]);

        if (!(empty($data['filterTwo']) || $data['filterTwo'] == null || $data['filterTwo'] == 'select' || $data['filterTwo'] == '')) {
            $this->type = 'filter';
        }

        if ($this->filterOne == 'subject_id') {
            $this->timetables = Timetable::with(['user', 'day', 'subject', 'clas'])->where('subject_id', $this->filterTwo)->get();
        } else {
            $this->timetables = Timetable::with(['user', 'day', 'subject', 'clas'])->where('user_id', $this->filterTwo)->get();
        }
    }
    protected $messages = [
        'filterOne.required' => 'Invalid selection',
        'filterTwo.required' => 'Invalid selection',
        'filterOne.not_in' => 'Invalid selection',
        'filterTwo.not_in' => 'Invalid selection',
        'clas_id.required' => 'Class cannot be empty',
        'clas_id.not_in' => 'Select the right class',
        'subject_id.required' => 'Subject cannot be empty',
        'subject_id.not_in' => 'Select the right subject',
        'user_id.required' => 'Assign teacher cannot be empty',
        'user_id.not_in' => 'Invalid selection, select teacher',
        'day_id.required' => 'Timetable Day cannot be empty',
        'day_id.not_in' => 'Invalid selection, select teacher from monday to friday',
        'start.before' => 'The start time must be atleat 30mins less than end time',
        'end.after' => 'The end time must be greater than start time',
    ];
    function refreshInputs()
    {
        $this->subject_id = '';
        $this->clas_id = '';
        $this->user_id = '';
        $this->day_id = '';
        $this->start = '';
        $this->end = '';
        $this->cid = '';
        $this->type = 'class';
        $this->form = false;
    }
    function save()
    {
        $data = $this->validate([
            'clas_id' => ['required', Rule::notIn(['select', null]), 'numeric'],
            'subject_id' => ['required', Rule::notIn(['select', null]), 'numeric'],
            'day_id' => ['required', Rule::notIn(['select', null]), 'numeric'],
            'user_id' => ['required', Rule::notIn(['select', null, '', '']), 'numeric'],
            'start' => ['required', 'date_format:H:i', 'before:end'],
            'end' => ['required', 'date_format:H:i', 'after:start'],
        ]);

        $true = Timetable::create($data);
        if ($true) {
            // also create association of subject and teacher and course if recordsdoesnt exit before
            $exist = Timetable::where('clas_id', $this->clas_id)->where('user_id', $this->user_id)->where('subject_id', $this->subject_id)->get();
            if (!$exist) {
                SubjectTeacher::create([
                    'clas_id' => $this->clas_id,
                    'subject_id' => $this->subject_id,
                    'user_id' => $this->user_id,
                ]);
            }


            $this->refreshInputs();
            // session()->flash('success', 'Timetable created successfully');
            return redirect()->back()->with('success', 'Timetable created successfully');
        }
    }

    function edit(Timetable $timetable)
    {
        $this->subject_id = $timetable->subject_id;
        $this->clas_id = $timetable->clas_id;
        $this->user_id = $timetable->user_id;
        $this->day_id = $timetable->day_id;
        $this->start = $timetable->start->format('H:i');
        $this->end = $timetable->end->format('H:i');
        $this->cid = $timetable->id;
        $this->form = true;
        $this->update = true;
    }

    function update()
    {
        $timetable = Timetable::find($this->cid);
        $data = $this->validate([
            'clas_id' => ['required', Rule::notIn(['select', null]), 'numeric'],
            'subject_id' => ['required', Rule::notIn(['select', null]), 'numeric'],
            'day_id' => ['required', Rule::notIn(['select', null]), 'numeric'],
            'user_id' => ['required', Rule::notIn(['select', null, '', '']), 'numeric'],
            'start' => ['nullable', 'date_format:H:i', 'before:end'],
            'end' => ['nullable', 'date_format:H:i', 'after:start'],
        ]);
        $saved = $timetable->update($data);

        if ($saved) {
            $this->refreshInputs();
            return session()->flash('success', 'Timetable Updated successfully');
        }

        return $this->dispatchBrowserEvent('reload');
    }

    public function confirmDelete(Timetable $timetable)
    {

        $this->delete = $timetable->id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    function delete()
    {
        $timetable = Timetable::find($this->delete);
        $delete = $timetable->delete();
        if ($delete) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Timetable deleted successfully',
                'title' => 'Deleted',
                'timer' => 3000,
            ]);
        }
    }
    public function render()
    {
        $mon = [];
        $tue = [];
        $wed = [];
        $thur = [];
        $fri = [];
        $sat = [];
        $sun = [];
        $tables = $this->timetables;
        return view('livewire.time-tables', compact(['tables', 'mon', 'tue', 'wed', 'thur', 'fri', 'sat', 'sun']))->layout('layouts.dashboard');
    }
}