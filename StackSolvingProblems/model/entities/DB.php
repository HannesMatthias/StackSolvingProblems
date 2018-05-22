<?php

class DB {
    private static $db = null;
    
    private function __construct() {}

    public static function getDB() {
       if (self::$db == NULL){
        try{
         self::$db = new PDO('mysql:host=http://www.mhteam.bz.it;dbname=stackholder', 'stackholder', 'MHStackholder');
         self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
       }
       return self::$db;
    }
}
