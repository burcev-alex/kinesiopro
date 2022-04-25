<?php

namespace App\Domains\Stream\Http\Controllers\Web;

use App\Domains\Stream\Services\BreadcrumbsService;
use App\Domains\Stream\Services\StreamService;
use App\Http\Controllers\Controller;
use App\Http\Middleware\StreamAccess;
use App\Services\RouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    protected StreamService $streamService;

    public function __construct(StreamService $streamService)
    {
        $this->streamService = $streamService;

        $this->middleware(StreamAccess::class);
    }

    /**
     * Show lesson details
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($stream, $lessonId)
    {
        list($item, $lessons) = $this->streamService->showArticleDetails($stream);
        list($lesson, $components) = $this->streamService->showLessonDetails($lessonId);

        if (!$stream) {
            return abort(404);
        }

        // Хлебные крошки
        BreadcrumbsService::lesson($item, $lesson);

        return view('pages.video.video-lesson', [
            'stream' => $item,
            'lessons' => $lessons,
            'lesson' => $lesson,
            'components' => $components,
        ]);
    }
}
