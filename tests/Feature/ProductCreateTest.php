<?php

namespace Tests\Feature;

use App\Domains\Product\Models\Product;
use App\Domains\Product\Models\ProductsBox;
use App\Domains\Product\Models\ProductsBoxValue;
use App\Domains\Product\Models\ProductsGroup;
use App\Domains\Product\Models\ProductsOption;
use App\Domains\Product\Models\ProductsOptionsValue;
use App\Domains\Product\Models\ProductsProperty;
use App\Domains\Product\Models\ProductsTranslation;
use App\Domains\Product\Models\ProductsImage;
use App\Domains\Product\Models\ProductsVariant;
use App\Domains\Product\Models\RefChar;
use App\Domains\Product\Models\RefCharsTranslation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Log;
use Tests\TestCase;

class ProductCreateTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function create_products($count = 3) : Collection
    {
        return Product::factory()->count($count)->create();
    }


    /**
     * create_product_with_options
     * @test
     * @return void
     */
    public function create_product_options()
    {
        $options = ProductsOption::factory()->count(3)->create();
        $this->assertTrue($options->count() == 3);
    }



    /**
     * create_product_options_with_product
     * @test
     * @return void
     */
    public function create_product_options_with_product()
    {
        $options_values = [];
        $products = Product::factory()->count(3)->create();
        $products->each(function ($product) use (&$options_values) {
            $opts = ProductsOption::factory()->count(3)->state([
                'course_id' => $product->id
            ])->create();

            $opts->each(function ($opt) use (&$options_values) {
                $options_values[] = ProductsOptionsValue::factory()->state([
                    'products_option_id' => $opt->id
                ])->create()->toArray();
            });
        });

        $this->assertTrue(count($options_values) == 9);
    }


    /**
     * create_product_with_properies
     * @test
     * @return void
     */
    public function create_product_with_properies()
    {
        $properies_values = [];
        $products = Product::factory()->count(3)->create();

        $products->each(function ($product) use (&$properies_values) {
            $properies_values[] = ProductsProperty::factory()->state([
                'course_id' => $product->id
            ])->count(3)->create();
        });

        foreach ($properies_values as $key => $value) {
            $this->assertTrue($value->count() == 3);
        }
    }





    /**
     * create_product_with_images_and_translates
     * @test
     * @return void
     */
    public function create_product_with_images_and_translates()
    {
        $images_translates = [];
        $products = Product::factory()->count(3)->create();

        $products->each(function ($product) use (&$images_translates) {
            $images = ProductsImage::factory()->state([
                'course_id' => $product->id
            ])->count(4)->create();
            $images_translates[] = [
                'translates' => ProductsTranslation::factory()->state([
                    'course_id' => $product->id
                ])->create()->toArray(),
                'images' => $images
            ];
        });
        foreach ($images_translates as $key => $value) {
            $value['images']->each(function($image){
                $image->attachment->delete();
            });
        }
        
        

        $this->assertTrue(count($images_translates) == 3);
    }




    /**
     * create_product_with_variants
     * @test
     * @return void
     */
    public function create_product_with_variants()
    {
        $variants = [];
        $products = $this->create_products();
        // Log::info($products);
        $products->each(function ($product) use (&$variants) {
            $variants[] = ProductsVariant::factory()->state([
                'course_id' => $product->id
            ])->count(5)->create();
        });

        $this->assertTrue(count($variants) == 3);
    }



    
    /**
     * create_chars_with_translation
     * @test
     * @return void
     */
    public function create_chars_with_translation()
    {
        $chars = RefChar::factory()->count(5)->create();
        $chars->each(function($item) {
            $translation = RefCharsTranslation::factory()->state([
                'char_id' => $item->id
            ])->create();
            

            $this->assertTrue($translation->char_id == $item->id);
        });
    }

    
    /**
     * create_chars_translation
     * @test
     * @return void
     */
    public function create_chars_translation()
    {
        $translations = RefCharsTranslation::factory()->count(5)->create();

        $translations->each(function($item){
            $this->assertFalse($item->id == null);
        });

        $this->assertTrue($translations->count() == 5);
    }



    
    /**
     * create_product_box_with_values
     * @test
     * @return void
     */
    public function create_product_box_with_values()
    {
        $groups = ProductsGroup::all();
        if($groups->count() == 0){
            $groups = ProductsGroup::factory()->count(3)->create();
        }

        $groups->each(function($item){
            $box = ProductsBox::factory()->state([
                'products_group_id' => $item->id
            ])->create();

            $box_values = ProductsBoxValue::factory()->state([
                'products_box_id' => $box->id
            ])->count(2)->create();

            $box_values->each(function($value) use ($box) {
                $this->assertTrue($value->products_box_id == $box->id);
            });

        });
    }
}
