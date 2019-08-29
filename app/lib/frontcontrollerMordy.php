<?php

namespace PHPMVC\lib;

use PHPMVC\LIB\Template\Template;
use PHPMVC\Lib\Registry;
use PHPMVC\Lib\Authentication;

class FrontControllerMordy {

    use HelperMordy;

    const NOT_FOUND_ACTION = 'notFoundAction';
    const NOT_FOUND_CONTROLLER = 'PHPMVC\Controllers\\NotFoundController';

    private $_controller = 'index';
    private $_action = 'default';
    private $_params = array();
    private $_template;
    private $_language;
    private $_registry;
    private $_authentication;

    public function __construct(Template $template, Registry $registry, Authentication $auth) {
        //echo 'front controller mordy welcom';
        $this->_template = $template;
        $this->_registry = $registry;
        $this->_authentication = $auth;
        $this->_parseUrl();
    }

    private function _parseUrl() {
        $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);
        if (isset($url[0]) && $url[0] != '') {
            $this->_controller = $url[0];
        }
        if (isset($url[1]) && $url[1] != '') {
            $this->_action = $url[1];
        }
        if (isset($url[2]) && $url[2] != '') {
            $this->_params = explode('/', $url[2]);
        }
        // var_dump($this);
    }
    public function dispatch() {
        $controllerClassName = 'PHPMVC\Controllers\\' . ucfirst($this->_controller) . 'Controller';
        //echo $controllerClassName;
        $actionName = $this->_action . 'Action';      
        //Check User Login Or No (Authorized)
        if (!$this->_authentication->isAuthorized()) {
            if ($this->_controller != 'auth' && $this->_action != 'login') {
                $this->redirect('/auth/login');
            }
           
        } else {
        // deny access to the auth/login
            if ($this->_controller == 'auth' && $this->_action == 'login') {
                isset($_SERVER['HTTP_REFERER']) ? $this->redirect($_SERVER['HTTP_REFERER']) : $this->redirect('/');
            }
            // Check if the user has access to specific url
            if ((bool) CHECK_FOR_PRIVILEGES === true) {
                if (!$this->_authentication->hasAccess($this->_controller, $this->_action)) {
                    $this->redirect('/accessdenied');
                }
            }
        }
        //End Check User Login Or No
        if (!class_exists($controllerClassName) || !method_exists($controllerClassName, $actionName)) {
            $controllerClassName = self::NOT_FOUND_CONTROLLER;
            $this->_action = $actionName = self::NOT_FOUND_ACTION;
        }
        $controller = new $controllerClassName;
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setParams($this->_params);
        $controller->setTemplate($this->_template);
        $controller->setRegistry($this->_registry);
        $controller->$actionName();
        //var_dump($controller);
    }

}
