<?php

namespace App\Controller;

use App\Entity\NewsSource;
use App\Repository\NewsRepository;
use App\Scraper\Scraper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/", name="app_news")
     */
    public function index(): Response
    {
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }
    /**
     * @Route("/fetch/{id}", name="fetch")
     */
    public function fetch(NewsSource $source, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $scraper = new Scraper($entityManager);
        $posts = $scraper->scrap($source);

        return $this->json($posts->toArray());
    }
}
