<?php

namespace App\Console\Commands;

use App\Domains\Course\Models\Course;
use App\Domains\Online\Models\Online;
use App\Domains\Podcast\Models\Podcast;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Carbon\Carbon;

class SiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $static = [
            [
                'url' => str_replace(app('config')->get('app.url'), app('config')->get('app.url'), route('home')),
                'updated_at' => new Carbon(time())
            ]
        ];

        $courses = Course::where('active', true)->get();
        foreach($courses as $course){
            $static[] = [
                'url' => app('config')->get('app.url').route('courses.card', ['slug' => $course->slug]),
                'updated_at' => new Carbon(time())
            ];
        }

        $onlines = Online::where('active', true)->get();
        foreach($onlines as $online){
            $static[] = [
                'url' => app('config')->get('app.url').route('online.single', ['slug' => $online->slug]),
                'updated_at' => new Carbon(time())
            ];
        }

        $news = Online::where('active', true)->get();
        foreach($news as $article){
            $static[] = [
                'url' => app('config')->get('app.url').route('blog.single', ['slug' => $article->slug]),
                'updated_at' => new Carbon(time())
            ];
        }

        $podcasts = Podcast::where('active', true)->get();
        foreach($podcasts as $podcast){
            $static[] = [
                'url' => app('config')->get('app.url').route('podcast.single', ['slug' => $podcast->slug]),
                'updated_at' => new Carbon(time())
            ];
        }

        $xml = view('export.sitemap', compact('static'))->render();

        return Storage::disk('public_html')->put('sitemap.xml', $xml);
    }
}
