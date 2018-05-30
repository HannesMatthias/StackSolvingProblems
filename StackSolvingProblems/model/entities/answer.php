<?php
    class Answer {

        private $id = 0;
        private $like = 0;
        private $dislike = 0;
        private $content = '';
        private $userid = 0;
        private $questionid = 0; 

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }
    
        public function getLike(){
            return $this->like;
        }
    
        public function setLike($like){
            $this->like = $like;
        }
    
        public function getDislike(){
            return $this->dislike;
        }
    
        public function setDislike($dislike){
            $this->dislike = $dislike;
        }
    
        public function getContent(){
            return $this->content;
        }
    
        public function setContent($content){
            $this->content = $content;
        }
    
        public function getUserid(){
            return $this->userid;
        }
    
        public function setUserid($userid){
            $this->userid = $userid;
        }
    
        public function getQuestionid(){
            return $this->questionid;
        }
    
        public function setQuestionid($questionid){
            $this->questionid = $questionid;
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
            $this->setEncoding();
        }

        public function  __toString()
        {
            return $this->getContent() ;
        }
        
        public function save()
        {
            try{
                if ( $this->getId() > 0 ) {
                    // wenn die ID eine Datenbank-ID ist, also größer 0, führe ein UPDATE durch
                    $this->_update();
                } else {
                    // ansonsten einen INSERT
                    $this->_insert();
                }
            } catch (PDOException $e){
                echo $e;
                return FALSE;
            }
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
            $sql = 'INSERT INTO answers (id, content, likes, dislikes, user_id, question_id) '
                 . 'VALUES (:id, :content, :likes, :dislikes, :userid, :questionid)';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
        }

        private function _update()
        {
            $sql = 'UPDATE answers  SET content=:content, likes=:likes, dislike=:dislike, user_id =:userid, question_id = :questionid,'
                 . 'WHERE id=:id';
            $abfrage = self::$db->prepare($sql);
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

        public static function findByUseridAndQuestionid($userid,$questionid)
        {
            $sql = 'SELECT * FROM answers WHERE user_id=? and question_id= ? ';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($userid,$questionid));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Answer');
            return $abfrage->fetchAll();
        }
    }
?>