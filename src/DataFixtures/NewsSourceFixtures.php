<?php

namespace App\DataFixtures;

use App\Entity\NewsSource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NewsSourceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $news_source = new NewsSource();
         $news_source->setName('highload today');
         $news_source->setUrl('https://highload.today/category/novosti/');
         $news_source->setWrapperSelector('.lenta-item');
         $news_source->setTitleSelector('h2');
         $news_source->setDescriptionSelector('p');
         $news_source->setDateSelector('.meta-datetime');
         $news_source->setImageSelector('.wp-post-image');
         $news_source->setDayTranslation('дня');
         $news_source->setWeekTranslation('недели');
         $news_source->setMonthTranslation('месяца');
         $news_source->isIsCustomDateFormat(true);
         $manager->persist($news_source);

        $manager->flush();
    }
}
