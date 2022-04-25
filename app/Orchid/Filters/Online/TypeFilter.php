<?php

declare(strict_types=1);

namespace App\Orchid\Filters\Online;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class TypeFilter extends Filter
{
    /**
     * Parameters
     *
     * @var array
     */
    public $parameters = [
        'type'
    ];

    /**
     * Name
     *
     * @return string
     */
    public function name() : string
    {
        return 'Тип';
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
        return $builder->where('type', $this->request->get('type'));
    }

    /**
     * Display
     *
     * @return Field[]
     */
    public function display() : array
    {
        return [
            Select::make('type')
                    ->options([
                        'marafon' => 'марафон',
                        'course' => 'курс',
                        'conference' => 'конференцию',
                        'webinar' => 'вебинар',
                        'video' => 'видео курс',
                    ])
                    ->title('Тип')
                    ->empty()
                    ->value($this->request->get('type'))
        ];
    }
}
