<?php
    class Question
    {
        private $id = 0;
        private $title = '';
        private $content = '';
        private $likes = 0;   
        private $dislikes = '';
        private $user_id = 0;
        private $solved = false;
        private $right_answer = null;
        
    
 

        public function __construct($daten = array())
        {
            // wenn $daten nicht leer ist, rufe die passenden Setter auf
            if ($daten) {
                foreach ($daten as $k => $v) {
                    $setterName = 'set' . ucfirst($k);
                    // wenn ein ungültiges Attribut übergeben wurde
                    // (ohne Setter), ignoriere es
                    if (method_exists($this, $setterName)) {
                        $this->$setterName($v);
                    }
                }
            }
        }

        public function  __toString()
        {
            return $this->getTitle().'  '.$this->getContent();
        }

        /* *** Getter und Setter *** */

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }
    
        public function getTitle(){
            return $this->title;
        }
    
        public function setTitle($title){
            $this->title = $title;
        }
    
        public function getContent(){
            return $this->content;
        }
    
        public function setContent($content){
            $this->content = $content;
        }
    
        public function getLikes(){
            return $this->likes;
        }
    
        public function setLikes($likes){
            $this->likes = $likes;
        }
    
        public function getDislikes(){
            return $this->dislikes;
        }
    
        public function setDislikes($dislikes){
            $this->dislikes = $dislikes;
        }
    
        public function getUserid(){
            return $this->user_id;
        }
    
        public function setUserid($userid){
            $this->user_id = $userid;
        }

        public function getSolved(){

            return $this->solved ;
        }
    
        public function setSolved($solved){
            $this->solved = $solved;
        }
                
        public function setRightAnswer($id){
            $this->right_answer = $id;
        }

        public function getRightAnswer(){

            return $this->right_answer;
        }
    
        
        

        public function toArray($mitId = true)
        {
            $attribute = get_object_vars($this);
            if ($mitId === false) {
                // wenn $mitId false ist, entferne den Schlüssel id aus dem Ergebnis
                unset($attribute['id']);
            }
            return $attribute;
        }

        /* *** Persistenz-Methoden *** */

        public function save()
        {
            try{
                if ( $this->getId() > 0 ) {
                    // wenn die ID eine Datenbank-ID ist, also größer 0, führe ein UPDATE durch
                    $this->_update();
                } else {
                    // ansonsten einen INSERT
                    if(!$this->_insert()) {
                        return false;
                    }
                }
            } catch (PDOException $e){
                echo $e->getMessage();
                 return FALSE;
            }
            return TRUE;
        }

        public function delete()
        {
            $sql = 'DELETE FROM questions WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->setId(0);
        }

        /* ***** Private Methoden ***** */

        private function _insert()
        {  
            $tagsPost = explode(" ", $_POST['tagPost']);
            if (count($tagsPost) <= 1){
                return false;
            }
            $sql = 'INSERT INTO questions (title, content, likes, dislikes, user_id, solved, right_answer) '
                 . 'VALUES (:title, :content, :likes, :dislikes, :user_id, :solved, :right_answer);';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
            
            $tags = $this->getAllTags();
            foreach($tagsPost as $t) {
                $sql = 'INSERT INTO questionhastags (question_id, tag_id) VALUES (?, ?)';
                $abfrage = DB::getDB()->prepare($sql);
                foreach($tags as $tag){
                    if( $tag->getTag() == $t){
                        $abfrage->execute(array($this->getId(),$tag->getId()) );
                        break;
                    }
                }
                
            }
            return true;
        }

        private function _update()
        { 
            $sql = 'UPDATE questions SET title=:title, content=:content, likes=:likes, dislikes=:dislikes, '
                .'user_id=:user_id, solved=:solved, right_answer=:right_answer WHERE id=:id;';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray());
        }

        /* ***** Statische Methoden ***** */

        public static function find($id)
        {
            $sql = 'SELECT * FROM questions WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Question');
            return $abfrage->fetch();
        }

        public static function findAll($sort)
        {
            $sql = 'SELECT * FROM questions ORDER BY solved ASC , id ' . $sort;
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Question');
            return $abfrage->fetchAll();
        }

        public static function findByTitle($title)
        {
            $sql = 'SELECT * FROM questions WHERE title LIKE "%'.$title.'%"  ';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute();
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Question');
            return $abfrage->fetchAll();
        }

        public static function findQuestionsByUserId($id) {
            $sql = 'SELECT * FROM questions WHERE user_id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Question');
            return $abfrage->fetchAll();
        }

        public function getAllTags(){
            return Tag::findAll();
        }

        public function findTags(){
            return Tag::findByQuestionId($this->getId());
        }

        public function findAnswers(){
            return Answer::findByQuestionid($this->getId());
        }

        public function findAnswerCount(){
            return Answer::findAnswerCount($this->getId());
        }

        public function findRightAnswer(){
            return Answer::find($this->getRightAnswer());
        }
    }
?>