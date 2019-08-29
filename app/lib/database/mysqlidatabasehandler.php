<?php
namespace PHPMVC\lib\DataBase;
class MySQLiDatabaseHandler extends DataBaseHandler{
    
    private static $_handler;
    
    private function __construct() {
        self::init();
    }
    
    protected static function init() {
        try {
            self::$_handler= new \PDO('mysql://host='.DATABASE_HOST_NAME.';dbname='.DATABASE_DB_NAME,DATABASE_USER_NAME,DATABASE_PASSWORD,
                    array(\PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",\PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET utf8"));
            } catch (\PDOException $ex) {
             echo 'ERROR!';
             print_r( $e );
        }
    }
    
    public static function getInstance() {
        if (self::$_handler===null) {
            self::$_handler=new self();
        }
        return self::$_handler;
    }
    
    public function prepare(){
        
    }
}
