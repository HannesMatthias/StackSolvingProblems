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
        //$this->addContext("projects", $projects);
    }

    public function editProfil() {
        $this->addContext("template", "editProfil");
        $session = Session::getInstance();
        $user = $session->getSession("user");
        $this->addContext("user", $user);
    }

    public function saveProfil() {
        $this->addContext("template", "profil");
        $session = Session::getInstance();
        $user = $session->getSession("user");
        $user->setName($_POST['name']);
        $user->setSurname($_POST['surname']);
        $user->setBirthdate($_POST['birthdate']);
        $user->setEmail($_POST['email']);
        $user->save();
        $session->setSession("user", $user);
        $questions = Question::findQuestionsByUserId($user->getId());
        $this->addContext("questions", $questions);
        $this->addContext("user", $user);
        //$this->addContext("projects", $projects);
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

    public function addIdea() {
        $session = Session::getInstance();
        if($session->getSession("user") == null ) {
            header("Location: index.php");
            exit;
        }
        $user = $session->getSession("user");
        $idea = new Project();
        if(isset($_POST["description"]) && !empty($_POST["description"]) && isset($_POST["title"]) && !empty($_POST["title"])) {
            $idea = new Project($_POST);
            $idea->setUser_id($user->getId());
            if($idea->save()) {
                echo "Erfolgreich!";
                header("Location: index.php?action=main");
                exit();
            }else {
                echo "Fehler!!";
            }

           $this->addContext("idea", $idea);

        } else if(isset($_GET["id"]) && !empty($_GET["id"])) {
            $idea = Project::find($_GET["id"]);
            if($idea != null && $user->getId() == $idea->getUser_id()) {
                $this->addContext("idea", $idea);
            } else {
                header("Location: index.php?action=main");
                exit();
            }

        } else {
            $idea = new Project($_POST);
        }

        $this->addContext("template", "addIdea/addIdea");
        $this->addContext("idea", $idea);
    }
    public function login() {    
     
        $this->addContext("code", "");
        $this->addContext("info", "");
        $this->addContext("template", "slcPref/slcPref");

        $session = Session::getInstance();
        if($session->getSession("user") != null ) { //Hier eigentlich sinnlos.
            //header("Location: index.php");
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
            if(isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["password_hash"]) && !empty($_POST["password_hash"]) ) {             
                $user = User::einloggen($_POST["name"]); 
                if ($user != null) {
                    if(password_verify($_POST["password_hash"], $user->getPassword_hash())) {
                        if(!$user->getVerified()) {  
                            $this->addContext("code", $user->getCode());
                            $this->addContext("info", "Oops!, Du hast dich noch nicht verifiziert! Schau in dein Email Postfach");
                        }else {
                            $session->setSession("user", $user);
                        } 
                        
                    }
                } else {
                    $user = new User($_POST);
                    $errors[] = $errorList["no_right"];
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
            "email_exists" => "Email bereits registriert!",
            "username_exists" => "Username bereits registriert!"
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
                if($user->findByUsername($daten["username"]) != NULL) {
                    $errors[] = $errorList["username_exists"];
                }
                if($daten["password_hash"] != $daten["re_password_hash"]) {
                    $errors[] = $errorList["no_pwd_match"];
                }
                if(empty($errors)) {
                    array_pop($daten);
                    if($user->save() ) {
                        echo "Email: " . $daten["email"];
                        $user->verified();
                        $user->save();
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
        $this->addContext("questions1", $questions);
    }

    public function search() {
        $this->addContext("template", "forum_questions/question");
        $questions = Question::findByTitle($_POST['search']);
        $this->addContext("questions1", $questions);
    }

    public function fullQuestion() {


        $question = Question::find($_GET["id"]);
        //var_dump($question);
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
                        $question->setLikes($question->getLikes()+1);
                        $question->save();
                        $vote = new Vote;
                        $vote->setVote(1);
                        $vote->setUserid($user->getId());
                        $vote->setQuestionid($_GET['id']);
                        $vote->save();
                        header("Refresh:0");
                }else if(isset($_POST["dislike"]) ) {
                        $question->setDislikes($question->getDislikes()+1);
                        $question->save();
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
                    $question->setSolved(true);
                    $question->save();
                    header("Refresh:0");
                }
                if(isset($_POST["solvedFalse"]) ) {    
                    $question->setSolved(false);
                    $question->save();
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
        $this->addContext("vote", $v);
        $this->addContext("questionOwner", $questionOwner);
        $this->addContext("solved", $question->getSolved());
        $this->addContext("user", $user);
        
    }

    public function ideaInterface() {
        $session = Session::getInstance();
        $user = $session->getSession("user");

        $idea = Project::find($_GET["id"]);
        $user_p = Project::findUser($idea->getUser_id());
        $rights = false;
        if($user != null && $idea->getUser_id() == $user->getId()) {
            $rights = true;
        }
        $this->addContext("template", "ideaInterface/ideaInterface");
        $this->addContext("idea", $idea);
        $this->addContext("user_p", $user_p);
        $this->addContext("rights", $rights);
        

    }

    public function logout() {}
    public function slcPref() {
        $this->addContext("code", "");
        $this->addContext("info", "");
        $this->addContext("template", "slcPref/slcPref");
    }
    public function forum_intro() {
        $this->addContext("template", "forum_intro/intro");
    }
    public function verify() {
        if(isset($_GET["verify"]) && $_GET["verify"]) {
           $user= User::findByCode($_GET["verify"]);
           if($user != null) {
               if(!$user->getVerified() ) {
                    $user->setVerified(true);
                    $this->addContext("success", "green");
                    $this->addContext("info", "Glückwunsch du bist nun verifiziert und es kann losgehen!");
                    $user->save();
               }
              
           }
        }
        $this->addContext("template", "slcPref/slcPref");
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
