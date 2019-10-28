<?php

class DBConnection{
    private static $dbh;

    private function __construct(){}
    
    public static function getInstance(){
        if(self::$dbh === null){
            self::$dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        }
        return self::$dbh;
    }
}
?>
