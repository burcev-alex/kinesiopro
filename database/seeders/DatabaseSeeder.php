<?php

namespace Database\Seeders;

use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        
        
        $this->call(BannerSeeder::class);
        $this->call(CategoriesSeeder::class);
        
        // Model::reguard();
        Artisan::call('orchid:admin admin admin@kinesiopro.ru 123456');
    }
}
