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

class PodcastControllers extends Controller {
    protected PodcastService $podcastService;

    
    public function __construct(
        PodcastService $podcastService,
        RouterService $routerService)
    {
        $this->routerService = $routerService;
        $this->podcastService = $podcastService;
    }

    public function index(string $param1 = '')
    {
       
        list($page) = $this->routerService->detectParameters([$param1]);
        
        $catalog = $this->podcastService->getCatalog($page);
         
        $pagination = $this->routerService->getPagination($catalog->currentPage(), $catalog->lastPage());
        
        return view('pages.podcast.list', [
            'podcasts' => $catalog,
            'pagination' => $pagination,
            'selectedCourses' => $catalog->total()
        ]);

    }

    /**
     * Show podcast details
     */
    public function show($slug)
    {
        $podcast = $this->podcastService->getBySlug($slug);

        if (!$podcast)
            return abort(404);

        // Хлебные крошки
        BreadcrumbsService::card($podcast);

        return view('pages.podcast.detail', [
            'podcast' => $podcast
        ]);
    }
}