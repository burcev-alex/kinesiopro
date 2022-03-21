<?php
namespace Database\Seeders;

use App\Domains\Category\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\File;
use Illuminate\Database\Seeder;

class CategoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Сидер может тупить, т.к. ищет изображения по рандомному id, на который у lorempicsum может не быть изображения. 
        // Просто запустить еще раз, в случае провала сидера.
        Category::get()->each(function ($category) {
            Category::updateOrCreate([
                'id' => $category->id
            ], [
                'attachment_id' => $this->storageAttachment($category->slug, 200, 200),
            ]);
        });
    }

    private function storageAttachment($st = '', int $width = 400, int $height = 400) :int
    {
        Storage::disk('public')->makeDirectory('t');
        $src = "image" . $st .".jpg";
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
