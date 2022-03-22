<?php

namespace App\Domains\Quiz\Http\Controllers\Web;

use App\Domains\Quiz\Services\BreadcrumbsService;
use App\Domains\Quiz\Services\QuizItemService;
use App\Services\RouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class QuizItemController
{
    protected RouterService $routerService;
    protected QuizItemService $quizService;

    public function __construct(RouterService $routerService, QuizItemService $quizService)
    {
        $this->routerService = $routerService;
        $this->quizService = $quizService;
    }

    /**
     * Show history of orders
     */
    public function index(Request $request, $param1 = null)
    {
        list($page) = $this->routerService->detectParameters([$param1]);

        // всего кол-во статей
        $countArticles = $this->quizService->where('active', true)->get()->count();
        
        if(!$page){
            $page = 1;
        }

        // доступные тесты
        $articles = $this->quizService->getList($page);

        $pagination = $this->routerService->getPagination($articles->currentPage(), $articles->lastPage());
        if ($request->wantsJson()) {
            return [
                'resource' => [
                    'html' => view('includes.quiz.items', ['articles' => $articles])->render(),
                ],
                'pagination' => [
                    'html' => view('includes.pagination', [
                        'pagination' => $pagination,
                        'block' => 'quiz-page-block'
                    ])->render(),
                ]
            ];
        }

        // мета теги для категорий
        $meta = [];
        $meta['meta_title'] = __('main.meta.quiz_title');
        $meta['meta_h1'] = __('main.meta.quiz_h1');
        $meta['meta_description'] = __('main.meta.quiz_description');

        return view('pages.quiz.quiz-list', [
            'meta' => $meta,
            'articles' => $articles,
            'pagination' => $pagination,
            'count' => $countArticles,
            'blockId' => 'quiz-page-block'
        ]);
    }

    /**
     * Show order details
     */
    public function show($slug, Request $request)
    {
        list($quiz_item, $components) = $this->quizService->showItemDetails($slug);

        if (!$quiz_item)
            return abort(404);

        // Хлебные крошки
        BreadcrumbsService::card($quiz_item);

        return view('pages.quiz.quiz-single', [
            'quiz_item' => $quiz_item,
            'components' => $components
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function count(Request $request)
    {
        return response()->json([
            'count' => $this->quizService->where('active', true)->get()->count()
        ]);
    }
}
