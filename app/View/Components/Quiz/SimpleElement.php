<?php

namespace App\View\Components\Quiz;

use Illuminate\View\Component;
use Log;

class SimpleElement extends MainQuestion
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $number, array $fields = [])
    {
        parent::__construct($number, $fields);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.news.simple-element', [
            "number" => $this->number,
            "title" => $this->title,
            "list" => $this->list
        ]);
    }
}
