<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Article;

class MainController extends Controller
{

    const ARTICLES_TO_SHOW_HOMEPAGE = 3;

   /**
     * @Route("/", name="main")
     */
    public function main()
    {
        
        $articles = [];
        $articles = $this->getDoctrine()->getRepository(Article::class)->findByActiveOrderByCreatedOn(true, self::ARTICLES_TO_SHOW_HOMEPAGE);
        
        return $this->render('main.html.twig', array('articles' => $articles));

    }
}