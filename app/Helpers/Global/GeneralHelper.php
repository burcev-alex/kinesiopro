<?php

use Carbon\Carbon;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Laravel Boilerplate');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @return Carbon
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        return 'index';
    }
}

if (! function_exists('clearCacheByArray')) {
    /**
     * Сброс кеша
     *
     * @param array $keys
     * @return void
     * @throws \Exception
     */
    function clearCacheByArray(array $keys)
    {
        foreach ($keys as $key) {
            cache()->forget($key);
        }
    }
}

if (! function_exists('clearCacheByTags')) {
    /**
     * Очистка кеша по тегу
     *
     * @param array $tags
     * @return void
     * @throws \Exception
     */
    function clearCacheByTags(array $tags)
    {
        cache()->tags($tags)->flush();
    }
}

if (! function_exists('breadcrumbs')) {
    /**
     * Хлебные крошки
     *
     * @param string $type
     * @return mixed
     */
    function breadcrumbs(string $type)
    {
        return app(\App\Services\BreadcrumbsService::class)->getBreadcrumbs($type);
    }
}
