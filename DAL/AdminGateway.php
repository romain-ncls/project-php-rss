<?php

class AdminGateway
{
    public function __construct()
    {
        global $base,$login, $mdp;
        $this->con = new Connection('mysql:host=localhost;dbname='.$base, $login, $mdp);
    }
    
    public function checkAdmin($user, $pass) {
        $query="select * from admin where username = :user";
        $this->con->executeQuery($query, array(':user' => array($user, PDO::PARAM_STR)));
        $res = $this->con->getResults();
        $check = password_verify($pass, $res[0]['password']);
        if($check) return true;
        return false;
    }
}
