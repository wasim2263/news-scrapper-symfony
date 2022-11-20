<?php
// src/Message/SmsNotification.php
namespace App\Message;

use App\Entity\NewsSource;

class NewsSourceEvenMessage
{
    private $news_source;

    public function __construct(NewsSource $news_source)
    {
        $this->news_source = $news_source;
    }

    public function getNewsSource(): NewsSource
    {
        return $this->news_source;
    }
}