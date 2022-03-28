<?php

namespace App\Http\Controllers;

/**
 * Class StaticController.
 */
class StaticController
{
    public function about()
    {
        return view('pages.about.index');
    }

    public function us()
    {
        return view('pages.about.us');
    }

    public function organizations()
    {
        return view('pages.about.organizations');
    }

    public function structure()
    {
        return view('pages.about.structure');
    }

    public function documents()
    {
        return view('pages.about.documents');
    }

    public function educations()
    {
        return view('pages.about.educations');
    }

    public function headliners()
    {
        return view('pages.about.headliners');
    }

    public function materials()
    {
        return view('pages.about.materials');
    }
}
