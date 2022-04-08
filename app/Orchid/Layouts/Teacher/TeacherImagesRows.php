<?php
namespace App\Orchid\Layouts\Teacher;

use Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Cropper;
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

        $value = $teacher->count() ? ($teacher->attachment ? $teacher->attachment->id : '') : '';
        return [
            Cropper::make('teacher.images.attachment_id')->value($value)->title('Фото')->width(150)->height(150)->targetId(),
        ];
    }
}
