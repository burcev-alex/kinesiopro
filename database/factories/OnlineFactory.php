<?php

namespace Database\Factories;

use App\Domains\Online\Models\Online;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class OnlineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Online::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->date().'10:00:00';
        $rand = $this->faker->numberBetween(2, 5);

        $finish = null;
        if(rand(0, 1) == 1){
            $finish = date('Y-m-d', strtotime($date) + (60*60*24*$rand)).' 17:00:00';
        }

        $type = [
            'marafon',
            'course',
            'webinar',
            'video',
            'conference'
        ];

        try {
            return [
                "title" => implode(' ', $this->faker->words(10)),
                "slug" => Str::slug($this->faker->slug(3)),
                "attachment_id" => $this->storageAttachment(305,305),
                "sort" => rand(100, 1000),
                "price" => rand(1200, 10000),
                "type" => $type[rand(0, 2)],
                "active" => 1,
                "start_date" => $date,
                'finish_date' => $finish,
                'preview' => $this->faker->sentence(),
                'meta_h1' => $this->faker->sentence(2),
                'meta_title' => $this->faker->sentence(2),
                'meta_keywords' => implode(' ', $this->faker->words(6)),
                'meta_description' => $this->faker->sentence(),
            ];
        } catch (\Throwable $th) {
            echo 'Message: ' . $th->getMessage();
        }
    }

    private function storageAttachment(int $width = 1920, int $height = 720) :int
    {
        Storage::disk('public')->makeDirectory('t');
        $src = "image" . $this->faker->numberBetween(2000, 3000) .".jpg";
        $url = "https://unsplash.it/". $width ."/". $height ."?random";
        Storage::disk('public')->put("t" . DIRECTORY_SEPARATOR . $src, file_get_contents($url));
        $uploaded = new UploadedFile(public_path("storage" . DIRECTORY_SEPARATOR . "t" . DIRECTORY_SEPARATOR . $src), $src);
        $file = new File($uploaded, 'public');
        $attach = $file->load();

        if (Storage::disk('public')->exists("t/")) {
            Storage::disk('public')->deleteDirectory("t/");
        }
        return $attach->id;
    }
}
