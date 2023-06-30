<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Report extends Component
{
    public $name, $data;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $data)
    {
        $this->$name = $name;
        $this->data = $data;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.report');
    }
}