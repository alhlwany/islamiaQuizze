<?php

namespace PHPMVC\Controllers;
use PHPMVC\LIB\HelperMordy;

class LanguageController  extends AbstractController
{
    use HelperMordy;
    
    public function defaultAction(){
        if ($_SESSION['lang']=='ar') {
            $_SESSION['lang']='en';
        }
        else {
            $_SESSION['lang']='ar';
        }
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
