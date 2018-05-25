<?php

class Controller {

    private $context = array();

    public function run($action) {
        $this->$action();
        $this->generatePage($action);
    }

    public function main() {
        $this->addContext("template", "main/main");
    }

    public function login() {    
        $session = Session::getInstance();
        if($session->getSession("user") != null ) { //Hier eigentlich sinnlos.
            header("Location: index.php");
            exit;
        }


        $errors = array();
        $errorList = array(
            "no_pw" => "Bitte geben Sie ein Passwort ein!",
            "no_email" => "Bitte geben Sie eine E-Mail ein!",
            "no_right" => "E-Mail oder Passwort falsch!"
        );

        $user = new User();
        if($_POST) {
            if(isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["password"]) && !empty($_POST["password"]) ) {             
                $user = User::einloggen($_POST["name"], $_POST["password"]); 
                if ($user == null) {
                    $user = new User($_POST);
                    $errors[] = $errorList["no_right"];
                }else if($user != null) {
                    $session->setSession("user", $user);
                    header("Location: index.php?hahah");
                }


            }else {
                if (empty($_POST['name'])) {
                    $errors[] = $errorList["no_email"];
                } 

                if (empty($_POST['password'])) {
                    $errors[] = $errorList["no_pw"];
                }

            }
        }else {
            $user = new User();
        }
        $this->addContext("errors", $errors);
        $this->addContext("user", $user);

       $this->addContext("template", "main/main");

    }

    public function register() {
        $daten = array();
        $errors = array();
        $errorList = array(
            "not_filled" => "Bitte füllen Sie alle Felder aus!",
            "no_pwd_match" => "Die Passwörter stimmen nicht überein!"
        );
        $entries = array("name", "surname",  "email", "password", "username", "re_password");
        $user = new User();
        if($_POST) {
            foreach($entries as $e) {
                if(!isset($_POST[$e]) || empty($_POST[$e])) {
                    $errors[0] = $errorList["not_filled"];
                } else {
                    $daten[$e] = $_POST[$e];
                }
            }
            $user = new User($daten);
            if(empty($errors)) {
                if($daten["password"] != $daten["re_password"]) {
                    $errors[] = $errorList["no_pwd_match"];
                } else {
                    array_pop($daten);
                    $user->save();
                    header("Location: index.php");
                    exit();
                }
            }
        }
        $this->addContext("errors", $errors);
        $this->addContext("user", $user);
        $this->addContext("template", "register/register");
    }


    public function logout() {}
    private function addContext($key, $value){
        $this->context[$key] = $value;
    }
    

    private function generatePage($template) {
        extract($this->context);
        require_once 'view/' . $template . ".tpl.php";
    }
}

?>
