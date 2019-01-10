<?php

class MdlAdmin
{
    public function login(String $login, String $password)
    {
        $user = filter_var($login, FILTER_SANITIZE_STRING);
        $pass = filter_var($password, FILTER_SANITIZE_STRING);
        $aGate = new AdminGateway();
        if($aGate->checkAdmin($user, $pass)) {
            $_SESSION['role']="admin";
            $_SESSION['login']=$login;
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $_SESSION = array();
    }

    public function isAdmin()
    {
        if(isset($_SESSION['login']) && isset($_SESSION['role'])) {
            if($_SESSION['role'] != "admin") return FALSE;
            return true;
        }
        return false;
    }
}
