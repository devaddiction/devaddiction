<?php

namespace App\Content;

use DateTime;
use App\Content\Article;

/**
 *
 */
class ContentRepository extends \Kazan\Articler\Repository\JsonStaticRepository
{

    /**
     * @inheritdoc
     */
    protected function buildArticle($id, $metadata, $content = '')
    {
        $article = new Article();

        $article
            ->setTitle($metadata['title'])
            ->setSlug($id)
            ->setAuthor($metadata['author'])
            ->setCreated(new DateTime($metadata['created']))
            ->setContent($content)
            ->setTeaser($metadata['teaser'])
            ->setDownloadLink($metadata['download_link'])
            ->setDemoLink($metadata['demo_link'])
            ->setTags($this->buildArticleTags($metadata));
        return $article;
    }

}
