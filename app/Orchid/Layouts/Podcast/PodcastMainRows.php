<?php
namespace App\Orchid\Layouts\Podcast;

use App\Domains\Podcast\Models\Podcast;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\DateTimer;

class PodcastMainRows extends Rows
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
        $podcast = $this->query->get('podcast');
        
        $rows = [
            Input::make('podcast.title')->title('Название')->required(),
            Input::make('podcast.slug')->title('Символьный код')->required(),
            Input::make('podcast.sort')->title('Сортировка'),
            CheckBox::make('podcast.active')->title('Активность'),
            DateTimer::make('podcast.publication_date')->title('Дата публикации'),
            Input::make('podcast.url')->title('Ссылка на эпизод'),
            Upload::make('podcast.attachment_id')
            ->value($podcast ? ($podcast->attachment ? [$podcast->attachment->id] : []) : [])
            ->title('Картинка анонса')->required(),
        ];

        return $rows;
    }
}
