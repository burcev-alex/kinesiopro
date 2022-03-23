<?php
namespace App\Orchid\Screens\Contact;

use App\Domains\Feedback\Models\Contact;
use App\Domains\Feedback\Services\ContactService;
use App\Orchid\Layouts\Contact\ContactMainRows;
use App\Orchid\Layouts\Contact\ContactSocialRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Support\Facades\Cache;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ContactEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = '';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Редактирование контакта';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Contact $contact): array
    {
        $this->exists = $contact->exists;

        if ($this->exists) {
            $this->description = 'Редактировать контакт';
            if ($contact) {
                $this->name = $contact->name;
            }

            return [
                'contact' => $contact
            ];
        }
        else{
            return [
                'contact' => collect([])
            ];
        }
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
            ->method('save')->icon('save'),

            Button::make('Удалить')
            ->method('remove')->icon('trash')
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
        Layout::tabs([
            'Город' => [
                ContactMainRows::class
            ],
            'Соц.сети' => [
                ContactSocialRows::class
            ]
        ])
    ];
}

    public function save(
        Contact $contact,
        Request $request,
        ContactService $service
        )
    {
        $service->setModel($contact);
        $validate = $request->validate([
            'contact.city' => 'required',
            'contact.*' => ''
        ]);

        $service->save($validate['contact']);

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.contact.edit', $contact);

    }

    /**
     * @param Contact $item
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function remove(Contact $contact)
    {
        $contact->delete()
            ? Alert::info('Вы успешно удалили запись.')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('platform.contact.list');
    }
}
