<?php
namespace PHPMVC\lib\DataBase;
class PDODatabaseHandler extends DataBaseHandler{
    
    private static $_instance;
    private static $_handler;
    
    private function __construct() {
        self::init();
    }
    
    public function __call($name, $arguments) {
        return call_user_func_array(array(&self::$_handler,$name),$arguments);
    }
    
    protected static function init() {
        try {
            self::$_handler= new \PDO('mysql://host='.DATABASE_HOST_NAME.';dbname='.DATABASE_DB_NAME,
                    DATABASE_USER_NAME,DATABASE_PASSWORD
                    ,array(\PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",\PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET utf8"));
            //,array(\PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",\PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET utf8")
                 // echo 'SUCESS!';  
        
            } catch (\PDOException $ex) {
             echo 'ERROR!';
             print_r( $ex );
        }
    }
    
    public static function getInstance() {
        if (self::$_instance===null) {
           self::$_instance=new self();
        }
        return self::$_instance;
    }
    
//     public function prepare(){
//        
//    }
}

