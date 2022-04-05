<?php
namespace App\Orchid\Layouts\Podcast;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class PodcastShortRows extends Rows
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

        $rows = [];

        if ($podcast) {
            return [
                Quill::make('podcast.description')
                ->title('Описание')->value($podcast->description)
            ];
        } else {
            $rows = [
                ...$rows,
                ...[
                    Quill::make('podcast.description')
                    ->title('Описание'),
                ],
            ];

            return $rows;
        }
    }
}
