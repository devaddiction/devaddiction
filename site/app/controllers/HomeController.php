<?php

namespace App\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Kazan\Articler\Articler;

class HomeController extends BaseController
{

    /**
     * @var  int
     */
    const MAX_HOME_ARTICLES = 2;

    /**
     * The filesystem instance.
     *
     * @var \Kazan\ArticlesBin
     */
    protected $articles;

    /**
     * Class constructor
     * @param Articler $articles
     */
    public function __construct(Articler $articles)
    {
        $this->articles = $articles;
    }
    /**
     * @inhertidoc
     */
    public function index()
    {
        $lastestArticles = $this->articles->getList('articles', 0, self::MAX_HOME_ARTICLES);

        $articles = array();

        foreach($lastestArticles->getArticles() as $index=>$article) {
            $articles[$index] =
                $this->articles->getArticle('articles', $article->getSlug());
        }

        return View::make('home.index')->with(
            array(
                'latestArticles'=> $articles
            )
        );
    }

}
