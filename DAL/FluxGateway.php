<?php

class FluxGateway
{
    public function __construct()
    {
        global $base,$login, $mdp;
        $this->con = new Connection('mysql:host=localhost;dbname='.$base, $login, $mdp);
    }
    
    public function getFlux()
    {
        $query="select * from feeds";
        $this->con->executeQuery($query, array());
        $res = $this->con->getResults();

        $flux = [];

        foreach ($res as $line) {
            $flux[] = new Flux($line['name'], $line['url']);
        }

        return $flux;
    }

    public function addFeed(String $name, String $url)
    {
        $query = "insert into feeds values(:name, :url)";
        $this->con->executeQuery($query, array(
            ':name' => array($name, PDO::PARAM_STR),
            ':url' => array($url, PDO::PARAM_STR)
        ));
    }

    public function removeFeed(String $feedUrl)
    {
        $query = "delete from feeds where url = :url";
        $this->con->executeQuery($query, array(
            ':url' => array($feedUrl, PDO::PARAM_STR)
        ));
    }
}
