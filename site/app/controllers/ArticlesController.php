<?php

namespace App\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

use Kazan\Articler\Articler;

/**
 * Resource:
 *
 * Display the collection of articles ArticlesBin "articles"
 */
class ArticlesController extends BaseController
{

    /**
     * The filesystem instance.
     *
     * @var \Kazan\ArticlesBin
     */
    protected $articles;

    /**
     * Controller Constructor
     */
    public function __construct(Articler $articles)
    {
        $this->articles = $articles;
    }

    /**
     * Display list of articles
     *
     * @return Response
     */
    public function index()
    {
        $list = $this->articles->getList('articles');

        return View::make('articles.index')->with('list', $list);
    }

    /**
     * Display a given article selected by its slug.
     *
     * @param  string $slug
     * @return Response
     */
    public function show($slug)
    {
        $article = $this->articles->getArticle('articles', $slug);

        if ($article === null) {
            App::abort(404);
        }

        return View::make('articles.article')->with('article', $article);
    }
}
