<?php

declare(strict_types=1);

namespace App\Orchid\Filters\Course;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class TitleFilter extends Filter
{
    /**
     * Parameters
     *
     * @var array
     */
    public $parameters = [
        'name',
    ];

    /**
     * Name
     *
     * @return string
     */
    public function name() : string
    {
        return 'Название';
    }

    /**
     * Run
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        return $builder->where('name', 'LIKE', "%".$this->request->get('name')."%");
    }

    /**
     * Display
     *
     * @return Field[]
     */
    public function display() : array
    {
        return [
            Input::make('name')->type('text')->title('Название')->placeholder('Name')->value($this->request->get('name')),
        ];
    }
}
