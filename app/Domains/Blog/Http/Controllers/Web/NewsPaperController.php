<?php

namespace App\Domains\Blog\Http\Controllers\Web;

use App\Domains\Blog\Services\BreadcrumbsService;
use App\Domains\Blog\Services\NewsPaperService;
use App\Services\RouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class NewsPaperController
{
    protected RouterService $routerService;
    protected NewsPaperService $newsService;

    public function __construct(RouterService $routerService, NewsPaperService $newsService)
    {
        $this->routerService = $routerService;
        $this->newsService = $newsService;
    }

    /**
     * Show history of orders
     */
    public function index(Request $request, $param1 = null, $param2 = null, $param3 = null)
    {
        list($filters, $page) = $this->routerService->detectParameters([$param1, $param2, $param3]);

        // всего кол-во статей
        $countArticles = $this->newsService->where('active', true)->get()->count();
        
        if(!$page){
            $page = 1;
        }
        if(!$filters){
            $filters = "";
        }

        // доступные статьи
        $articles = $this->newsService->getArticles($filters, $page);

        // выбранные значение фильтра
        $selectedFilters = $this->newsService->getSelectedFilters();

        $pagination = $this->routerService->getPagination($articles->currentPage(), $articles->lastPage());
        if ($request->wantsJson()) {
            return [
                'resource' => [
                    'html' => view('includes.blog.items', ['articles' => $articles])->render(),
                ],
                'pagination' => [
                    'html' => view('includes.pagination', [
                        'pagination' => $pagination,
                        'block' => 'blog-page-block'
                    ])->render(),
                ]
            ];
        }

        // мета теги для категорий
        $meta = [];
        $meta['meta_title'] = __('main.meta.blog_title');
        $meta['meta_h1'] = __('main.meta.blog_h1');
        $meta['meta_description'] = __('main.meta.blog_description');

        return view('pages.blog.blog-list', [
            'meta' => $meta,
            'articles' => $articles,
            'selectedFilters' => $selectedFilters,
            'pagination' => $pagination,
            'count' => $countArticles,
            'blockId' => 'blog-page-block'
        ]);
    }

    /**
     * Show order details
     */
    public function show($slug, Request $request)
    {
        list($news_paper, $components) = $this->newsService->showArticleDetails($slug);

        if (!$news_paper)
            return abort(404);

        // Хлебные крошки
        BreadcrumbsService::card($news_paper);

        return view('pages.blog.blog-single', [
            'news_paper' => $news_paper,
            'components' => $components,
            'tags' => $tags
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function count(Request $request)
    {
        return response()->json([
            'count' => $this->newsService->where('active', true)->get()->count()
        ]);
    }
}
