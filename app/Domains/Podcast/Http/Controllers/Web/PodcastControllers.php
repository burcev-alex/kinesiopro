<?php
namespace App\Domains\Podcast\Http\Controllers\Web;

use App\Domains\Podcast\Models\Podcast;
use App\Domains\Podcast\Services\BreadcrumbsService;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;
use App\Http\Controllers\Controller;
use App\Services\RouterService;
use App\Domains\Podcast\Services\CatalogFilterService;
use App\Domains\Podcast\Services\PodcastService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PodcastControllers extends Controller
{
    protected PodcastService $podcastService;

    
    public function __construct(
        PodcastService $podcastService,
        RouterService $routerService
    )
    {
        $this->routerService = $routerService;
        $this->podcastService = $podcastService;
    }

    public function index(Request $request, string $param1 = '')
    {
        // установка типа отображения подкастов
        if(!$request->view){
            $typeView = Cookie::get('podcast_view') ?? 'grid';
        }
        else{
            $typeView = $request->view;
            Cookie::queue('podcast_view', $typeView, 60*60*24);
        }
        

        list($category, $filters, $page) = $this->routerService->detectParameters(['', '', $param1]);
        
        if (!$page) {
            $page = 1;
        }
        
        $catalog = $this->podcastService->getCatalog($page);
         
        $pagination = $this->routerService->getPagination($catalog->currentPage(), $catalog->lastPage());

        if ($request->wantsJson()) {
            return [
                'resource' => [
                    'html' => view('includes.podcast.'.$typeView, ['podcasts' => $catalog])->render(),
                ],
                'pagination' => [
                    'html' => view('includes.pagination', [
                        'pagination' => $pagination,
                        'block' => 'podcast-grid-block'
                    ])->render(),
                ],
            ];
        }
        
        return view('pages.podcast.podcast-list', [
            'type' => $typeView,
            'podcasts' => $catalog,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Show podcast details
     */
    public function show($slug)
    {
        $podcast = $this->podcastService->getBySlug($slug);

        if (!$podcast) {
            return abort(404);
        }

        // Хлебные крошки
        BreadcrumbsService::card($podcast);

        return view('pages.podcast.podcast-single', [
            'podcast' => $podcast,
        ]);
    }
}
