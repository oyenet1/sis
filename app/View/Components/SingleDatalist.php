<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SingleDatalist extends Component
{
    public $name, $datas;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $datas)
    {
        $this->name = $name;
        $this->datas = $datas;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.single-datalist');
    }
}