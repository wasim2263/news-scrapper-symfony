<?php

namespace App\MessageHandler;

use App\Message\NewsSourceEvenMessage;
use App\Scraper\Scraper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewsSourceEvenParsingHandler implements MessageHandlerInterface
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function __invoke(NewsSourceEvenMessage $news_source_message)
{
    $news_source = $news_source_message->getNewsSource();
    echo "\n";
    echo('-----Even--start--');
    $scraper = new Scraper();
    $post_count = $scraper->scrap($news_source, $this->doctrine);
    echo "\n";
    echo($post_count);
    echo "\n";
    echo('-----Even--end--');
}
}