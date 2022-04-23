<?php

namespace Tests\Feature;

use App\Domains\Product\Models\Product;
use App\Domains\Product\Models\ProductsGroup;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Log;
use Tests\TestCase;

/**
 * очень тупые тесты, но пусть будут ..
 */
class RelationshipTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * product_option_relation
     * @test
     * @return void
     */
    public function product_option_relation()
    {
        $product = Product::factory()->hasOptions(3)->create();
        $product->options->each(function($option) use($product) {
            $this->assertTrue($option->course_id == $product->id);
        });
    }
    
    /**
     * product_group_test
     * @test
     * @return void
     */
    public function product_group_test()
    {
        $group = ProductsGroup::factory()->create();
        $product = Product::factory()->for($group, 'group')->create();
        $this->assertTrue($group->id == $product->group_id);
    }

}
