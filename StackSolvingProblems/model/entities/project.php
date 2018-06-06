<?php
    class Project
    {
        private $id = 0;
        private $likes = 0;
        private $dislikes = 0;
        private $status = '';
        private $description = '';
        private $title = '';
        private $user_id = 0;


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
            return $this->getTitle().'  '.$this->getDescription();
        }

        /* *** Getter und Setter *** */

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
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
        public function getStatus(){
            return $this->status;
        }
    
        public function setStatus($status){
            $this->status = $status;
        }
        public function getDescription(){
            return $this->description;
        }
    
        public function setDescription($description){
            $this->description = $description;
        }
        public function getTitle(){
            return $this->title;
        }
    
        public function setTitle($title){
            $this->title = $title;
        }
        public function getUser_id(){
            return $this->user_id;
        }
    
        public function setUser_id($user_id){
            $this->user_id = $user_id;
        }

        public function findUsername() {
            $p_user = User::find($this->getUser_id());
            return $p_user->getUsername();
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
                    $this->_insert();
                }
            } catch (PDOException $e){
                echo $e->getMessage();
                 return FALSE;
            }
            return TRUE;
        }

        public function delete()
        {
            $sql = 'DELETE FROM project WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->setId(0);
        }

        /* ***** Private Methoden ***** */

        private function _insert()
        {  
            $sql = 'INSERT INTO project (likes, dislikes, status, description, title, user_id) '
                 . 'VALUES (:likes, :dislikes, :status, :description, :title, :user_id);';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
        }

        private function _update()
        { 
            $sql = 'UPDATE project SET likes=:likes, dislikes=:dislikes, status=:status, description =:description, '
            . 'title = :title, user_id = :user_id WHERE id=:id;';     
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray());
        }

        /* ***** Statische Methoden ***** */

        public static function find($id)
        {
            $sql = 'SELECT * FROM project WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Project');
            return $abfrage->fetch();
        }

        public static function findAll()
        {
            $sql = 'SELECT * FROM project';
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Project');
            return $abfrage->fetchAll();
        }
    }
?>