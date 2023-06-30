<?php

namespace App\Http\Livewire;

use App\Models\Remark;
use App\Models\ResumptionDate;
use App\Models\Student;
use Livewire\Component;

class HosComment extends Component
{
    public $remarks, $date;
    public $sesion = '';
    public $term = '';
    public Student $student;

    function saveDate()
    {

        $data = $this->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        // save resumption date
        $saved = ResumptionDate::updateOrCreate(['term_id' =>   latestTerm()->id], $data);

        if ($saved) {
            $this->date = '';
            session()->flash('success', 'Saved successfully, next term begins. at '. $saved->date->format('d m, Y'));
        }

        $this->dispatchBrowserEvent('reload');
    }
    function saveComment()
    {

        $data = $this->validate([
            'remarks' => 'required|min:10',
        ]);
        $data['user_id'] = auth()->user()->id;
        $data['type'] = 'hos';

        $saved = Remark::updateOrCreate(['student_id' => $this->student->id, 'term_id' =>   latestTerm()->id, 'type'=> 'hos'], $data);

        if ($saved) {
            $this->remarks = '';
            session()->flash('success', 'Remarks saved successfully');
        }

        $this->dispatchBrowserEvent('reload');
    }

    function mount(){
        $remarks = Remark::where('term_id', latestTerm()->id)->where('type', 'hos')->where('student_id', $this->student->id)->latest()->first();
        if ($remarks) {
            $this->remarks = $remarks->remarks;
        }
    }

    public function render()
    {
        return view('livewire.hos-comment')->layout('layouts.dashboard');
    }
}
