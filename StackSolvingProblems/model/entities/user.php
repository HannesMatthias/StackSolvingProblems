<?php
    class User
    {
        private $id = 0;
        private $name = '';
        private $surname = '';
        private $age = 0;   
        private $sex = '';
        private $points = 0;
        private $rangid = 1;
        private $email = '';
        private $password = '';
        private $username = '';
        
    
 

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
            return $this->getName() . ' ' . $this->getSurname();
        }

        /* *** Getter und Setter *** */

        public function getId()
        { 
            return $this->id;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setSurname($surname)
        {
            $this->surname = $surname;
        }

        public function getSurname()
        {
            return $this->surname;
        }

        public function setAge($age)
        {
            $this->age = $age;
        }

        public function getAge()
        {
            return $this->age;
        }

        public function setSex($sex)
        {
            $this->sex = $sex;
        }
        public function getSex()
        {
            return $this->sex;
        }

        public function setPoints($points)
        {
            $this->points = $points;
        }

        public function getPoints()
        {
            return $this->points;
        }

        public function setRangid($rangid)
        {
            $this->rangid = $rangid;
        }

        public function getRangid()
        {
            return $this->rangid;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function setUsername($username)
        {
            $this->username = $username;
        }

        public function getUsername()
        {
            return $this->username;
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
                echo $e;
                 return FALSE;
            }
            return TRUE;
        }

        public function delete()
        {
            $sql = 'DELETE FROM users WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->id = 0;
        }

        /* ***** Private Methoden ***** */

        private function _insert()
        {
            $sql = 'INSERT INTO users (name, surname, age, sex, rang_id, points, email, password_hash, username) '
                 . 'VALUES (:name, :surname, :age, :sex, :rangid, :points, :email, :password, :username)';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
            echo "ID ".$this->id;
        }

        private function _update()
        {
            $sql = 'UPDATE users SET name=:name, surname=:surname, age=:age, sex =:sex, rang_id = :rangid,'
            .'points = :points, email=:email, password_hash =:password, username = :username'
                 . 'WHERE id=:id';
            $abfrage = self::$db->prepare($sql);
            $abfrage->execute($this->toArray());
        }

        /* ***** Statische Methoden ***** */

        public static function search($id)
        {
            $sql = 'SELECT * FROM users WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetch();
        }

        public static function searchAll()
        {
            $sql = 'SELECT * FROM users';
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetchAll();
        }

        public static function findByName($name)
        {
            $sql = 'SELECT * FROM users WHERE name=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($name));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetchAll();
        }
        public static function findByEmailAndPassword($email,$pass)
        {
        
            $sql = 'SELECT * FROM users WHERE email= ? AND password= ?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($email,$pass));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');

            return $abfrage->fetch();
            
        }

        public static function findByEmail($email)
        {
        
            $sql = 'SELECT * FROM users WHERE email= ?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($email));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');

            return $abfrage->fetch();
            
        }

        public function findUserTags(){
            return Tag::findeByUserId($this->getId());
        }
        
       
        
    }
?>