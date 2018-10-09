<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Entity\Article;
use App\Entity\Tag;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

class MainController extends BaseController {

    const ARTICLES_TO_SHOW_HOMEPAGE = 3;
    const PAGE_SIZE = 1;

    /**
     * @Route("/", name="main")
     */
    public function main() {

        $articles = [];
        $articles = $this->getDoctrine()->getRepository(Article::class)->findByActiveOrderByCreatedOn(true, self::ARTICLES_TO_SHOW_HOMEPAGE);

        return $this->render('main.html.twig', array('articles' => $articles));
    }

    /**
     * @Route("/blog.html", name="articles")
     */
    public function articles(Request $request) {
        $page = $request->query->get('page');
        if (!$page) {
            $page = 1;
        }
        $articlesPaginateds = $this->getDoctrine()->getRepository(Article::class)->findByActiveOrderByCreatedOnPaginated($page, self::PAGE_SIZE);
        $paginator = $this->createPaginator($articlesPaginateds, self::PAGE_SIZE, $page);

        return $this->render('articles.html.twig', array('articles' => $paginator));
    }

    /**
     * @Route("/blog/tag/{slug}.html", name="articles_tag")
     */
    public function articlesByTag(Request $request, $slug) {

        $page = $request->query->get('page');
        if (!$page) {
            $page = 1;
        }
        $tag = $this->getDoctrine()->getRepository(Tag::class)->findOneBySlug($slug);
        $articlesPaginateds = $this->getDoctrine()->getRepository(Article::class)->findByTagActiveOrderByCreatedOnPaginated($slug);
        $paginator = $this->createPaginator($articlesPaginateds, self::PAGE_SIZE, $page);

        return $this->render('articles.html.twig', array('articles' => $paginator, 'tag' => $tag));
    }

    /**
     * @Route("/blog/{slug}.html", name="article")
     */
    public function article($slug) {

        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBySlug($slug);

        return $this->render('article.html.twig', array('article' => $article));
    }

    /**
     * @Route("/sitemap.xml", name="sitemap")
     */
    public function sitemap() {
        $urls = array();

        $urls[] = array('loc' => $this->generateUrl('main', [], UrlGeneratorInterface::ABSOLUTE_URL));
        $urls[] = array('loc' => $this->generateUrl('articles', [], UrlGeneratorInterface::ABSOLUTE_URL));


        $package = new Package(new EmptyVersionStrategy());

        $articles = $this->getDoctrine()->getRepository(Article::class)->findByActive(true);
        foreach ($articles as $article) {
            $images = array(
            'loc' => 'img/articles/' . $article->getImage(),
            'title' => $article->getTitle()
            );
            $urls[] = array('loc' => $this->generateUrl('article', ['slug' => $article->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL),
                            'image' => $images);
        }

        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        foreach ($tags as $tag) {
            $urls[] = array('loc' => $this->generateUrl('articles_tag', ['slug' => $tag->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
        }

        // return response in XML format
        $response = new Response($this->renderView('sitemap.html.twig', array('urls' => $urls), 200));
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

}
