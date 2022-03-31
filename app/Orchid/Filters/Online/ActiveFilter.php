<?php

declare(strict_types=1);

namespace App\Orchid\Filters\Online;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ActiveFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'active'
    ];

    /**
     * @return string
     */
    public function name() : string
    {
        return 'Активность';
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        return $builder->where('active', $this->request->get('active'));
    }

    /**
     * @return Field[]
     */
    public function display() : array
    {
        return [
            Select::make('active')
                    ->options([
                        1 => 'Да',
                        0 => 'Нет'
                    ])
                    ->title('Значение')
                    ->empty()
                    ->value($this->request->get('active'))
        ];
    }
}
