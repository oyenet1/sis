<?php

namespace App\Http\Livewire;

use App\Models\Clas;
use App\Models\Subject;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class BroadSheet extends Component
{
    public $clas_id, $clas, $subject,$subject_id;

    public $frame = false;


    function generateScoresheet()
    {

        
        $this->validate([
            'clas' => 'required',
            'subject' => 'required',
        ]);
        $clas = Clas::find($this->clas);
        $subject = Subject::find($this->subject);
        $this->frame = true;

        $this->clas_id = $clas->id;
        $this->subject_id = $subject->id;


        // return redirect()->route('scoresheet', [$this->clas, $this->subject]);
    }
    public function render()
    {
        return view('livewire.broad-sheet')->layout('layouts.dashboard');
    }
}