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
                'slug' => 'Тематические курсы',
                'name' => 'tematic-course',
            ],
            [
                'slug' => 'Maitland',
                'name' => 'maitland',
            ],
            [
                'slug' => 'Bohath',
                'name' => 'bohath',
            ],
            [
                'slug' => 'PNF',
                'name' => 'pnf',
            ],
            [
                'slug' => 'Нейродинамика',
                'name' => 'neyrodinamika',
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
