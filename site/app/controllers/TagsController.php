<?php

namespace App\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

use Kazan\Articler\Articler;

/**
 * Resource:
 *
 * Display the tags pertaining to ArticlesBin "articles"
 */
class TagsController extends ArticlesController
{

    /**
     * The filesystem instance.
     *
     * @var \Kazan\ArticlesBin
     */
    protected $articles;

    /**
     * Display a given article selected by its tag.
     *
     * @param  string $tag
     * @return Response
     */
    public function show($tag)
    {
        $list = $this->articles->getList('articles');
        $articles = array();

        foreach($list->getArticles() as $index=>$article) {
            foreach($article->getTags() as $articleTag) {
                if ($articleTag->getTitle() == $tag) {
                    $articles[$index] =
                        $this->articles->getArticle('articles', $article->getSlug());
                }
            }
        }

        return View::make('tags.index')->with(
            array(
                'tag' => $tag,
                'list' => $articles
            )
        );
    }
}
