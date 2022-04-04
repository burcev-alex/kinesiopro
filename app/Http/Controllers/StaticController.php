<?php

namespace App\Http\Controllers;

/**
 * Class StaticController.
 */
class StaticController
{
    public function discount()
    {
        return view('pages.discount');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy_policy');
    }

    public function publicOffer()
    {
        return view('pages.public_offer');
    }

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
