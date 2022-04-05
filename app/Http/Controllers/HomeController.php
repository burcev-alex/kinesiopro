<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Lang;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * Главная страница
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('pages.home');
    }
}
