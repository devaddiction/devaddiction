<?php

namespace App\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

/**
 * Resource:
 *
 * Display the collection of articles ArticlesBin "articles"
 */
class AboutMeController extends BaseController
{
    /**
     * Display about me page
     *
     * @return Response
     */
    public function index()
    {
        return View::make('about.index');
    }
}
