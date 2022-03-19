<?php

use Carbon\Carbon;

if (! function_exists('setAllLocale')) {

    /**
     * @param $locale
     */
    function setAllLocale($locale)
    {
        setAppLocale($locale);
        setPHPLocale($locale);
        setCarbonLocale($locale);
    }
}

if (! function_exists('setAppLocale')) {

    /**
     * @param $locale
     */
    function setAppLocale($locale)
    {
        app()->setLocale($locale);
    }
}

if (! function_exists('setPHPLocale')) {

    /**
     * @param $locale
     */
    function setPHPLocale($locale)
    {
        setlocale(LC_TIME, $locale);
    }
}

if (! function_exists('setCarbonLocale')) {

    /**
     * @param $locale
     */
    function setCarbonLocale($locale)
    {
        Carbon::setLocale($locale);
    }
}

if (! function_exists('getLocaleName')) {

    /**
     * @param $locale
     *
     * @return mixed
     */
    function getLocaleName($locale)
    {
        return config('grandstep.locale.languages')[$locale]['name'];
    }
}
