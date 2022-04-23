<?php

namespace App\View\Components\Quiz;

use Illuminate\View\Component;

class ElementComment extends MainQuestion
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
        return view('components.quiz.element-comment', [
            "number" => $this->number,
            "title" => $this->title,
            "comment" => $this->comment,
            "list" => $this->list,
        ]);
    }
}
