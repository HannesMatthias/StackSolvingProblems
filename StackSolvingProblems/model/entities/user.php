<?php
    class User
    {
        private $id = 0;
        private $firstname = '';
        private $lastname = '';
        private $email = '';
        private $passwort = '';
        private $statusid = 0;
/*

<TestUser:>
        chef@gmail.com
        Test

</TestUser:>*/ 

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
            return $this->getFirstname() . ' ' . $this->getLastname();
        }

        /* *** Getter und Setter *** */

        public function getId()
        {
            return $this->id;
        }

        public function getFirstname()
        {
            return $this->firstname;
        }

        public function setFirstname($firstname)
        {
            $this->firstname = $firstname;
        }

        public function getLastname()
        {
            return $this->name;
        }

        public function setLastname($name)
        {
            $this->name = $name;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function getPasswort()
        {
            return $this->passwort;
        }

        public function setPasswort($passwort)
        {
            $this->passwort = $passwort;
        }

        public function getStatusId()
        {
            return $this->statusid;
        }

        public function setStatusId($statusid)
        {
            $this->statusid = $statusid;
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
            $sql = 'DELETE FROM user WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->id = 0;
        }

        /* ***** Private Methoden ***** */

        private function _insert()
        {
            $sql = 'INSERT INTO user (first_name, last_name, email, passwort, status_id) '
                 . 'VALUES (:firstname, :lastname, :email, :passwort, :statusid)';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
        }

        private function _update()
        {
            $sql = 'UPDATE user SET first_name=:firstname, last_name=:lastname, email=:email, '
                 . 'passwort=:passwort, status_id=:statusid '
                 . 'WHERE id=:id';
            $abfrage = self::$db->prepare($sql);
            $abfrage->execute($this->toArray());
        }

        /* ***** Statische Methoden ***** */

        public static function search($id)
        {
            $sql = 'SELECT * FROM user WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetch();
        }

        public static function searchAll()
        {
            $sql = 'SELECT * FROM user';
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetchAll();
        }

        public static function findByFirstname($firstname)
        {
            $sql = 'SELECT * FROM user WHERE first_name=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($firstname));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetchAll();
        }
        public static function findByEmail($email,$pass)
        {
            try{
                $sql = 'SELECT * FROM user WHERE email=? AND password=?';
                $abfrage = DB::getDB()->prepare($sql);
                $abfrage->execute(array($email,$pass));
                $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
                $user = $abfrage->fetch();
                return $user;
            }catch (PDOException $e){
                return null;
            }
            return null;
        }
        
       
        
    }
?>