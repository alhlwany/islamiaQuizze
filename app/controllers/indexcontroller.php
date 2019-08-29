<?php
namespace PHPMVC\Controllers;

class UfController extends AbstractController 
{
    public function faceAction()
    {
        $this->language->load('template.common');
        $this->language->load('index.default');
       $this->_view();
       echo '<h1><a href ="/auth/logout">Login</a></h1>'; 
    }
}
