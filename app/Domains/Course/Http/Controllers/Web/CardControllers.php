<?php
namespace App\Domains\Course\Http\Controllers\Web;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Services\BreadcrumbsService;
use App\Domains\Course\Services\CoursePropertiesService;
use App\Domains\Course\Services\CourseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;
use function Symfony\Component\String\b;

class CardControllers extends Controller {

    protected CourseService $courseService;
    protected CoursePropertiesService $coursePropertiesService;

    /**
     * @param CourseService $courseService
     * @param CoursePropertiesService $coursePropertiesService
     */
    public function __construct(CourseService $courseService, CoursePropertiesService $coursePropertiesService)
    {
        $this->courseService = $courseService;
        $this->coursePropertiesService = $coursePropertiesService;
    }

    /**
     * Get course by id
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug) {
              
        /** @var Course $course */
        $course = $this->courseService->show($slug);
        
        if (!$course) {
            abort(404);
        }

        // Хлебные крошки
        BreadcrumbsService::card($course);

        $seo = [
            'course' => [
                'availability' => $course->marker_archive ? 'discontinued' : 'in stock',
                'title' => $course->name,
                'link' => route('courses.card', ['slug' => $course->slug]),
                'price' => $course->marker_archive ? "0 RUB" : round($course->price, 2)." RUB",
                'condition' => $course->marker_archive ? '' : 'new',
                'currency' => 'RUB',
                'brand' => 'Kinesiopro',
            ]
        ];

        if(!empty($course) && $course->meta_h1){
            $seo['h1'] = $course->meta_h1;
        } else {
            $seo['h1'] = $course->name;
        }

        if(!empty($course) && $course->meta_title){
            $seo['title'] = $course->meta_title;
        } else {
            $seo['title'] = $course->name;
        }

        if(!empty($course) && $course->meta_description){
            $seo['description'] = $course->meta_description;
        } else {
            $seo['description'] = $course->name;
        }

        if(!empty($course) && $course->meta_keywords){
            $seo['keywords'] = $course->meta_keywords;
        } else {
            $seo['keywords'] = '';
        }
        
        return view('pages.course.card', [
            'seo' => $seo,
            'course' => $course,
            'components' => $course->components,
            'generalProperties' => $this->coursePropertiesService->getGeneralProperties($course),
            'fullProperties' => $this->coursePropertiesService->getFullListDescription($course)
        ]);
    }
}
