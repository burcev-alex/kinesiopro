<?php

namespace App\Orchid\Screens\Quiz;

use App\Domains\Quiz\Models\Item;
use App\Orchid\Layouts\Quiz\QuizesListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class QuizItemListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Тесты';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Список всех тестов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'quizes' => Item::orderBy('created_at')->paginate(10),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Создать тест')->icon('pencil')->route('platform.quiz.create')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            QuizesListLayout::class
        ];
    }
}
