<?php
namespace App\Domains\Online\Http\Controllers\Web;

use App\Domains\Online\Models\Online;
use App\Domains\Online\Services\BreadcrumbsService;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;
use App\Http\Controllers\Controller;
use App\Services\RouterService;
use App\Domains\Online\Services\OnlineService;
use Illuminate\Http\Request;

class OnlineControllers extends Controller
{
    protected OnlineService $onlineService;

    
    public function __construct(
        OnlineService $onlineService,
        RouterService $routerService
    )
    {
        $this->routerService = $routerService;
        $this->onlineService = $onlineService;
    }

    public function index(Request $request, string $param1 = '', string $param2 = '')
    {
       
        list($category, $filters, $page) = $this->routerService->detectParameters([$param1, '', $param2]);
        
        if (!$page) {
            $page = 1;
        }
        
        $catalog = $this->onlineService->getCatalog($category, $page);
         
        $pagination = $this->routerService->getPagination($catalog->currentPage(), $catalog->lastPage());

        if ($request->wantsJson()) {
            return [
                'resource' => [
                    'html' => view('includes.online.grid', ['onlines' => $catalog])->render(),
                ],
                'pagination' => [
                    'html' => view('includes.pagination', [
                        'pagination' => $pagination,
                        'block' => 'online-grid-block'
                    ])->render(),
                ],
            ];
        }

        if($category == 'video'){
            $title = 'Видеокурсы';
        }
        if($category == 'marafon'){
            $title = 'Марафоны';
        }
        else if($category == 'course'){
            $title = 'Очные курсы';
        }
        else if($category == 'conference'){
            $title = 'Конференции';
        }
        else if($category == 'webinar'){
            $title = 'Вебинары';
        }
        else if($category == 'video'){
            $title = 'Видеокурсы';
        }
        else{
            $title = __('main.meta.online_h1');
        }

        // Онлайн курсы
        Breadcrumbs::for(
            'online',
            fn (Trail $trail) =>
            $trail->push($title, route('online'))
        );
        
        return view('pages.online.online-list', [
            'meta' => [
                'title' => $title
            ],
            'onlines' => $catalog,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Show online details
     */
    public function show($slug)
    {
        $online = $this->onlineService->getBySlug($slug);

        if (!$online) {
            return abort(404);
        }

        // Хлебные крошки
        BreadcrumbsService::card($online);

        return view('pages.online.online-single', [
            'online' => $online,
            'components' => $online->components
        ]);
    }
}
