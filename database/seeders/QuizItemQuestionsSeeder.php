<?php
namespace Database\Seeders;

use App\Domains\Quiz\Models\Item;
use App\Domains\Quiz\Models\ItemQuestion;
use App\Domains\Quiz\Models\Question;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;

class QuizItemQuestionsSeeder extends Seeder
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
            "element-comment" => "Вопрос с комментарием",
            "simple-element" => "Простой вопрос",
        ];

        $quizs = Item::all();
        $quizs->each(function ($quiz) use($faker, $component_names) {

            $newsComponents = [];

            for($i=0; $i<rand(5, 10); $i++){
                
                $elQuestion = [
                    "component_name" => "simple-element",
                    "fields" => [
                        "title" => "Question: ".$faker->sentence(),
                        "list" => [
                            "answer" => [
                                $faker->sentence(),
                                $faker->sentence(),
                                $faker->sentence(),
                                $faker->sentence(),
                                $faker->sentence(),
                                $faker->sentence()
                            ],
                            "point" => [
                                "0",
                                "1",
                                "2",
                                "3",
                                "4",
                                "5"
                            ]
                        ]
                    ]
                ];
                
                $newsComponents[] = $elQuestion;
            }

            $key = 0;
            for ($i = 0; $i < count($newsComponents); $i++) {
                $component = $key == 0 ? $newsComponents[$i] : $newsComponents[count($newsComponents) - $i - 1];


                $component_model = Question::updateOrCreate([
                    "slug" => $component["component_name"]
                ], [
                    "name" => $component_names[$component["component_name"]]
                ]);
                $quiz_component_model = ItemQuestion::create([
                    "item_id" => $quiz->id,
                    "question_id" => $component_model->id,
                    "sort" => $key * count($newsComponents) + $i + 1,
                    "fields" => $component["fields"]
                ]);

                $key++;
            }
        });
    }
}
