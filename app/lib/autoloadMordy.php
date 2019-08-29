<?php
namespace PHPMVC\lib;
//مهمه  الاوتوتو لود هى تحميل اى كلاس اوتوماتيك من المسار
class AutoLoadMordy {

    public static function autoloadMordy($className) {
        //www.mysite.com/ControllerName/ActionName        
        $className = str_replace('PHPMVC', '', $className);
        $className = str_replace('\\', '/', $className);
        $className = $className . '.php';
        $className = strtolower($className);
//      echo APP_PATH . $className;
        if (file_exists(APP_PATH . $className)) {
            require_once APP_PATH . $className;
        }
    }
}
spl_autoload_register(__NAMESPACE__ . '\AutoLoadMordy::autoloadMordy');
