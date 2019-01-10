<?php

class UserControler
{
    public function __construct()
    {
        global $rep,$vues;

        try {
            if (isset($_REQUEST['action'])) {
                $action=$_REQUEST['action'];
            } else {
                $action = null;
            }

            switch ($action) {
                case null:
                case "home":
                    $this->home();
                    break;
                case "login":
                    $this->login();
                    break;
                default:
                    $dVueEreur[] =	"Erreur d'appel php";
                    require($rep.$vues['vuephp1']);
                    break;
            }
        } catch (PDOException $e) {
            //si erreur BD, pas le cas ici
            $dVueEreur[] =	"Erreur inattendue!!! PDO";
            $dVueEreur[] =	$e->getMessage();
            require($rep.$vues['erreur']);
        } catch (Exception $e2) {
            $dVueEreur[] =	"Erreur inattendue!!! ";
            require($rep.$vues['erreur']);
        }
    }

    private function home()
    {
        //update feeds
        $mdlFeeds = new MdlFlux();
        $mdlFeeds->updateFeeds();

        if (isset($_GET['page'])) {
            $ok = filter_var($_GET['page'], FILTER_VALIDATE_INT);
            if ($ok) $page = $_GET['page'];
            else $page = 1;
        } else $page = 1;

        global $rep,$vues;
        $nbNews = MdlSettings::getNbNewsPerPage();

        $model = new MdlNews();
        $listNews = $model->getNews($page, $nbNews);
        $previousPage = ($page == 1)? null : $page-1;
        $nextPage = ($page >= $model->lastPage($nbNews))? null : $page+1;
        require($rep.$vues['home']);
    }

    private function login()
    {   
        if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
            $a = new MdlAdmin();
            $a->login($_REQUEST['username'], $_REQUEST['password']);
        }
        header('Location: index.php?action=admin');
    }
}
