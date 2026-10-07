<?php

namespace App\Http\Controllers;

/**
 * Public About / Contact page. The text and contact details come from the
 * settings table (editable by admins), which every view already receives as $site.
 */
class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }
}
