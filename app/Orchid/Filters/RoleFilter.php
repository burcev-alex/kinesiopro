<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class RoleFilter extends Filter
{
    /**
     * Parameters
     *
     * @var array
     */
    public $parameters = [
        'role',
    ];

    /**
     * Name
     *
     * @return string
     */
    public function name(): string
    {
        return __('Roles');
    }

    /**
     * Run
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereHas('roles', function (Builder $query) {
            $query->where('slug', $this->request->get('role'));
        });
    }

    /**
     * Display
     *
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make('role')
                ->fromModel(Role::class, 'name', 'slug')
                ->empty()
                ->value($this->request->get('role'))
                ->title(__('Roles')),
        ];
    }

    /**
     * Value
     *
     * @return string
     */
    public function value(): string
    {
        return $this->name().': '.Role::where('slug', $this->request->get('role'))->first()->name;
    }
}
