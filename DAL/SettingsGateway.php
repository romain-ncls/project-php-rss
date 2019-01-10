<?php

class SettingsGateway
{
    public function __construct()
    {
        global $base,$login, $mdp;
        $this->con = new Connection('mysql:host=localhost;dbname='.$base, $login, $mdp);
    }

    public function getNbNewsPerPage()
    {
        $query = "select * from settings where name = 'nbNewsPerPage'";
        $this->con->executeQuery($query, array());
        $res = $this->con->getResults();
        return $res[0]['value'];
    }
    
    public function setNbNewsPerPage(int $nbNewsPerPage)
    {
        $query = "update settings set value = :nbNews where name = 'nbNewsPerPage'";
        $this->con->executeQuery($query, array(
            ':nbNews' => array($nbNewsPerPage, PDO::PARAM_INT)
        ));
    }
}
