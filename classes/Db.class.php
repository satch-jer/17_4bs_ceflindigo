<?php

/**
 * Created by PhpStorm.
 * User: Jeroen
 * Date: 6/12/2016
 * Time: 14:32
 */
class Db
{
    private static $db;

    public static function getInstance(){
        //$host = ".";
        //$dbname = "SQLECCE";
        //$user = "sa";
        //$pass = "fourbs";

        $host = "(local)\SQLEXPRESS";
        $dbname = "SQLECCE";
        $user = "jer";
        $pass = "@dmin123";

        if(self::$db === null){
            self::$db = new PDO("sqlsrv:server=$host;database=$dbname", $user, $pass);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$db;
        }else{
            return self::$db;
        }
    }
}