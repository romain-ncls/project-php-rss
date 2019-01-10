<?php

class AdminControler
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
                case "admin":
                    $this->admin();
                    break;
                case "logout":
                    $this->logout();
                    break;
                case "addFeed":
                    $this->addFeed();
                    break;
                case "removeFeed":
                    $this->removeFeed();
                    break;
                case "setNbNewsPerPage":
                    $this->setNbNewsPerPage();
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

    public function admin()
    {
        global $rep,$vues;
        $flux = new MdlFlux();
        $listFlux = $flux->getFeeds();
        $nbNewsPerPage = MdlSettings::getNbNewsPerPage();
        require($rep.$vues['admin']);
    }

    public function logout() {
        $a = new MdlAdmin();
        $a->logout();
        header('Location: index.php');
    }

    public function addFeed()
    {
        if(isset($_REQUEST['name']) && isset($_REQUEST['url'])) {
            $flux = new MdlFlux();
            $flux->addFeed($_REQUEST['name'], $_REQUEST['url']);
        }
        header('Location: index.php?action=admin');
    }

    public function removeFeed()
    {
        if(isset($_REQUEST['feed'])) {
            $flux = new MdlFlux();
            $flux->removeFeed($_REQUEST['feed']);
        }
        header('Location: index.php?action=admin');
    }

    public function setNbNewsPerPage() {
        if (isset($_REQUEST['nbNews'])) {
            $ok = filter_var($_REQUEST['nbNews'], FILTER_VALIDATE_INT);
            if ($ok) {
                MdlSettings::setNbNewsPerPage($_REQUEST['nbNews']);
            }
        }
        header('Location: index.php?action=admin');
    }
}
