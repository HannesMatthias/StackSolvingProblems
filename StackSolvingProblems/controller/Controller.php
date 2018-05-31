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

    public function profil() {
        
    }

    public function addQuestion() {   
       
        $session = Session::getInstance();
        if($session->getSession("user") == null ) {
            header("Location: index.php");
            exit;
        }
        
        $user = $session->getSession("user");

        $this->addContext("template", "forum_addQuestion/addQuestion");
        $this->addContext("id", "0");
        $this->addContext("preview", "");
        $this->addContext("title", "");
        $this->addContext("tags", Tag::findAll());

      
        if(isset($_POST["question"]) && !empty($_POST["question"])) {
            $_POST['tag'] = array_unique($_POST['tag']);
            $frage = new Question($_POST);
            $frage->setUserid($user->getId());
           
            if(isset($_POST["save"]) && $_POST["save"] != null) {
                if($frage->save() ) {
                    echo "Erfolgreich!";
                   
                }else {
                    echo "Fehler!!";
                }
            }

           $this->addContext("title", $_POST["title"]);
           $this->addContext("preview", $_POST["question"]);
            if($_POST["id"] != 0) {
                $this->addContext("id", $_POST["id"]);
            }

        }else if(isset($_GET["id"]) && $_GET["id"]) {
          
            $frage = Question::findQuestionWithID($_GET["id"]);
           
            if($frage != null) {
                $this->addContext("id", $frage->getId());
                $this->addContext("title", $frage->getTitle());
                $this->addContext("preview", $frage->getQuestion());
            }
            
            
        }

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
    public function verification($aktuelleMail){
        $code = rand()."AA".rand()."FF".rand();
        //$recipient = $aktuelleMail; meine Email nur zum Testen ;)
        $recipient = "kevin.sorg.el.moumene@gmail.com";
        $subject = "Verification";
        $mail_body = "Just one more step... \r\n".$code;
        try{
            mail($recipient, $subject, $mail_body);
        }catch(Exception $e){
            echo $e;
        }
        User::setCode($email, $code);
    }

    public function register() {
        $daten = array();
        $errors = array();
        $errorList = array(
            "not_filled" => "Bitte füllen Sie alle Felder aus!",
            "no_pwd_match" => "Die Passwörter stimmen nicht überein!",
            "email_exists" => "Email schon registriert!"
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
            if($user->findByEmail($daten["email"]) != NULL){
                $errors[] = $errorList["email_exists"];
            }
            $user = new User($daten);
            if(empty($errors)) {
                if($daten["password"] != $daten["re_password"]) {
                    $errors[] = $errorList["no_pwd_match"];
                } else {
                    array_pop($daten);
                    $user->save();
                    $this->verification($daten["email"]);
                    echo "Email: ".$daten["email"];
                    header("Location: index.php");
                    exit();
                }
            }
            else {
                $user = new User($_POST);
            }
        }

        $this->addContext("errors", $errors);
        $this->addContext("user", $user);
        $this->addContext("template", "register/register");
    }

    public function questions() {
        $this->addContext("template", "forum_questions/question");
        $questions = Question::findAll();
        $this->addContext("questions", $questions);
    }

    public function fullQuestions() {
        $this->addContext("template", "forum_questions/fullQuestions");
        $questions = Question::findAll();
        $this->addContext("questions", $questions);
    }


    public function logout() {}
    public function forum_intro() {
        $this->addContext("template", "forum_intro/intro");
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
