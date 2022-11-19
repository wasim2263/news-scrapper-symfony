<?php

namespace App\Scraper;

use App\Entity\News;
use App\Entity\NewsSource;
use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Type;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client;

class Scraper
{

    private EntityManagerInterface $entity_manager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function scrap(NewsSource $source): Collection
    {
        $collection = [];
        $client = Client::createChromeClient(__DIR__ . '/../../drivers/chromedriver');
        $crawler = $client->request('GET', $source->getUrl());
        $crawler->filter($source->getWrapperSelector())->each(function (Crawler $c) use ($source, &$collection) {
            /// this line usually by passes the ads
            if (!$c->filter($source->getTitleSelector())->count()) {
                return;
            }
            $news = new News();

            /// Find and filter the title
            $title = $c->filter($source->getTitleSelector())->text();
            $news->setTitle($title);
//            dd($title);
            /// some websites using datetime attribute in <time> tag to store the full
            /// date time, here we first checked if this attribute exists, otherwise we fetch the
            /// text inside the tag.
            $date_time = $c->filter($source->getDateSElector())->attr('datetime');
            if (!$date_time) {
                $date_time = $c->filter($source->getDateSElector())->text();
            }

            $date_time = $this->cleanupDate($source, $date_time);
            $news->setDateAdded($date_time);

            $description = ($c->filter($source->getDescriptionSelector())->last()->text());
            $news->setShortDescription($description);
            $image = ($c->filter($source->getImageSelector())->attr('data-lazy-src'));

            $image_parts = explode('/', $image);
            $image_path = __DIR__ . '/../../public/images/' . end($image_parts);
            $file = file_get_contents($image);
            $insert = file_put_contents($image_path, $file);
            $news->setPicture($image_path);

            $this->entity_manager->persist($news);
            $this->entity_manager->flush();
            $collection[] = $news;
        });
        return new ArrayCollection($collection);
    }

    /**
     * In order to make DateTime work, we need to clean up the input.
     *
     * @throws \Exception
     */
    private function cleanupDate(NewsSource $source, string $date_time): \DateTime
    {
        $date = new \DateTime();
        if ($source->isIsCustomDateFormat()) {
            $interval = explode(' ', $date_time);
            if (!array_key_exists(1, $interval)) {
                return $date;
            }
            if ($interval[1] == $source->getDayTranslation()) {
                $date->modify('-' . $interval[0] . ' days');
            } elseif ($interval[1] == $source->getWeekTranslation()) {
                $date->modify('-' . $interval[0] . ' weeks');
            } elseif ($interval[1] == $source->getMonthTranslation()) {
                $date->modify('-' . $interval[0] . ' months');
            }
        }

        return $date->setTime(0, 0);
    }
}