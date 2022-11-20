<?php

namespace App\Controller;

use App\Entity\NewsSource;
use App\Message\NewsSourceMessage;
use App\Repository\NewsRepository;
use App\Repository\NewsSourceRepository;
use App\Scraper\Scraper;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/", name="app_news")
     */
    public function index(NewsRepository $news_repository, Request $request): Response
    {
        $news = $news_repository->findAllQueryBuilder();
        $pagerfanta = new Pagerfanta(new QueryAdapter($news));
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($request->query->get('page', 1));
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
            'pager' => $pagerfanta,
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
    /**
     * @Route("/parse-news-manually", name="parse_news_manually")
     */
    public function parseNewsManually(NewsSourceRepository  $news_source_repository, MessageBusInterface $bus): JsonResponse
    {
        $source = $news_source_repository->find(1);
        $bus->dispatch(new NewsSourceMessage($source));
        return $this->json(["success"=>true]);
    }
}
