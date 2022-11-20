<?php

namespace App\Controller;

use App\Entity\NewsSource;
use App\Message\NewsSourceEvenMessage;
use App\Message\NewsSourceOddMessage;
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
    public function parseNewsManually(Request $request, NewsSourceRepository  $news_source_repository, MessageBusInterface $bus): Response
    {
        $sources = $news_source_repository->findAll();
        foreach($sources as $source){
            if($source->getId()%2 == 0){
                $bus->dispatch(new NewsSourceEvenMessage($source));
            }else{
                $bus->dispatch(new NewsSourceOddMessage($source));
            }
        }
        $route = $request->headers->get('referer');
        return $this->redirect($route);    }
    /**
     * @Route("/news/delete/{id}", name="news_delete")
     */
    public function delete(int $id,NewsRepository $news_repository, ManagerRegistry $doctrine, Request $request): Response
    {
        $news = $news_repository->find($id);
        $entity_manager = $doctrine->getManager();
        $entity_manager->remove($news);
        $entity_manager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }
}
