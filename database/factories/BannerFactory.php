<?php

namespace Database\Factories;

use App\Domains\Banner\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;

class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand = rand(10, 25);
        try {
            return [
                "name" => implode(' ', $this->faker->words(6)),
                "time_organization" => $rand."-".($rand+3)." ".date("F", strtotime($this->faker->date())),
                "place" => implode(' ', $this->faker->words(2)),
                "description" => implode(' ', $this->faker->words(4)),
                "attachment_id" => $this->storageAttachment(1280,440),
                "attachment_mobile_id" => $this->storageAttachment(292,350),
                "sort" => 100,
                "active" => 1,
            ];
        } catch (\Throwable $th) {
            echo 'Message: ' . $th->getMessage();
        }
    }

    private function storageAttachment(int $width = 1920, int $height = 720) :int
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
