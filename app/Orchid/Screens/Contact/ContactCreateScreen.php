<?php

namespace App\Orchid\Screens\Contact;

use App\Domains\Feedback\Models\Contact;
use App\Domains\Feedback\Services\ContactService;
use App\Orchid\Layouts\Contact\ContactMainRows;
use App\Orchid\Layouts\Contact\ContactSocialRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ContactCreateScreen extends Screen
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
    public $description = 'Создание контакта';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Contact $contact): array
    {
        $this->exists = $contact->exists;

        return [
            'contact' => collect([]),
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
            Button::make('Сохранить')
                ->method('save')->icon('save')
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
                ],
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

        Cache::tags(['contacts'])->flush();

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.contact.edit', $contact);
    }
}
