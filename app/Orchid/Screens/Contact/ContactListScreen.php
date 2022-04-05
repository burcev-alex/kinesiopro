<?php
namespace App\Orchid\Screens\Contact;

use App\Domains\Feedback\Models\Contact;
use App\Orchid\Layouts\Contact\ContactListLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class ContactListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Контакты';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех отделений';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'contacts' => Contact::paginate(20),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('pencil')
                ->route('platform.contact.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            ContactListLayout::class
        ];
    }
}
