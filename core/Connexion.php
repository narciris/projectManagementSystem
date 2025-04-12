<?php

namespace core;

class Connexion
{

    public  static $pdo;
    public function __construct()
    {

    }

    public static function getConnexion(){
        if(self::$pdo){
            $databasename = 'biwnetbnq4wmu30fxnm8';
            $dbuser = 'unam4ja7dgkinhtq';
            $dbpass = 'sQXjzDrjGgCfeZDk3iNv';
            $dbhost = 'biwnetbnq4wmu30fxnm8-mysql.services.clever-cloud.com';
            $charset = 'utf8';
        }

        self::$pdo = new \PDO("mysql:host=$dbhost;dbname=$databasename ,charset=$charset, $dbuser, $dbpass");
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    }


}
