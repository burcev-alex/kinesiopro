<?php

declare(strict_types=1);

namespace App\Orchid\Filters\Course;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class MarkerFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'marker'
    ];

    /**
     * @return string
     */
    public function name() : string
    {
        return 'Маркетинговые метки';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        return $builder->where($this->request->get('marker'), 1);
    }

    /**
     * @return Field[]
     */
    public function display() : array
    {
        return [
            Select::make('marker')
                    ->options([
                        'marker_archive' => 'Архив',
                        'marker_popular' => 'Главная',
                        'marker_new' => 'Новинка'
                    ])
                    ->title('Метка')
                    ->empty()
                    ->value($this->request->get('marker'))
        ];
    }
}
