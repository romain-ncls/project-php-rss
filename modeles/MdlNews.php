<?php

class MdlNews
{
    public function __construct()
    {
        $this->newsGW = new NewsGateway();
    }

    public function getNews(int $page, int $nbNewsPerPage): Array
    {
        return  $this->newsGW->getNews($page, $nbNewsPerPage);
    }

    public function getNewsByUrl(string $url) {
        return $this->newsGW->getNewsByUrl($url);
    }

    public function lastPage(int $nbNewsPerPage): int
    {
        return $this->newsGW->lastPage($nbNewsPerPage);
        // return 2;
    }

    public function addNews(News $news) {
        $this->newsGW->addNews($news);
    }
}
?> 
