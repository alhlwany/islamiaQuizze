<?php
//echo 'MORDY';
namespace PHPMVC;
use PHPMVC\lib\FrontControllerMordy;
use PHPMVC\LIB\Template\Template;
use PHPMVC\LIB\Language;
use PHPMVC\LIB\SessionManager;
use PHPMVC\Lib\Registry;
use PHPMVC\lib\Messenger;
use PHPMVC\lib\Authentication;
//session_start();
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require_once '..'.DS.'app'.DS.'config'.DS.'config.php';
require_once APP_PATH.DS.'lib'.DS.'autoloadMordy.php';

$session=new SessionManager();
$session->start();

if (!isset($session->lang)) {
  $session->lang=APP_DEFAULT_LANGUAGE;  
}

//تحميل ملفات السى اس اس والجافا وتمبلت ديزاين الموقع 
$template_parts= require_once '..'.DS.'app'.DS.'config'.DS.'templateconfig.php';
//var_dump($template);
$template=new Template($template_parts);
$language=new Language();

$messenger = Messenger::getInstance($session);
$authentication = Authentication::getInstance($session);
$registry = Registry::getInstance();
$registry->session = $session;
$registry->language = $language;
$registry->messenger = $messenger;

$frontController=new FrontControllerMordy($template,$registry, $authentication);
$frontController->dispatch();

//phpinfo();436175
