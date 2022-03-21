<?php

namespace Database\Factories;

use App\Domains\Teacher\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        try {
            return [
                "full_name" => $this->faker->name(),
                "slug" => Str::slug($this->faker->slug(2)),
                "attachment_id" => $this->storageAttachment(265,300),
                "sort" => 100,
                "active" => 1,
                'description' => $this->faker->sentence(),
                'education' => $this->faker->sentence(),
                'certificates' => $this->faker->sentence(),
                'specialization' => $this->faker->sentence(),
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
