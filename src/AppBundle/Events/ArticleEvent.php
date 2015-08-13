<?php

namespace AppBundle\Events;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Article;

/**
 * Class ArticleEvent
 */
class ArticleEvent extends Event
{
    /**
     * @var Article
     */
    private $article;

    /**
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
