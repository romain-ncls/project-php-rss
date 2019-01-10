<?php

class FrontControler
{
    public function __construct()
    {
        global $rep, $vues;

        session_start();

        $dVueEreur = array();

        $action_User = array('home', 'login');
        $action_Admin = array('admin', 'logout', 'addFeed', 'removeFeed', 'setNbNewsPerPage');

        try {
            if (isset($_REQUEST['action'])) {
                $action = $_REQUEST['action'];
            } else {
                $action = null;
            }

            $a = new MdlAdmin();

            if (in_array($action, $action_User) || $action == null) {
                $userC = new UserControler();
            } elseif (in_array($action, $action_Admin)) {
                if ($a->isAdmin()) $adminC = new AdminControler();
                else require($rep.$vues['login']);
            } else {
                $dVueEreur[] = "Erreur d'appel php";
                require($rep . $vues['vuephp1']);
            }
        } catch (PDOException $e) {
            //si erreur BD, pas le cas ici
            $dVueEreur[] = "Erreur inattendue!!! PDO";
            $dVueEreur[] = $e->getMessage();
            require($rep . $vues['erreur']);
        } catch (Exception $e2) {
            $dVueEreur[] = "Erreur inattendue!!! ";
            require($rep . $vues['erreur']);
        }
    }
}
