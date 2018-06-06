<?php

class Controller {

    private $context = array();

    public function run($action) {
        $this->$action();
        $this->generatePage($action);
    }

    public function main() {
        $this->addContext("template", "main/main");
        $ideas = Project::findAll();
        $this->addContext("ideas", $ideas);
    }

    public function profil() {
        $this->addContext("template", "profil");
        $session = Session::getInstance();
        $user = $session->getSession("user");
        $questions = Question::findQuestionsByUserId($user->getId());
        //$projects = Project::fin
        $this->addContext("questions", $questions);
        $this->addContext("user", $user);
        $this->addContext("projects", $projects);
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
            exit();
        }

        $this->addContext("code", "");
        $this->addContext("info", "");
        $errors = array();
        $errorList = array(
            "no_pw" => "Bitte geben Sie ein Passwort ein!",
            "no_email" => "Bitte geben Sie eine E-Mail ein!",
            "no_right" => "E-Mail oder Passwort falsch!"
        );

        $user = new User();
        if($_POST) {
            if(isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["password_hash"]) && !empty($_POST["password_hash"]) ) {             
                $user = User::einloggen($_POST["name"], $_POST["password_hash"]); 
                if ($user == null) {
                    $user = new User($_POST);
                    $errors[] = $errorList["no_right"];
                }else if($user != null) {
                    if(!$user->getVerified()) {  
                        $this->addContext("code", $user->getCode());

                        $this->addContext("info", "Oops!, Du hast dich noch nicht verifiziert! Schau in dein Email Postfach");
                        
                    }  
                    $session->setSession("user", $user);
                 
                }


            }else {
                if (empty($_POST['name'])) {
                    $errors[] = $errorList["no_email"];
                } 

                if (empty($_POST['password_hash'])) {
                    $errors[] = $errorList["no_pw"];
                }

            }
        }else {
            $user = new User();
        }
        $this->addContext("errors", $errors);
        $this->addContext("user", $user);
       // $this->addContext("template", "forum_questions/question");


    }

    public function register() {
        $daten = array();
        $errors = array();
        $errorList = array(
            "not_filled" => "Bitte füllen Sie alle Felder aus!",
            "no_pwd_match" => "Die Passwörter stimmen nicht überein!",
            "email_exists" => "Email schon Registriert!"
        );
        $entries = array("name", "surname",  "email", "password_hash", "username", "re_password_hash");
        $user = new User();
        if($_POST) {
            $filled = true;
            foreach($entries as $e) {
                if(!isset($_POST[$e]) || empty($_POST[$e])) {
                    $errors[0] = $errorList["not_filled"];
                    $filled = false;
                } else {
                    $daten[$e] = $_POST[$e];
                }
            }
            $user = new User($daten);
            if($filled) {
                if($user->findByEmail($daten["email"]) != NULL){
                    $errors[] = $errorList["email_exists"];
                }
                if($daten["password_hash"] != $daten["re_password_hash"]) {
                    $errors[] = $errorList["no_pwd_match"];
                }
                if(empty($errors)) {
                    array_pop($daten);
                    if($user->save()) {
                        $user->verified($daten["email"]);
                        echo "Email: ".$daten["email"];
                        header("Location: index.php");
                        exit();
                    }
                }
            } else {
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
        $tags = $question->findTags();
        $this->addContext("template", "forum_questions/fullquestion");
        $this->addContext("question", $question);
        $this->addContext("tags", $tags);
        
        $session = Session::getInstance();
        $user = $session->getSession("user");

        $questionOwner = false;
        $v = 10;
        if($user != null) {
            $voteCheck = Vote::findVoteByUseridAndQuestionud($user->getId(),$_GET['id']);
            if($voteCheck != Null){
                $v = $voteCheck->getVote();
            } else {
                $v = 0;
            }

            
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
        $this->addContext("vote", 10);
        $this->addContext("questionOwner", $questionOwner);
        $this->addContext("solved", $question->getSolved());
        $this->addContext("user", $user);

    }

    public function logout() {}
    public function slcPref() {
        $this->addContext("template", "slcPref/slcPref");
    }
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
