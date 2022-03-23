<?php
namespace App\Orchid\Layouts\Contact;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ContactSocialRows extends Rows
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
    public function fields(): array
    {
        $contact = $this->query->get('contact');

        return [
            Input::make('contact.fb')->title('FB'),
            Input::make('contact.vk')->title('VK'),
            Input::make('contact.instagram')->title('Instagram'),
            TextArea::make('contact.youtube')->title('Youtube'),
        ];
    }
}