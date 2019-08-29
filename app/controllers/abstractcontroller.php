<?php

namespace PHPMVC\Controllers;

use PHPMVC\lib\FrontControllerMordy;
use PHPMVC\Lib\Validate;

class AbstractController {

    use Validate;

    protected $_controller;
    protected $_action;
    protected $_params;
    protected $_data = [];
    protected $_template;
    protected $_registry;

    public function notFoundAction() {

        //echo 'AbstractController :> Sorry This Page Dosent Exists !';
        $this->_view();
    }

    public function setController($controllerName) {
        $this->_controller = $controllerName;
    }

    public function setAction($actionName) {
        $this->_action = $actionName;
    }

    public function setTemplate($template) {
        $this->_template = $template;
    }

    public function setRegistry($registry) {
        $this->_registry = $registry;
    }

    public function setParams($params) {
        $this->_params = $params;
    }

    public function __get($key) {
        return $this->_registry->$key;
    }

    protected function _view() {
        $view = VIEW_PATH . $this->_controller . DS . $this->_action . '.view.php';

        if ($this->_action == FrontControllerMordy::NOT_FOUND_ACTION || !file_exists($view)) {
            $view = VIEW_PATH . 'notfound' . DS . 'notfound.view.php';
        }
        $this->_data = array_merge($this->_data, $this->language->getDictionary());
        $this->_template->setRegistry($this->_registry);
        $this->_template->setActionViewFile($view);
        $this->_template->setAppData($this->_data);
        $this->_template->renderApp($this->_data);
    }

}
