<?php
namespace Database\Seeders;

use App\Domains\Blog\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;

class NewsPaperComponentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $component_names = [
            "title-text" => [
                "title" => "Текст с заголовком",
                "fields" => [
                    "title",
                    "text"
                ]
            ],
            "lists" => [
                "title" => "Список",
                "fields" => [
                    "list"
                ]
            ],
            "text" => [
                "title" => "Текст",
                "fields" => [
                    "text"
                ]
            ],
            "text-citation" => [
                "title" => "Текст с цитатой",
                "fields" => [
                    "text",
                    "author"
                ]
            ],
            "image" => [
                "title" => "Изображение",
                "fields" => [
                    "media"
                ]
            ],
            "video" => [
                "title" => "Видео",
                "fields" => [
                    "link"
                ]
            ]
        ];

        
        Component::truncate();

        foreach ($component_names as $componentSlug=>$component) {
            $component_model = Component::updateOrCreate([
                "slug" => $componentSlug,
            ], [
                "name" => $component['title'],
                "fields" => $component['fields'],
            ]);
        }

    }
}
