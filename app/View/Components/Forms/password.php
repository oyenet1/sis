<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class password extends Component
{
    public $label, $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'password', $name = 'password')
    {
        $this->label = $label;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.password');
    }
}