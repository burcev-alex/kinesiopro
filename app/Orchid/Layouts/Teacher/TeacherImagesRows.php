<?php
namespace App\Orchid\Layouts\Teacher;

use Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class TeacherImagesRows extends Rows
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
        $teacher = $this->query->get('teacher');
        return [
            Upload::make('teacher.images.attachment_id')
                ->value($teacher->count() ? ($teacher->attachment ? [$teacher->attachment->id] : []) : [])
                ->title('Фото'),
        ];
    }
}
