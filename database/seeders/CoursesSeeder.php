<?php
namespace Database\Seeders;

use App\Domains\Category\Models\CategoriesTranslation;
use App\Domains\Category\Models\Category;
use App\Domains\Course\Models\Course;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Models\ProductsImage;
use App\Domains\Product\Models\ProductsOption;
use App\Domains\Product\Models\ProductsOptionsValue;
use App\Domains\Product\Models\ProductsProperty;
use App\Domains\Product\Models\ProductsTranslation;
use App\Domains\Product\Models\ProductsVariant;
use App\Domains\Product\Models\ProductsVariantsValue;
use App\Domains\Product\Models\ProductApplicability;
use App\Domains\Product\Models\RefChar;
use App\Domains\Product\Models\RefCharsTranslation;
use App\Domains\Product\Models\RefCharsValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Log;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<100; $i++){
            Course::factory()->create();
        }
    }
}
