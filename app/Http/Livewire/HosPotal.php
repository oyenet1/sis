<?php

namespace App\Http\Livewire;

use App\Models\Clas;
use App\Models\Student;
use Livewire\Component;

class HosPotal extends Component
{
    public $activeClass;

    function selectClass($activeClass){
        $this->activeClass = $activeClass;
    }

    function mount(){
        $this->activeClass = Clas::count() ? 1 : null;
    }
    public function render()
    {
        $students = Student::where('clas_id', $this->activeClass)->get() ?? null;
        return view('livewire.hos-potal', compact(['students']));
    }
}
