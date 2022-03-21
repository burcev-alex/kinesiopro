<?php
namespace App\Orchid\Layouts\Teacher;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class TeacherSeoRows extends Rows
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
        $teacher = $this->query->get('teacher');
        $rows = [];

        if (isset($teacher)) {
            $rows = [
                ...$rows,
                ...[
                    Input::make('teacher.meta_h1')->value($teacher->meta_h1)->title('Мета H1'),
                    Input::make('teacher.meta_title')->value($teacher->meta_title)->title('Мета заголовок'),
                    Input::make('teacher.meta_keywords')->value($teacher->meta_keywords)->title('Мета ключевые слова'),
                    TextArea::make('teacher.meta_description')->value($teacher->meta_description)->title('Мета описание'),
                ],
            ];
        }
        else{
            $rows = [
                ...$rows,
                ...[
                    Input::make('teacher.meta_h1')->title('Мета H1'),
                    Input::make('teacher.meta_title')->title('Мета заголовок'),
                    Input::make('teacher.meta_keywords')->title('Мета ключевые слова'),
                    TextArea::make('teacher.meta_description')->title('Мета описание'),
                ]
            ];
        }

        return $rows;
    }
}
