<?php

class Session{
   
    private static $instance;

    private function __construct() {
       
    }

    public static function getInstance() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(self::$instance == null) {

            self::$instance = new Session();
        }
        return self::$instance;

    }

    public function getSession($key) {
        return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
    }
    public function setSession($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public function __destruct() {
      //  session_destroy(); 
    }

    public function __toString() {
        return "Session";
    }

}
