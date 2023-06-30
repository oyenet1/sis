<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class TeacherSelect extends Component
{
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = "Select Subject Teacher")
    {

        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.teacher-select');
    }
}