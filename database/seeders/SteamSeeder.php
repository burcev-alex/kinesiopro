<?php
namespace Database\Seeders;

use App\Domains\Stream\Models\Component;
use App\Domains\Stream\Models\Lesson;
use App\Domains\Stream\Models\LessonComponent;
use App\Domains\Stream\Models\LessonMedia;
use App\Domains\Stream\Models\Stream;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Faker\Generator;
use Illuminate\Container\Container;

class SteamSeeder extends Seeder
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
            "video" => "Youtube видео",
            "text" => "Текст",
            "image" => "Изображение",
        ];

        for($s=1; $s<=20; $s++){

            $attachStream = $this->getImage(400, 300);
            $stream = [
                "title" => $faker->sentence(),
                "attachment_id" => $attachStream->id,
                "slug" => "stream-".rand(1000, 100000000),
                "active" => true,
                "meta_title" => $faker->sentence(),
                "meta_keywords" => "",
                "meta_description" => $faker->sentence(),
            ];

            $modelStream = Stream::create($stream);


            $rand = rand(5, 12);
            for($iteration=1; $iteration<=$rand; $iteration++){
                $attach = $this->getImage(400, 300);
                $detail = $this->getImage(1200, 500);
                $lesson = [
                    "stream_id" => $modelStream->id,
                    "title" => $faker->sentence(),
                    "attachment_id" => $attach->id,
                    "slug" => "lesson-".rand(1000, 100000000),
                    "sort" => $iteration,
                    "meta_title" => $faker->sentence(),
                    "meta_keywords" => "",
                    "meta_description" => $faker->sentence(),
                ];

                $lessonComponents = [
                    [
                        "component_name" => "title-text",
                        "fields" => [
                            "title" => $faker->sentence(),
                            "text" => $faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()
                        ]
                    ],
                    [
                        "component_name" => "image",
                        "fields" => [
                            "media" => [$detail->id]
                        ]
                    ],
                    [
                        "component_name" => "lists",
                        "fields" => [
                            "type" => "circle",
                            "title" => $faker->sentence(),
                            "list" => [
                                $faker->paragraph(),
                                $faker->paragraph(),
                                $faker->paragraph()
                            ]
                        ]
                    ],
                    [
                        "component_name" => "video",
                        "fields" => [
                            "link" => "https://www.youtube.com/embed/dl16e_mG6hg"
                        ]
                    ],
                    [
                        "component_name" => "text",
                        "fields" => [
                            "text" => $faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()
                        ]
                    ],
                ];

                $model = Lesson::create($lesson);

                for ($i = 0; $i < count($lessonComponents); $i++) {
                    $component = $lessonComponents[$i];

                    $component_model = Component::updateOrCreate([
                        "slug" => $component["component_name"]
                    ], [
                        "name" => $component_names[$component["component_name"]],
                        "fields" => array_keys($component['fields'])
                    ]);
                    $lesson_component_model = LessonComponent::create([
                        "lesson_id" => $model->id,
                        "component_id" => $component_model->id,
                        "sort" => $i * count($lessonComponents) + $i + 1,
                        "fields" => $component["fields"]
                    ]);
                    $fields = $component["fields"];
                    if (isset($fields['media'])) {
                        foreach ($fields['media'] as $key => $value) {
                            $fields['media'][$key] = $this->createImage($value, $lesson_component_model->id);
                        }
                    }

                    $lesson_component_model->fields = $fields;
                    $lesson_component_model->save();
                }

            }

        }

        return "OK";
    }

    public function createImage($attachment_id, $component_id)
    {
        $image = LessonMedia::create(compact('attachment_id', 'component_id'));
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
