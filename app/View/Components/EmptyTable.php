<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmptyTable extends Component
{
    public $title;
    public $comment;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $comment)
    {
        $this->title = $title;
        $this->$comment = $comment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.empty-table');
    }
}