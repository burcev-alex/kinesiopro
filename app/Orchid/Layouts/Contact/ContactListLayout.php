<?php
namespace App\Orchid\Layouts\Contact;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContactListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'contacts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('city', 'Город')->render(function($contact){
                return Link::make($contact->city)->route('platform.contact.edit', $contact);
            }),
            TD::make('email', 'E-mail')
        ];
    }
}
