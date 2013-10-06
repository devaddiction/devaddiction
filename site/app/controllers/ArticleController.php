<?php

use DevAddiction\Website\Articles\ArticleCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController extends BaseController {

	/**
	 * Create a new home controller instance.
	 *
	 * @param  \DevAddiction\Website\Articles\ArticleCollection  $articles
	 * @return void
	 */
	public function __construct(ArticleCollection $articles)
	{
		$this->articles = $articles;
	}

	/**
	 * Read an individual article.
	 *
	 * @param  string  $slug
	 * @return void
	 */
	public function getArticle($slug)
	{
		if ( ! $article = $this->articles->get($slug))
		{
			throw new NotFoundHttpException;
		}

		$this->layout->title = $article->getMeta('title');
		$this->layout->nest('content', 'articles.read', compact('article'));
	}

}
