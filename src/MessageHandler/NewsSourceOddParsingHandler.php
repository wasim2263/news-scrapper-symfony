<?php

namespace App\MessageHandler;

use App\Message\NewsSourceOddMessage;
use App\Scraper\Scraper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewsSourceOddParsingHandler implements MessageHandlerInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(NewsSourceOddMessage $news_source_message)
    {
        $news_source = $news_source_message->getNewsSource();
        echo "\n";
        echo('-----Odd--start--');
        $entityManager = $this->doctrine->getManager();
        $scraper = new Scraper($entityManager);
        $post_count = $scraper->scrap($news_source);
        echo "\n";
        echo($post_count);
        echo "\n";
        echo('-----Odd--end--');
    }
}