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
     * @param string $type
     * @return mixed
     */
    function breadcrumbs(string $type)
    {
        return app(\App\Services\BreadcrumbsService::class)->getBreadcrumbs($type);
    }
}

if (! function_exists('goLkClass')) {
    /**
     * @return string
     */
    function goLkClass(): string
    {
        return auth()->check() ? 'showLK' : '';
    }
}

if (! function_exists('isLocaleActive')) {
    /**
     * @param $lang
     * @return bool
     */
    function isLocaleActive($lang)
    {
        $locale = getLocalization();

        return $locale == $lang || ($locale == '' && $lang == 'ru');
    }
}

if (! function_exists('getLocalization')) {
    /**
     * @return string
     */
    function getLocalization()
    {
        $localization = '';
        $explode = explode('/', request()->path());
        if (isset($explode[0]) && in_array($explode[0], ['ru', 'en'])) {
            $localization = $explode[0];
        }

        return $localization;
    }
}

if (! function_exists('getLocaleUrl')) {
    /**
     * @return string
     */
    function getLocaleUrl($lang)
    {
        $explode = array_filter(explode('/', request()->path()), function ($data) {
            return ! empty($data);
        });
        if (! empty($explode[0]) && in_array($explode[0], ['ru', 'en'])) {
            array_shift($explode);
        }

        if ($lang == 'ru') {
            array_unshift($explode, $lang);
        }

        return empty($explode) ? '/' : '/' . implode('/', $explode) . '/';
    }
}