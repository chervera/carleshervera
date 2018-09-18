<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Article;

class MainController extends BaseController
{

    const ARTICLES_TO_SHOW_HOMEPAGE = 3;
    const PAGE_SIZE = 1;

    /**
     * @Route("/", name="main")
     */
    public function main()
    {

        $articles = [];
        $articles = $this->getDoctrine()->getRepository(Article::class)->findByActiveOrderByCreatedOn(true, self::ARTICLES_TO_SHOW_HOMEPAGE);

        return $this->render('main.html.twig', array('articles' => $articles));

    }

    /**
     * @Route("/blog", name="articles")
     */
    public function articles(Request $request)
    {
        $page = $request->query->get('page');
        if(!$page){
            $page = 1;
        }
        $articlesPaginateds = $this->getDoctrine()->getRepository(Article::class)->findByActiveOrderByCreatedOnPaginated($page, self::PAGE_SIZE);
        $paginator = $this->createPaginator($articlesPaginateds, self::PAGE_SIZE, $page);

        return $this->render('articles.html.twig', array('articles' => $paginator));

    }


    /**
     * @Route("/blog/tag/{tag}", name="articles_tag")
     */
    public function articlesByTag(Request $request, $tag)
    {

        $page = $request->query->get('page');
        if(!$page){
            $page = 1;
        }
        $articlesPaginateds = $this->getDoctrine()->getRepository(Article::class)->findByTagActiveOrderByCreatedOnPaginated($tag);
        $paginator = $this->createPaginator($articlesPaginateds, self::PAGE_SIZE, $page);

        return $this->render('articles.html.twig', array('articles' => $paginator, 'tag' => $tag));

    }

    /**
     * @Route("/blog/{slug}", name="article")
     */
    public function article($slug)
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBySlug($slug);

        return $this->render('article.html.twig', array('article' => $article));

    }


}