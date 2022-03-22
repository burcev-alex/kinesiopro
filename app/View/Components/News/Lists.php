<?php

namespace App\View\Components\News;

use Illuminate\View\Component;

class Lists extends MainComponent
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
        return view('components.news.lists', [
            "number" => $this->number,
            "list" => $this->list,
        ]);
    }
}
