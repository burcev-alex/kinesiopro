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
        $this->call(CoursesDescriptionSeeder::class);
        $this->call(CoursesBlocksSeeder::class);
        $this->call(CoursesTeachersSeeder::class);
        $this->call(NewsPaperComponentsSeeder::class);
        $this->call(NewsPaperSeeder::class);
        $this->call(QuizQuestionsSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(PodcastSeeder::class);
        $this->call(OnlineSeeder::class);
        $this->call(OnlinesDescriptionSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(QuizItemSeeder::class);
        $this->call(QuizItemQuestionsSeeder::class);
        $this->call(NotificationSeeder::class);
        
        // Model::reguard();
        Artisan::call('orchid:admin admin admin@kinesiopro.ru 123456');
    }
}
