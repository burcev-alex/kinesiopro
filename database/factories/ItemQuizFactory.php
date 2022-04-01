<?php

namespace Database\Factories;

use App\Domains\Quiz\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class ItemQuizFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        try {
            return [
                "title" => implode(' ', $this->faker->words(10)),
                "slug" => Str::slug($this->faker->slug(3)),
                "attachment_id" => $this->storageAttachment(800,400),
                "detail_attachment_id" => $this->storageAttachment(415,200),
                'preview' => $this->faker->sentence(),
                'description' => implode('<br>', $this->faker->paragraphs(5)),
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
