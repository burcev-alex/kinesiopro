<?php

namespace App\Domains\Stream\Http\Controllers\Web;

use App\Domains\Stream\Services\BreadcrumbsService;
use App\Domains\Stream\Services\StreamService;
use App\Services\RouterService;
use Illuminate\Http\Request;

class VideoController
{
    protected RouterService $routerService;
    protected StreamService $streamService;

    public function __construct(RouterService $routerService, StreamService $streamService)
    {
        $this->routerService = $routerService;
        $this->streamService = $streamService;
    }

    /**
     * Список всех видеокурсов
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

        // доступные курсы
        $articles = $this->streamService->getArticles($filters, $page);

        $pagination = $this->routerService->getPagination($articles->currentPage(), $articles->lastPage());
        if ($request->wantsJson()) {
            return [
                'resource' => [
                    'html' => view('includes.video.grid', ['articles' => $articles])->render(),
                ],
                'pagination' => [
                    'html' => view('includes.pagination', [
                        'pagination' => $pagination,
                        'block' => 'video-grid-block'
                    ])->render(),
                ],
            ];
        }

        // мета теги для категорий
        $meta = [];
        $meta['meta_title'] = __('main.meta.video_title');
        $meta['meta_h1'] = __('main.meta.video_h1');
        $meta['meta_description'] = __('main.meta.video_description');

        return view('pages.video.video-list', [
            'meta' => $meta,
            'articles' => $articles,
            'pagination' => $pagination,
            'blockId' => 'video-page-block'
        ]);
    }

    /**
     * Show course details
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        list($stream, $lessons) = $this->streamService->showArticleDetails($slug);

        if (!$stream) {
            return abort(404);
        }

        // Хлебные крошки
        BreadcrumbsService::card($stream);

        return view('pages.video.video-single', [
            'stream' => $stream,
            'lessons' => $lessons,
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
            'count' => $this->streamService->where('active', true)->get()->count(),
        ]);
    }
}
