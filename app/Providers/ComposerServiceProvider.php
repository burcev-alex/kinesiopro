<?php

namespace App\Providers;

use App\Domains\Banner\Services\BannersService;
use App\Domains\Blog\Services\NewsPaperService;
use App\Domains\Category\Services\CategoryService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class ComposerServiceProvider.
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('logged_in_user', auth()->user());
        });

        View::composer(['includes.home.banners'], function ($view) {
            $view->with('banners', app(BannersService::class)->getHomeBanners());
        });

        View::composer(['includes.footer'], function ($view) {
            $view->with('categories', app(CategoryService::class)->getCachedMenuCategoriesList());
            $view->with('articles', app(NewsPaperService::class)->getArticles('', 1, 6));
        });
    }
}
