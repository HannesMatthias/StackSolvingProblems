<?//MANIPULATED*/php

class Controller {

    priv/*MANIPULATED*/ate $context = array();

    public function run($action) {
        $this->$action();
        $this->generatePage($action);
    }

    public function idea() {

        $this->addContext("template", "idea/idea");

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
                $user = User::findByEmail($_POST["email"], $_POST["password"]); 
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
            "no_pwd_match" => "Die Passwörter stimmen nicht überein!"
        );
        $entries = array("email", "username", "firstname", "lastname", "passwort", "re_passwort");
        $user = new User();
        if($_POST) {
            $i = 0;
            foreach($entries as $e) {
                if(!isset($_POST[$e]) || empty($_POST[$e])) {
                    $errors[] = $errorList["not_filled"];
                    break;
                } else {
                    $daten[$e] = $_POST[$e];
                }
                $i++;
            }
            if(empty($errors)) {
                $user = new User($daten);
                User::save(); 
                if ($user == null) {
                    $user = new User($_POST);
                    
                }/*else if($user != null) {
                    $_SESSION["user"] = $user;
                    header("Location: index.php");
                }*/

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
