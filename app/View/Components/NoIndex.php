<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NoIndex extends Component
{
    public $disablerobots; 
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($disablerobots)
    {
        $this->disablerobots = $disablerobots;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.no-index', ["disablerobots" => $this->disablerobots]);
    }
}
