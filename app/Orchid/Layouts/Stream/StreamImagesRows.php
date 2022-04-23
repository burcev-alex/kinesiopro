<?php
namespace App\Orchid\Layouts\Stream;

use Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Layouts\Rows;

class StreamImagesRows extends Rows
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
        $stream = $this->query->get('stream');

        $value = $stream->count() ? ($stream->attachment ? $stream->attachment->id : '') : '';
        return [
            Cropper::make('stream.attachment_id')->value($value)->title('Фото')->width(305)->height(305)->targetId(),
        ];
    }
}
