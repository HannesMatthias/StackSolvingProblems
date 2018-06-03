<?php
    class Answer {

        private $id = 0;
        private $likes = 0;
        private $dislikes = 0;
        private $content = '';
        private $user_id = 0;
        private $question_id = 0; 

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }
    
        public function getLikes(){
            return $this->like;
        }
    
        public function setLikes($like){
            $this->likes = $like;
        }
    
        public function getDislikes(){
            return $this->dislikes;
        }
    
        public function setDislikes($dislike){
            $this->dislikes = $dislike;
        }
    
        public function getContent(){
            return $this->content;
        }
    
        public function setContent($content){
            $this->content = $content;
        }
    
        public function getUserid(){
            return $this->user_id;
        }
    
        public function setUserid($userid){
            $this->user_id = $userid;
        }
    
        public function getQuestionid(){
            return $this->question_id;
        }
    
        public function setQuestionid($questionid){
            $this->question_id = $questionid;
        }

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
         //   $this->setEncoding();
        }

        public function  __toString()
        {
            return $this->getContent() ;
        }
        
        public function save()
        {
            $this->_insert();
     
            return TRUE;
        }

        public function delete()
        {
            $sql = 'DELETE FROM answers WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->id = 0;
        }

        /* ***** Private Methoden ***** */

        private function _insert()
        {
            $sql = 'INSERT INTO answers (content, likes, dislikes, user_id, question_id) '
                 . 'VALUES (:content, :likes, :dislikes, :user_id, :question_id)';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
        }

        private function _update()
        {
            $sql = 'UPDATE answers SET content=:content, likes=:likes, dislikes=:dislikes, user_id =:user_id, question_id = :question_id,'
                 . 'WHERE id=:id';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray());
            
        }

        /* ***** Statische Methoden ***** */

        public static function find($id)
        {
            $sql = 'SELECT * FROM answers WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Answer');
            return $abfrage->fetch();
        }

        public static function findAll()
        {
            $sql = 'SELECT * FROM answers';
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Answer');
            return $abfrage->fetchAll();
        }

        public static function findByUserid($userid)
        {
            $sql = 'SELECT * FROM answers WHERE user_id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($userid));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Answer');
            return $abfrage->fetchAll();
        }

        public static function findByQuestionid($id)
        {
            $sql = 'SELECT * FROM answers WHERE question_id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Answer');
            return $abfrage->fetchAll();
        }
        public static function findAnswerCount($questionid)
        {
            $sql = 'SELECT count(*) as count FROM answers WHERE question_id= ? ';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($questionid));
            return $abfrage->fetch();
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

    }


?>