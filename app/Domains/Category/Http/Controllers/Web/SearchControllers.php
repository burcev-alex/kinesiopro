<?php
namespace App\Domains\Category\Http\Controllers\Web;

use App\Domains\Blog\Models\NewsPaper;
use App\Domains\Course\Models\Course;
use App\Domains\Online\Models\Online;
use Tabuna\Breadcrumbs\Trail;
use App\Http\Controllers\Controller;
use App\Services\RouterService;
use Illuminate\Http\Request;

class SearchControllers extends Controller
{
    public function index(Request $request)
    {
        $text = $request->get('q');

        $items = [];

        if (strlen($text) > 0) {
            // поиск очных курсов
            $courses = Course::active()
                ->where('name', 'LIKE', "%$text%")
                ->orWhere('price', 'LIKE', "%$text%")
                ->get();
            foreach ($courses as $course) {
                $content = $course->name;
                $content = str_replace($text, '<span>'.$text.'</span>', $content);

                $items[] = [
                    'type' => 'course',
                    'url' => route('courses.card', ['slug' => $course->slug]),
                    'content' => $content,
                ];
            }

            // поиск онлайн курсов
            $onlines = Online::active()
                ->where('title', 'LIKE', "%$text%")
                ->orWhere('preview', 'LIKE', "%$text%")
                ->get();
            foreach ($onlines as $online) {
                $content = $online->title.". ";
                $content .= $online->preview;
                $content = str_replace($text, '<span>'.$text.'</span>', $content);

                $items[] = [
                    'type' => 'online',
                    'url' => route('online.single', ['slug' => $online->slug]),
                    'content' => $content,
                ];
            }

            // поиск статей в блоге
            $articles = NewsPaper::active()
                ->where('title', 'LIKE', "%$text%")
                ->get();
            foreach ($articles as $article) {
                $content = $article->title;
                $content = str_replace($text, '<span>'.$text.'</span>', $content);

                $items[] = [
                    'type' => 'articles',
                    'url' => route('blog.single', ['slug' => $article->slug]),
                    'content' => $content,
                ];
            }
        }
       
        return view('pages.search', [
            'q' => $text,
            'items' => $items,
        ]);
    }
}
