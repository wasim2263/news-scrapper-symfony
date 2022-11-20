<?php

namespace App\MessageHandler;

use App\Entity\NewsSource;
use App\Message\NewsSourceMessage;
use App\Scraper\Scraper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewsParsingHandler implements MessageHandlerInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function __invoke(NewsSourceMessage $news_source_message)
{
    $news_source = $news_source_message->getNewsSource();
    print_r('---------');
    print_r( $news_source->getId());
    print_r($news_source->getName());
    $entityManager = $this->doctrine->getManager();
    $scraper = new Scraper($entityManager);
    $posts = $scraper->scrap($news_source);
    echo "\n";
    print_r($posts->count());
    echo "\n";
}
}