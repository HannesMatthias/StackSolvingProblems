<?php
    class Commentar {

        private $id = 0;
        private $content = '';
        private $user_id = 0;
        private $project_id = 0;

        public function getId(){
            return $this->id;
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

        public function getProjectid(){
            return $this->project_id;
        }
    
        public function setProjectid($id){
            $this->project_id = $id;
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
            //$this->setEncoding();
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
                echo $e->getMessage();
                return FALSE;
            }
            return TRUE;
        }

        public function delete()
        {
            $sql = 'DELETE FROM commentar WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->id = 0;
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

        /* ***** Private Methoden ***** */

        private function _insert()
        {
            $sql = 'INSERT INTO commentar (content, user_id, project_id) '
                 . 'VALUES (:content,  :user_id, :project_id)';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
        }

        private function _update()
        {
            $sql = 'UPDATE commentar  SET content=:content, user_id =:user_id, project_id=:project_id'
                 . 'WHERE id=:id';
            $abfrage = self::$db->prepare($sql);
            $abfrage->execute($this->toArray());
            
        }

        /* ***** Statische Methoden ***** */

        public static function find($id)
        {
            $sql = 'SELECT * FROM commentar WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Commentar');
            return $abfrage->fetch();
        }

        public static function findAll()
        {
            $sql = 'SELECT * FROM comments';
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Commentar');
            return $abfrage->fetchAll();
        }

        public static function findByUserid($userid)
        {
            $sql = 'SELECT * FROM commentar WHERE user_id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($userid));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Commentar');
            return $abfrage->fetchAll();
        }

        public static function findByProjectid($id)
        {
        
            $sql = 'SELECT * FROM commentar WHERE project_id = ? ';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Commentar');

            return $abfrage->fetchAll();
            
        }

    }
?>