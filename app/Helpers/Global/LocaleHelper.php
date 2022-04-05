<?php

use Carbon\Carbon;

if (! function_exists('setAllLocale')) {

    /**
     * SetAllLocale
     *
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
     * SetAppLocale
     *
     * @param $locale
     */
    function setAppLocale($locale)
    {
        app()->setLocale($locale);
    }
}

if (! function_exists('setPHPLocale')) {

    /**
     * SetPHPLocale
     *
     * @param $locale
     */
    function setPHPLocale($locale)
    {
        setlocale(LC_TIME, $locale);
    }
}

if (! function_exists('setCarbonLocale')) {

    /**
     * SetCarbonLocale
     *
     * @param $locale
     */
    function setCarbonLocale($locale)
    {
        Carbon::setLocale($locale);
    }
}

if (! function_exists('getLocaleName')) {

    /**
     * GetLocaleName
     *
     * @param $locale
     *
     * @return mixed
     */
    function getLocaleName($locale)
    {
        return config('kinesio.locale.languages')[$locale]['name'];
    }
}
