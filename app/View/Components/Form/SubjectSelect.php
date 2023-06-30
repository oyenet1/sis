<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class SubjectSelect extends Component
{

    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = 'Subject')
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
        return view('components.form.subject-select');
    }
}