<?php
namespace App\Orchid\Layouts\Stream;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class StreamSeoRows extends Rows
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
        $stream = $this->query->get('stream');
        $rows = [];

        if ($stream->count() > 0) {
            $rows = [
                Input::make('stream.meta_title')->value($stream->meta_title)->title('Мета заголовок'),
                Input::make('stream.meta_keywords')->value($stream->meta_keywords)->title('Мета ключевые слова'),
                TextArea::make('stream.meta_description')->value($stream->meta_description)->title('Мета описание'),
            ];
        } else {
            $rows = [
                Input::make('stream.meta_title')->title('Мета заголовок'),
                Input::make('stream.meta_keywords')->title('Мета ключевые слова'),
                TextArea::make('stream.meta_description')->title('Мета описание'),
            ];
        }

        return $rows;
    }
}
