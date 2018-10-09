<?php

namespace App\Service;

/**
 * Description of ArticleService
 *
 * @author Carles Hervera <axongrafics.com>
 */
class ArticleService {

    public function findByActiveOrderByCreatedOn($active, $limit) {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findByActiveOrderByCreatedOn(true, self::ARTICLES_TO_SHOW_HOMEPAGE);
    }

}
