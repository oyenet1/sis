<?php

namespace App\Http\Livewire;

use App\Models\Student;
use App\Models\Term;
use Livewire\Component;

class CheckResult extends Component
{
    public  $student;
    public  $term;
    public $student_id, $term_id, $clas_id;

    public $frame = false;


    function checkResult()
    {


        $this->validate([
            'term_id' => 'required',
            'student_id' => 'required',
        ]);
        $term = Term::find($this->term_id);
        $student = Student::find($this->student_id);
        $this->frame = true;

        $this->term_id = $term->id;
        $this->student_id = $student->id;

        return redirect()->route('reportcard', [$this->term_id, $this->student_id]);
    }
    public function render()
    {
        return view('livewire.check-result')->layout('layouts.dashboard');
    }
}