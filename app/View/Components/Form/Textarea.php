<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $name, $placeholder;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $placeholder)
    {
        //
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.textarea');
    }
}