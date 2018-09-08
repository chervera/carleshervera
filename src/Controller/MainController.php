<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class MainController extends Controller
{

   /**
     * @Route("/", name="main")
     */
    public function main()
    {
        $articles = [];
        return $this->render('main.html.twig', array('articles' => $articles));

    }
}