<?php

namespace App\Providers;

use App\Domains\Category\Services\CatalogFilterGeneratorService;
use App\Domains\Feedback\Models\FeedBack;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Domains\Feedback\Observers\FeedBackObserver;
use Cache;
use File;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FeedBack::observe(FeedBackObserver::class);

        Cache::rememberForever('translations', function () {
            $translations = collect();

            foreach (['en', 'ru'] as $locale) { // suported locales
                $translations[$locale] = [
                    'php' => $this->phpTranslations($locale),
                    'json' => $this->jsonTranslations($locale),
                ];
            }

            return $translations;
        });

        view()->composer(['includes.course.filter'], function ($view) {
            $view->with('filterSchema', app(CatalogFilterGeneratorService::class)->getFilterSchema());
        });

        view()->composer(['includes.course.categories'], function ($view) {
            $view->with('filterSchema', app(CatalogFilterGeneratorService::class)->getFilterSchema());
        });
    }

    private function phpTranslations($locale)
    {
        $path = resource_path("lang/$locale");

        return collect(File::allFiles($path))->flatMap(function ($file) use ($locale) {
            $key = ($translation = $file->getBasename('.php'));

            return [$key => trans($translation, [], $locale)];
        });
    }

    private function jsonTranslations($locale)
    {
        $path = resource_path("lang/$locale.json");

        if (is_string($path) && is_readable($path)) {
            return json_decode(file_get_contents($path), true);
        }

        return [];
    }
}
