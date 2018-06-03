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
        $this->addContext("template", "profil");
        $session = Session::getInstance();
        $user = $session->getSession("user");
        $questions = Question::findQuestionsByUserId($user->getId());
        $this->addContext("questions", $questions);


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
        $this->addContext("edit", false);
      
        if(isset($_POST["content"]) && !empty($_POST["content"])) {
            $frage = new Question($_POST);
            $frage->setUserid($user->getId());
           
            if(isset($_POST["save"]) && $_POST["save"] != null) {
                if($frage->save() ) {
                    echo "Erfolgreich!";      
                }else {
                    echo "Fehler!!";
                }
            }else {
                $this->addContext("edit", true);
            }

           $this->addContext("title", $_POST["title"]);
           $this->addContext("preview", $_POST["content"]);
            if($_POST["id"] != 0) {
                $this->addContext("id", $_POST["id"]);
            }

        }else if(isset($_GET["id"]) && $_GET["id"]) {
          
            $frage = Question::find($_GET["id"]);
           
            if($frage != null) {
                $this->addContext("id", $frage->getId());
                $this->addContext("title", $frage->getTitle());
                $this->addContext("preview", $frage->getContent());
                $this->addContext("edit", true);
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
                    header("Location: index.php");
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
            "no_pwd_match" => "Die Passwörter stimmen nicht überein!",
            "email_exists" => "Email schon Registerirt!"
        );
        $entries = array("name", "surname",  "email", "password", "username", "re_password");
        $user = new User();
        if($_POST) {
            foreach($entries as $e) {
                if(!isset($_POST[$e]) || empty($_POST[$e])) {
                    $errors[0] = $errorList["not_filled"];
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
            $user = new User($daten);
            if(empty($errors)) {
                if($daten["password"] != $daten["re_password"]) {
                    $errors[] = $errorList["no_pwd_match"];
                } else {
                    array_pop($daten);
                    if($user->save()) {
                        $this->verification($daten["email"]);
                        echo "Email: ".$daten["email"];
                        header("Location: index.php");
                        exit();
                    }

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

    public function fullQuestion() {


        $question = Question::find($_GET["id"]);
        $this->addContext("template", "forum_questions/fullquestion");
        $this->addContext("question", $question);
        if(!isset($_GET["id"]) && !$_GET["id"]) {

            exit();
        }
        $session = Session::getInstance();
        $user = $session->getSession("user");
        $v = 0;
        $voteCheck = Vote::findVoteByUseridAndQuestionud($user->getId(),$_GET['id']);
        if($voteCheck != Null){
            $v = $voteCheck->getVote();
        }

        $questionOwner = false;
        if($v == 0){
            #Voten
           if(isset($_POST["like"]) ) {
                $frage = Question::find($_GET["id"]);
                $frage->setLikes($frage->getLikes()+1);
                $frage->save();
                $vote = new Vote;
                $vote->setVote(1);
                $vote->setUserid($user->getId());
                $vote->setQuestionid($_GET['id']);
                $vote->save();
                header("Refresh:0");
           }else if(isset($_POST["dislike"]) ) {
                $frage = Question::find($_GET["id"]);
                $frage->setDislikes($frage->getDislikes()+1);
                $frage->save();
                $vote = new Vote;
                $vote->setVote(-1);
                $vote->setUserid($user->getId());
                $vote->setQuestionid($_GET['id']);
                $vote->save();
                header("Refresh:0");
           }
        }
        if($question->getUserid() == $user->getId()){
            if(isset($_POST["solvedTrue"]) ) {    
                $frage = Question::find($_GET["id"]);
                $frage->setSolved(true);
                $frage->save();
                header("Refresh:0");
            }
            if(isset($_POST["solvedFalse"]) ) {    
                $frage = Question::find($_GET["id"]);
                $frage->setSolved(false);
                $frage->save();
                header("Refresh:0");
            }
            $questionOwner = true;
        }
        $this->addContext("vote", $v);
        $this->addContext("questionOwner", $questionOwner);
        $this->addContext("solved", $question->getSolved());
        #Antworten

        if(isset($_POST["answer_send"]) ) {
            $session = Session::getInstance();
            $user = $session->getSession("user");
            $answer = new Answer();
            $answer->setUserid($user->getId());
            $answer->setQuestionid($_POST["id"]);
            $answer->setContent($_POST["content"]);
            $answer->save();
            
        }

        

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
