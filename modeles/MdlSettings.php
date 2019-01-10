<?php

class MdlSettings
{
    public static function setNbNewsPerPage(int $nbNewsPerPage)
    {
        $settingsGW = new SettingsGateway();
        $settingsGW->setNbNewsPerPage($nbNewsPerPage);
    }
    
    public static function getNbNewsPerPage()
    {
        $settingsGW = new SettingsGateway();
        return $settingsGW->getNbNewsPerPage();
    }
}
?> 
