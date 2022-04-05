<?php
namespace App\Orchid\Layouts\Teacher;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class TeacherShortRows extends Rows
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

        $rows = [];

        if ($teacher) {
            return [
                Quill::make('teacher.description')
                ->title('Краткое описание')->value($teacher->description),
                Quill::make('teacher.education')
                ->title('Образование')->value($teacher->education),
                Quill::make('teacher.certificates')
                ->title('Курсы и сертификаты')->value($teacher->certificates),
                Quill::make('teacher.specialization')
                ->title('Специализация')->value($teacher->specialization),
            ];
        } else {
            $rows = [
                ...$rows,
                ...[
                    Quill::make('teacher.description')
                    ->title('Краткое описание'),
                    Quill::make('teacher.education')
                    ->title('Образование'),
                    Quill::make('teacher.certificates')
                    ->title('Курсы и сертификаты'),
                    Quill::make('teacher.specialization')
                    ->title('Специализация'),
                ],
            ];

            return $rows;
        }
    }
}
