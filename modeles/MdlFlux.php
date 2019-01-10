<?php

class MdlFlux
{
    public function __construct()
    {
        $this->fluxGW = new FluxGateway();
    }

    public function getFeeds()
    {
        return $this->fluxGW->getFlux();
    }

    public function addFeed(String $name, String $url)
    {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $url = filter_var($url, FILTER_SANITIZE_STRING);
        $this->fluxGW->addFeed($name, $url);
    }
    
    public function removeFeed(String $feedUrl)
    {
        $feedUrl = filter_var($feedUrl, FILTER_SANITIZE_STRING);
        $this->fluxGW->removeFeed($feedUrl);
    }

    public function updateFeeds() {
        $feeds = $this->fluxGW->getFlux();
        foreach ($feeds as $feed) {
            $parser = new XmlParser($feed->getUrl(), $feed->getName());
            try {
                $parser->parse();
            } catch(Exception $e) {
                return;
            }
        }
    }
}
?> 
