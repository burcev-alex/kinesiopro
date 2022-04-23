<?php
namespace Database\Seeders;

use App\Domains\Blog\Models\Component;
use App\Domains\Online\Models\OnlineDesciptionComponent;
use App\Domains\Online\Models\OnlineDesciptionMedia;
use App\Domains\Online\Models\Online;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Container\Container;

class OnlinesDescriptionSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = $this->faker;

        $component_names = [
            "title-text" => "Текст с заголовком",
            "lists" => "Список",
            "text" => "Текст",
            "text-citation" => "Текст с цитатой",
            "image" => "Изображение",
            "gif" => "Гифка",
            "video" => "Youtube видео",
        ];

        $onlines = Online::all();
        $onlines->each(function ($online) use($faker, $component_names) {

            $newsComponents = [
                [
                    "component_name" => "text",
                    "fields" => [
                        "text" => $faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()
                    ]
                ],
                [
                    "component_name" => "lists",
                    "fields" => [
                        "type" => "circle",
                        "title" => $faker->sentence(),
                        "list" => [
                            $faker->sentence(),
                            $faker->sentence(),
                            $faker->sentence(),
                            $faker->sentence(),
                            $faker->sentence(),
                            $faker->sentence(),
                            $faker->sentence()
                        ]
                    ]
                ],
                [
                    "component_name" => "text",
                    "fields" => [
                        "text" => $faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()
                    ]
                ],
                [
                    "component_name" => "lists",
                    "fields" => [
                        "type" => "cross",
                        "title" => $faker->sentence(),
                        "list" => [
                            $faker->sentence(),
                            $faker->sentence(),
                            $faker->sentence(),
                            $faker->sentence()
                        ]
                    ]
                ],
            ];

            $key = 0;
            for ($i = 0; $i < count($newsComponents); $i++) {
                $component = $key == 0 ? $newsComponents[$i] : $newsComponents[count($newsComponents) - $i - 1];

                $component_model = Component::updateOrCreate([
                    "slug" => $component["component_name"]
                ], [
                    "name" => $component_names[$component["component_name"]],
                    "fields" => array_keys($component['fields'])
                ]);
                $online_component_model = OnlineDesciptionComponent::create([
                    "online_id" => $online->id,
                    "component_id" => $component_model->id,
                    "sort" => $key * count($newsComponents) + $i + 1,
                    "fields" => $component["fields"]
                ]);
                $fields = $component["fields"];
                if (isset($fields['media'])) {
                    foreach ($fields['media'] as $key => $value) {
                        $fields['media'][$key] = $this->createImage($value, $online_component_model->id);
                    }
                }

                $online_component_model->fields = $fields;
                $online_component_model->save();

                $key++;
            }
        });
    }

    public function createImage($attachment_id, $component_id)
    {
        $image = OnlineDesciptionMedia::create(compact('attachment_id', 'component_id'));
        return $image->id;
    }

    protected function getImage($width = 1920, $heigth = 1080){
        $src = "image.jpg";
        Storage::disk('public')->put("t" . DIRECTORY_SEPARATOR . $src, file_get_contents("https://picsum.photos/".$width."/".$heigth));
        $uploaded = new UploadedFile(public_path("storage" . DIRECTORY_SEPARATOR . "t" . DIRECTORY_SEPARATOR . $src), $src);
        $file = new File($uploaded, 'public');
        $attach = $file->load();
        if (Storage::disk('public')->exists("t/")) {
            Storage::disk('public')->deleteDirectory("t/");
        }

        return $attach;
    }
}
