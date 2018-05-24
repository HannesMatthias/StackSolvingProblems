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
        $errors = array();
        $errorList = array(
            "no_pw" => "Bitte geben Sie ein Passwort ein!",
            "no_email" => "Bitte geben Sie eine E-Mail ein!",
            "no_right" => "E-Mail oder Passwort falsch!"
        );
        $user = new User();
        if($_POST) {
            if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"]) ) {             
                $user = User::findByEmailAndPassword($_POST["email"], $_POST["password"]); 
                if ($user == null) {
                    $user = new User($_POST);
                    $errors[] = $errorList["no_right"];
                }else if($user != null) {
                    $_SESSION["user"] = $user;
                    header("Location: index.php");
                }

            }else {
                if (empty($_POST['email'])) {
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
       
        $this->addContext("template", "login/login");

    }

    public function register() {
        $daten = array();
        $errors = array();
        $errorList = array(
            "not_filled" => "Bitte füllen Sie alle Felder aus!",
            "no_pwd_match" => "Die Passwörter stimmen nicht überein!",
            "email_exists" => "Email schon Registerirt!"
        );
        $entries = array("email", "name", "surname", "username", "password");
        $user = new User();
        if($_POST) {
            foreach($entries as $e) {
                if(!isset($_POST[$e]) || empty($_POST[$e])) {
                    $errors[] = $errorList["not_filled"];
                    break;
                } else {
                    $daten[$e] = $_POST[$e];
                    if($e == "email"){
                        if($user->findByEmail($daten[$e]) != NULL){
                            $errors[] = $errorList["email_exists"];
                        }
                    } else if($e == "password"){
                        if ($daten[$e] != $_POST["re_password"]){
                            $errors[] = $errorList["no_pwd_match"];
                        }
                    }
                }
            }
            if(empty($errors)) {
                $user = new User($daten);
                $user->save(); 
                if ($user == null) {
                    $user = new User($_POST);
                    
                }/*else if($user != null) {
                    $_SESSION["user"] = $user;
                    header("Location: index.php");
                }*/

            }
            else {
                $user = new User($_POST);
            }
        }
        $this->addContext("errors", $errors);
        $this->addContext("user", $user);
        $this->addContext("template", "register/register");
    }
     
    private function addContext($key, $value){
        $this->context[$key] = $value;
    }


    private function generatePage($template) {
        extract($this->context);
        require_once 'view/' . $template . ".tpl.php";
    }
}

?>
