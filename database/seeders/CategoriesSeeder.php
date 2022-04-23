<?php
namespace Database\Seeders;

use App\Domains\Category\Models\CategoriesTranslation;
use App\Domains\Category\Models\Category;
use Database\Factories\CategoryTranslationFactory;
use Faker as Generation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Illuminate\Support\Facades\Storage;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $arData = [
            [
                'slug' => 'rehab-team',
                'name' => 'REHABTeam',
            ],
            [
                'slug' => 'tematic-course',
                'name' => 'Тематические курсы',
            ],
            [
                'slug' => 'maitland',
                'name' => 'Maitland',
            ],
            [
                'slug' => 'bohath',
                'name' => 'Bohath',
            ],
            [
                'slug' => 'pnf',
                'name' => 'PNF',
            ],
            [
                'slug' => 'neyrodinamika',
                'name' => 'Нейродинамика',
            ],
        ];

        foreach ($arData as $key => $arCategory) {
            Category::factory()->create([
                'active' => 1,
                'sort' => ($key + 1) * 100,
                'slug' => $arCategory['slug'],
                'name' => $arCategory['name'],
            ]);
        }
    }
}
