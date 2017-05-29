<?php

namespace VORC;

class Pdo
{
    protected static $db_host     = '';
    protected static $db_name     = '';
    protected static $db_driver   = '';
    protected static $db_user     = '';
    protected static $db_pass     = '';
    protected static $dsn = '';
    protected static $db = null;
    //public $db = null;
    protected static $failed = false;

    public function __construct ()
    {
        //echo "__construct()";die();
        //print_r($_SERVER['HTTP_HOST']);exit;
        $filename=__DIR__."/../../profiles/".$_SERVER['HTTP_HOST'].".json";
        self::getConfig($filename);
        return $this->db();
    }

    public static function getConfig ($filename='')
    {
        //echo "getConfig ($configfile = '');\n";
        if (is_file($filename)) {
            // Load configuration
            $config = json_decode(file_get_contents($filename));
            //echo "<pre>";print_r($config);exit;
            self::$db_host = $config->pdo->host;
            self::$db_name = $config->pdo->name;
            self::$db_driver=$config->pdo->driver;
            self::$db_user = $config->pdo->user;
            self::$db_pass = $config->pdo->pass;
            //print_r($config->pdo);exit;
        } else {
            throw new \RuntimeException(__FUNCTION__.' error: no config file like "'.$filename.'"');
        }
    }


    public static function getDatabase()
    {
        //echo __FUNCTION__."()\n";exit;
        //self::getConfig();

        try {
            $dsn     = self::$db_driver.":host=".self::$db_host.";dbname=".self::$db_name;
            if(self::$db instanceof \PDO) {
                return self::$db;
            }
            self::$db = new \PDO($dsn, self::$db_user, self::$db_pass);
        } catch (PDOException $e) {
            self::$failed = true;
            echo "<li>" . $e->getMessage();

        }
        return self::$db;
    }

    public function db()
    {
        return $this->getDatabase();
    }
}
