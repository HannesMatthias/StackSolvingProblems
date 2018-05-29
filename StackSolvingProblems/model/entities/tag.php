<?php
    class Tag
    {
        private $id = 0;
        private $tag = '';
        

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
            return $this->getTag();
        }

        /* *** Getter und Setter *** */

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }
    
        public function getTag(){
            return $this->tag;
        }
    
        public function setTag($tag){
            $this->tag = $tag;
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
                 return FALSE;
            }
            return TRUE;
        }

        public function delete()
        {
            $sql = 'DELETE FROM tags WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->id = 0;
        }

        /* ***** Private Methoden ***** */

        private function _insert()
        {
            $sql = 'INSERT INTO tags (tag) VALUES (:tag)';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
        }

        private function _update()
        {
            $sql = 'UPDATE tags SET tag=:tag WHERE id=:id';
            $abfrage = self::$db->prepare($sql);
            $abfrage->execute($this->toArray());
        }

        /* ***** Statische Methoden ***** */

        public static function find($id)
        {
            $sql = 'SELECT * FROM tags WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Tag');
            return $abfrage->fetch();
        }

        public static function findAll()
        {
            $sql = 'SELECT * FROM tags';
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Tag');
            return $abfrage->fetchAll();
        }
    }
?>