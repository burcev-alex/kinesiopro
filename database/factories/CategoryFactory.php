<?php

namespace Database\Factories;

use App\Domains\Category\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Illuminate\Support\Facades\Storage;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "active" => 1,
            "slug" => $this->faker->slug(2),
            "sort" => 100,
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'meta_h1' => $this->faker->sentence(2),
            'meta_title' => $this->faker->sentence(2),
            'meta_keywords' => implode(' ', $this->faker->words(6)),
            'meta_description' => $this->faker->sentence(),
            "attachment_id" => $this->storageAttachment(200,200)
        ];
    }

    private function storageAttachment(int $width = 200, int $height = 200) :int
    {
        Storage::disk('public')->makeDirectory('t');
        $src = "image" . $this->faker->numberBetween(100, 2000) .".jpg";
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
