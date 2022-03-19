<?php
namespace App\Orchid\Screens\Property;

use App\Domains\Product\Models\RefChar;
use App\Orchid\Layouts\Property\ProductPropertyListLayout;
use Orchid\Screen\Screen;

class ProductPropertyListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'ProductPropertiesScreen';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'ProductPropertiesScreen';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'refs' => RefChar::property()->paginate(12)
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            ProductPropertyListLayout::class
        ];
    }
}
