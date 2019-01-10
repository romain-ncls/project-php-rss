<?php

class NewsGateway
{
    public function __construct()
    {
        global $base,$login, $mdp;
        $this->con = new Connection('mysql:host=localhost;dbname='.$base, $login, $mdp);
    }
    public function getNews($page, $nbNews) : array
    {
        $first = ($page-1) * $nbNews;
        $query = 'select * from news order by time limit :first, :nb';
        $this->con->executeQuery($query, array(
            ':first' => array($first, PDO::PARAM_INT),
            ':nb' => array($nbNews, PDO::PARAM_INT)
        ));

        $res = $this->con->getResults();
        $res = array_reverse($res);
        $news = [];
        foreach ($res as $line) {
            $newNews = new News();
            $newNews->setUrl($line['url']);
            $newNews->setDate($line['time']);
            $newNews->setTitle($line['title']);
            $newNews->setWebsite($line['website']);
            $newNews->setDescription($line['description']);
            $newNews->setImage($line['image']);
            $news[] = $newNews;
        }

        return $news;
    }

    public function lastPage(int $nbNewsPerPage): int
    {
        $query = 'select count(*) from news';
        $this->con->executeQuery($query, array());
        $res = $this->con->getResults();
        return ceil($res[0]['count(*)']/$nbNewsPerPage);
    }

    public function getNewsByUrl(string $url) {
        $query = 'select * from news where url = :url';
        $this->con->executeQuery($query, array(
            ':url' => array($url, PDO::PARAM_STR)
        ));
        $res = $this->con->getResults();
        if(empty($res))return null;
        $line = $res[0];
        $news = new News();
        $news->setUrl($line['url']);
        $news->setDate($line['time']);
        $news->setTitle($line['title']);
        $news->setWebsite($line['website']);
        $news->setDescription($line['description']);
        $news->setImage($line['image']);
        return $news;
    }

    public function addNews(News $news) {
        $format = "%d/%m/%Y %H:%i:%s";
        $query = "insert into news values(:url, str_to_date(:date, :format), :website, :title, :desc, :img)";
        $this->con->executeQuery($query, array(
            ':url' => array($news->getUrl(), PDO::PARAM_STR),
            ':date' => array($news->getDate(), PDO::PARAM_STR),
            ':format' => array($format, PDO::PARAM_STR),
            ':website' => array($news->getWebsite(), PDO::PARAM_STR),
            ':title' => array($news->getTitle(), PDO::PARAM_STR),
            ':desc' => array($news->getDescription(), PDO::PARAM_STR),
            ':img' => array($news->getImage(), PDO::PARAM_STR)
        ));
    }
}
