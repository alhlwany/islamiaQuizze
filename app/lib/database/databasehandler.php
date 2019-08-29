<?php

namespace PHPMVC\lib\DataBase;

abstract class DataBaseHandler {

    const DATABASE_DRIVE_PDO = 1;
    const DATABASE_DRIVER_MYSQL = 2;

    private function __construct() {
        ;
    }

    abstract protected static function init();

    abstract protected static function getInstance();

    public static function factory() {
        $driver = DATABASE_CONN_DRIVER;
        if ($driver == self::DATABASE_DRIVE_PDO) {
            return  PDODatabaseHandler::getInstance();
        } elseif ($driver == self::DATABASE_DRIVER_MYSQL) {
            return MySQLiDatabaseHandler::getInstance();
        }
    }

}
