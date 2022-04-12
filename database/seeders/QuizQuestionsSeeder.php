<?php
namespace Database\Seeders;

use App\Domains\Quiz\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;

class QuizQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $component_names = [
            "simple-element" => [
                "title" => "Простой вопрос",
                "fields" => [
                    "title",
                    "list"
                ]
            ],
            "element-comment" => [
                "title" => "Вопрос с комментарием",
                "fields" => [
                    "title",
                    "comment",
                    "list"
                ]
            ],
        ];

        
        Question::truncate();

        foreach ($component_names as $componentSlug=>$component) {
            $component_model = Question::updateOrCreate([
                "slug" => $componentSlug,
            ], [
                "name" => $component['title'],
                "fields" => $component['fields'],
            ]);
        }

    }
}
