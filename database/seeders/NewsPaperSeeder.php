<?php
namespace Database\Seeders;

use App\Domains\Blog\Models\Component;
use App\Domains\Blog\Models\NewsPaper;
use App\Domains\Blog\Models\NewsPaperComponent;
use App\Domains\Blog\Models\NewsPaperMedia;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Faker\Generator;
use Illuminate\Container\Container;

class NewsPaperSeeder extends Seeder
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

        // Schema::disableForeignKeyConstraints();

        for($iteration=1; $iteration<=50; $iteration++){
            $attach = $this->getImage(800, 500);
            $attachDetail = $this->getImage(200, 200);
            $news = [
                [
                    "title" => $faker->sentence(),
                    "attachment_id" => $attach->id,
                    "detail_attachment_id" => $attachDetail->id,
                    "publication_date" => $faker->date(),
                    "slug" => "news-".rand(1000, 100000000),
                    "meta_title" => $faker->sentence(),
                    "meta_keywords" => "",
                    "meta_description" => $faker->sentence(),
                ]
            ];

            $newsComponents = [
                [
                    "component_name" => "title-text",
                    "fields" => [
                        "title" => $faker->sentence(),
                        "text" => $faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()
                    ]
                ],
                [
                    "component_name" => "lists",
                    "fields" => [
                        "type" => "circle",
                        "title" => $faker->sentence(),
                        "list" => [
                            "Дальнейшее развитие различных форм деятельности требует определения и уточнения кластеризации усилий. ",
                            "Дальнейшее развитие различных форм деятельности требует определения и уточнения кластеризации усилий. ",
                            "Дальнейшее развитие различных форм деятельности требует определения и уточнения кластеризации усилий. ",
                            "Дальнейшее развитие различных форм деятельности требует определения и уточнения кластеризации усилий. "
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
                [
                    "component_name" => "text-citation",
                    "fields" => [
                        "text" => "Дальнейшее развитие различных форм деятельности требует определения и уточнения кластеризации усилий. Сложно сказать, почему некоторые особенности внутренней политики набирают популярность среди определенных слоев населения, а значит, должны быть преданы. ",
                        "autor" => "Dries Van Noten"
                    ]
                ],
                [
                    "component_name" => "image",
                    "fields" => [
                        "media" => [$attach->id]
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
                [
                    "component_name" => "text",
                    "fields" => [
                        "text" => $faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()." ".$faker->paragraph()
                    ]
                ],
                [
                    "component_name" => "image",
                    "fields" => [
                        "media" => [$attach->id]
                    ]
                ]
            ];

            foreach ($news as $key => $value) {

                $model = NewsPaper::create($value);

                for ($i = 0; $i < count($newsComponents); $i++) {
                    $component = $key == 0 ? $newsComponents[$i] : $newsComponents[count($newsComponents) - $i - 1];

                    $component_model = Component::updateOrCreate([
                        "slug" => $component["component_name"]
                    ], [
                        "name" => $component_names[$component["component_name"]],
                        "fields" => array_keys($component['fields'])
                    ]);
                    $news_paper_component_model = NewsPaperComponent::create([
                        "news_paper_id" => $model->id,
                        "component_id" => $component_model->id,
                        "sort" => $key * count($newsComponents) + $i + 1,
                        "fields" => $component["fields"]
                    ]);
                    $fields = $component["fields"];
                    if (isset($fields['media'])) {
                        foreach ($fields['media'] as $key => $value) {
                            $fields['media'][$key] = $this->createImage($value, $news_paper_component_model->id);
                        }
                    }

                    $news_paper_component_model->fields = $fields;
                    $news_paper_component_model->save();
                }
            }

        }
        
        // Schema::enableForeignKeyConstraints();

        return "OK";
    }

    public function createImage($attachment_id, $component_id)
    {
        $image = NewsPaperMedia::create(compact('attachment_id', 'component_id'));
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
