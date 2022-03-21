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
        $this->call(TeacherSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(RefCharSeeder::class);
        $this->call(CoursesSeeder::class);
        $this->call(CoursesPropsSeeder::class);
        
        // Model::reguard();
        Artisan::call('orchid:admin admin admin@kinesiopro.ru 123456');
    }
}
