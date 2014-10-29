<?php
/*
# Shane Kirk - OSA - Call_log^2
#
# @DB[Class]  - allows for use of PDO as a class in the application
#
*/

class DB
{

    private static $_instance = null;
    private $_pdo;

    private function __construct()
    {
        try {
            //pulls from config.php file to establish connection - make sure you have proper mysql credentials entered!
            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * call as ----> Db::getInstance();
     * @return db object [returns active db connection]
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Db();
        }

        return self::$_instance;
    }

    public function prepare($sql)
    {
        return $this->_pdo->prepare($sql);
    }
}
