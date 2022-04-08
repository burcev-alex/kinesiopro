<?php

namespace App\Domains\Teacher\Http\Controllers\Web;

use App\Domains\Teacher\Services\BreadcrumbsService;
use App\Domains\Teacher\Services\TeachersService;
use App\Services\RouterService;
use Illuminate\Http\Request;

class TeacherController
{
    protected RouterService $routerService;
    protected TeachersService $teacherService;

    public function __construct(RouterService $routerService, TeachersService $teacherService)
    {
        $this->routerService = $routerService;
        $this->teacherService = $teacherService;
    }

    /**
     * Список преподавателей
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

        // доступные преподаватели
        $teachers = $this->teacherService->getList($page);

        $pagination = $this->routerService->getPagination($teachers->currentPage(), $teachers->lastPage());
        if ($request->wantsJson()) {
            return [
                'resource' => [
                    'html' => view('includes.teacher.grid', ['teachers' => $teachers])->render(),
                ],
                'pagination' => [
                    'html' => view('includes.pagination', [
                        'pagination' => $pagination,
                        'block' => 'teacher-page-block'
                    ])->render(),
                ],
            ];
        }

        // мета теги для категорий
        $meta = [];
        $meta['meta_title'] = __('main.meta.teacher_title');
        $meta['meta_h1'] = __('main.meta.teacher_h1');
        $meta['meta_description'] = __('main.meta.teacher_description');

        return view('pages.teacher.teacher-list', [
            'meta' => $meta,
            'teachers' => $teachers,
            'pagination' => $pagination,
            'blockId' => 'teacher-page-block'
        ]);
    }

    /**
     * Show teacher details
     *
     * @param string $slug
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        $teacher = $this->teacherService->getBySlug($slug);

        if (!$teacher) {
            return abort(404);
        }

        // Хлебные крошки
        BreadcrumbsService::card($teacher);

        return view('pages.teacher.teacher-single', [
            'teacher' => $teacher
        ]);
    }
}
