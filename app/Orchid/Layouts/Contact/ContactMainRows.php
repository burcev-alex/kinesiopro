<?php
namespace App\Orchid\Layouts\Contact;

use App\Domains\Feedback\Models\Contact;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class ContactMainRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        $contact = $this->query->get('contact');
        // dd($contact->phone);
        
        $rows = [
            Input::make('contact.city')->title('Город')->required(),
            Input::make('contact.full_name')->title('ФИО'),
            Input::make('contact.email')->title('E-mail')->required(),
            Input::make('contact.url')->title('Сайт'),
            Input::make('contact.address')->title('Адрес'),
        ];

        
        $phones = [];

        $maxPhone = 3;

        for ($key = 0; $key < $maxPhone; $key++) {
            if (isset($contact->phone) && is_array($contact->phone)) {
                if (array_key_exists($key, $contact->phone)) {
                    $value = $contact->phone[$key];
                }
                else{
                    $value = '';
                }

                $phones[] = Input::make('contact.phoneList.')->value($value)->title('Телефон ' . ($key + 1));
            } else {
                $phones[] = Input::make('contact.phoneList.')->value('');
            }
        }

        $rows = [
            ...$rows,
            ...$phones
        ];

        return $rows;
    }
}