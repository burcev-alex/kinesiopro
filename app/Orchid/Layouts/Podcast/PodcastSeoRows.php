<?php
namespace App\Orchid\Layouts\Podcast;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PodcastSeoRows extends Rows
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
        $podcast = $this->query->get('podcast');
        $rows = [];

        if ($podcast->count() > 0) {
            $rows = [
                Input::make('podcast.meta_h1')->value($podcast->meta_h1)->title('Мета H1'),
                Input::make('podcast.meta_title')->value($podcast->meta_title)->title('Мета заголовок'),
                Input::make('podcast.meta_keywords')->value($podcast->meta_keywords)->title('Мета ключевые слова'),
                TextArea::make('podcast.meta_description')->value($podcast->meta_description)->title('Мета описание'),
            ];
        } else {
            $rows = [
                Input::make('podcast.meta_h1')->title('Мета H1'),
                Input::make('podcast.meta_title')->title('Мета заголовок'),
                Input::make('podcast.meta_keywords')->title('Мета ключевые слова'),
                TextArea::make('podcast.meta_description')->title('Мета описание'),
            ];
        }

        return $rows;
    }
}
