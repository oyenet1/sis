<?php

namespace App\Http\Livewire;

use App\Models\AffectiveTrait;
use App\Models\DayPresent;
use App\Models\Psychomotor;
use App\Models\Remark;
use App\Models\Student;
use Livewire\Component;

class Cards extends Component
{
    public $cid, $term_id, $punctuality, $attendance, $reliability, $neatness, $politeness, $honesty, $relationship, $self_control, $attentiveness, $perseverance, $sports, $handwriting, $games, $drawing, $crafts, $music, $present, $affectiveT, $psychomotors, $remarks;

    public $success = '';
    public $edit = false;
    public $updateOne = false;
    public $updateTwo = false;
    public $updateThree = false;

    function getStudentTraitAndPsychomotor()
    {
        if ($this->student->affectiveT) {
            $this->punctuality = $this->student->affectiveT->punctuality;
            $this->attendance = $this->student->affectiveT->attendance;
            $this->relationship = $this->student->affectiveT->relationship;
            $this->reliability = $this->student->affectiveT->reliability;
            $this->neatness = $this->student->affectiveT->neatness;
            $this->politeness = $this->student->affectiveT->politeness;
            $this->honesty = $this->student->affectiveT->honesty;
            $this->self_control = $this->student->affectiveT->self_control;
            $this->attentiveness = $this->student->affectiveT->attentiveness;
            $this->perseverance = $this->student->affectiveT->perseverance;
        }

        if ($this->student->psychomotors) {
            $this->sports = $this->student->psychomotors->sports;
            $this->handwriting = $this->student->psychomotors->handwriting;
            $this->games = $this->student->psychomotors->games;
            $this->crafts = $this->student->psychomotors->crafts;
            $this->music = $this->student->psychomotors->music;
            $this->drawing = $this->student->psychomotors->drawing;
        }

        if ($this->student->attendance->count()) {
            $this->present = DayPresent::where('term_id', latestTerm()->id)->where('student_id', $this->student->id)->latest()->first()->present;
        }
    }


    function refreshInputs()
    {
        $this->cid = null;
        $this->term_id = '';
        $this->punctuality = '';
        $this->attendance = '';
        $this->relationship = '';
        $this->reliability = '';
        $this->neatness = '';
        $this->politeness = '';
        $this->honesty = '';
        $this->self_control = '';
        $this->attentiveness = '';
        $this->perseverance = '';
        $this->sports = '';
        $this->handwriting = '';
        $this->games = '';
        $this->drawing = '';
        $this->crafts = '';
        $this->music = '';
        $this->remarks = '';
        $this->present = null;
    }

    public $sesion = '';
    public $term = '';
    public Student $student;

    function daysPresent()
    {

        $data = $this->validate([
            'present' => 'required|integer'
        ]);

        $this->term_id = latestTerm()->id;

        $saved = DayPresent::updateOrCreate(['student_id' => $this->student->id, 'term_id' => $this->term_id], $data);

        if ($saved) {
            $this->refreshInputs();
            // session()->flash('success', 'Attendance updated successfully');
            $this->success = 'Attendance recorded successfully';
        }

        $this->dispatchBrowserEvent('reload');
    }

    function aTrait()
    {

        $data = $this->validate([
            'punctuality' => 'required',
            'attendance' => 'required',
            'relationship' => 'required',
            'reliability' => 'required',
            'neatness' => 'required',
            'politeness' => 'required',
            'honesty' => 'required',
            'self_control' => 'required',
            'attentiveness' => 'required',
            'perseverance' => 'required',
        ]);

        $this->term_id = latestTerm()->id;

        $saved = AffectiveTrait::updateOrCreate(['student_id' => $this->student->id, 'term_id' => $this->term_id], $data);

        if ($saved) {
            $this->refreshInputs();
            session()->flash('success', 'Affective Trait updated successfully');
        }

        $this->dispatchBrowserEvent('reload');
    }
    function saveTeachersRemark()
    {

        $data = $this->validate([
            'remarks' => 'required|min:10',
        ]);
        $data['user_id'] = auth()->user()->id;

        $this->term_id = latestTerm()->id;

        $saved = Remark::updateOrCreate(['student_id' => $this->student->id, 'type'=> 'teacher', 'term_id' => $this->term_id], $data);

        if ($saved) {
            $this->refreshInputs();
            session()->flash('success', 'Teachers remarks saved successfully');
        }

        $this->dispatchBrowserEvent('reload');
    }


    function mount()
    {
        $this->affectiveT = AffectiveTrait::where('term_id', latestTerm()->id)->where('student_id', $this->student->id)->first();

        $this->psychomotors = Psychomotor::where('term_id', latestTerm()->id)->where('student_id', $this->student->id)->first();

        if ($this->affectiveT) {
            $this->punctuality = $this->affectiveT->punctuality;
            $this->attendance = $this->affectiveT->attendance;
            $this->relationship = $this->affectiveT->relationship;
            $this->reliability = $this->affectiveT->reliability;
            $this->neatness = $this->affectiveT->neatness;
            $this->politeness = $this->affectiveT->politeness;
            $this->honesty = $this->affectiveT->honesty;
            $this->self_control = $this->affectiveT->self_control;
            $this->attentiveness = $this->affectiveT->attentiveness;
            $this->perseverance = $this->affectiveT->perseverance;
        }

        if ($this->psychomotors) {
            $this->sports = $this->psychomotors->sports;
            $this->handwriting = $this->psychomotors->handwriting;
            $this->games = $this->psychomotors->games;
            $this->crafts = $this->psychomotors->crafts;
            $this->music = $this->psychomotors->music;
            $this->drawing = $this->psychomotors->drawing;
        }

        $attendance = DayPresent::where('term_id', latestTerm()->id)->where('student_id', $this->student->id)->latest()->first();

        if ($attendance) {
            $this->present = $attendance->present;
        }

        $remarks = Remark::where('term_id', latestTerm()->id)->where('type', 'teacher')->where('student_id', $this->student->id)->latest()->first();
        if ($remarks) {
            $this->remarks = $remarks->remarks;
        }
    }

    protected $messages = [
        'present.required' => 'Days present must not be empty',
        'present.integer' => 'Days present must be a number',
    ];
    function psychomotor()
    {
        $data = $this->validate([
            'handwriting' => 'required',
            'games' => 'required',
            'drawing' => 'required',
            'crafts' => 'required',
            'sports' => 'required',
            'music' => 'required',
        ]);

        $this->term_id = latestTerm()->id;

        $saved = Psychomotor::updateOrCreate(['student_id' => $this->student->id, 'term_id' => $this->term_id], $data);

        if ($saved) {
            $this->refreshInputs();
            session()->flash('success', 'Psychomotor updated successfully');
        }

        $this->dispatchBrowserEvent('reload');
    }

    public function render()
    {
        return view('livewire.cards')->layout('layouts.dashboard');
    }
}