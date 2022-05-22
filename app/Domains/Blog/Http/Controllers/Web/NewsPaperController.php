<?php

namespace App\Domains\Blog\Http\Controllers\Web;

use App\Domains\Blog\Services\BreadcrumbsService;
use App\Domains\Blog\Services\NewsPaperService;
use App\Services\RouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Mobile_Detect;

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
     * Список новостей блога
     *
     * @param Request $request
     * @param string $param1
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, $param1 = null)
    {
        list($category, $filters, $page) = $this->routerService->detectParameters(['', '', $param1]);

        if (!$page) {
            $page = 1;
        }
        if (!$filters) {
            $filters = "";
        }

        $detect = new Mobile_Detect();

        if($detect->isMobile()){
            $perPage = 8;
        }
        else if($detect->isTablet()){
            $perPage = 8;
        }
        else{
            $perPage = 9;
        }

        // доступные статьи
        $articles = $this->newsService->getArticles($filters, $page, $perPage);

        $pagination = $this->routerService->getPagination($articles->currentPage(), $articles->lastPage());
        if ($request->wantsJson()) {
            return [
                'resource' => [
                    'html' => view('includes.blog.items', ['articles' => $articles])->render(),
                ],
                'pagination' => [
                    'html' => view('includes.pagination', [
                        'pagination' => $pagination,
                        'block' => 'blog-grid-block'
                    ])->render(),
                ],
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
            'pagination' => $pagination,
            'blockId' => 'blog-page-block'
        ]);
    }

    /**
     * Show order details
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        list($news_paper, $components) = $this->newsService->showArticleDetails($slug);

        if (!$news_paper) {
            return abort(404);
        }

        // Хлебные крошки
        BreadcrumbsService::card($news_paper);

        return view('pages.blog.blog-single', [
            'news_paper' => $news_paper,
            'components' => $components,
        ]);
    }

    /**
     * Общее кол-во новостей
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function count()
    {
        return response()->json([
            'count' => $this->newsService->where('active', true)->get()->count(),
        ]);
    }
}
