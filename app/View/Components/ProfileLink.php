<?php

namespace App\View\Components;

use App\Models\Student;
use Illuminate\View\Component;

class ProfileLink extends Component
{
    public $student;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.profile-link');
    }
}