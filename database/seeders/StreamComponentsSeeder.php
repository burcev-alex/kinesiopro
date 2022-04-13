<?php
namespace Database\Seeders;

use App\Domains\Stream\Models\Component;
use Illuminate\Database\Seeder;

class StreamComponentsSeeder extends Seeder
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
                    "type",
                    "title",
                    "list"
                ]
            ],
            "text" => [
                "title" => "Текст",
                "fields" => [
                    "text"
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
