<?php
    class User
    {
        private $id = 0;
        private $name = '';
        private $surname = '';
        private $birthdate = 0;   
        private $sex = '';
        private $points = 0;
        private $rang_id = 1;
        private $email = '';
        private $password_hash = '';
        private $username = '';
        private $verified = false;
        
    
 

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

       

        /* *** Getter und Setter *** */

        public function getId()
        {
            return $this->id;
        }

        public function setName($name)
        {
            $this->name = $name;
        }
        
        public function getVerified()
        {
            return $this->verified;
        }

        public function setVerified($verified)
        {
            $this->verified = $verified;
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

        public function setBirthdate($birthdate)
        {
            $this->birthdate = $birthdate;
        }

        public function getBirthdate()
        {
            return $this->birthdate;
        }

        public function setSex($sex)/*vergewaltigung*/
        {
            $this->sex = $sex;
        }
        public function getSex()/*normaler sex*/
        {
            return $this->sex;
        }

        public function setRangid($rangid)
        {
            $this->rang_id = $rangid;
        }

        public function getRangid()
        {
            return $this->rang_id;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setPassword_hash($password_hash)
        {
            $this->password_hash = $password_hash;
        }

        public function getPassword_hash()
        {
            return $this->password_hash;
        }

        public function setUsername($username)
        {
            $this->username = $username;
        }

        public function getUsername()
        {
            return $this->username;
        }

        public function setPoints($points)
        {
            $this->points = $points;
        }

        public function getPoints()
        {
            return $this->points;
        }
        
        public function alterVerified(){
            $wert = getVerified();
            setVerified(!$wert);
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
            $sql = 'DELETE FROM user WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->id = 0;
        }

        /* ***** Private Methoden ***** */

        private function _insert()
        {
            $sql = 'INSERT INTO users (name, surname, birthdate, sex, rang_id, points, email, password_hash, username, verified) '
                 . 'VALUES (:name, :surname, :birthdate, :sex, :rang_id, :points, :email, :password_hash, :username, :verified)';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
        }

        private function _update()
        {
            $sql = 'UPDATE users SET name=:name, surname=:surname, birthdate=:birthdate, sex =:sex, rang_id = :rang_id,'
            .'points = :points, email=:email, password_hash =:password_hash, username = :username, verified=:verified'
                 . 'WHERE id=:id';
            $abfrage = self::$db->prepare($sql);
            $abfrage->execute($this->toArray());
        }

        /* ***** Statische Methoden ***** */

        public static function find($id)
        {
            $sql = 'SELECT * FROM users WHERE id=:id';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->bindParam(':id', $id);
            $abfrage->execute();
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetch();
        }

        public static function findAll()
        {
            $sql = 'SELECT * FROM users';
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetchAll();
        }

        public static function findByName($name)
        {
            $sql = 'SELECT * FROM users WHERE name=:name';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->bindParam(':name', $name);
            $abfrage->execute();
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $abfrage->fetchAll();
        }
        public static function findByEmail($email)
        {
            $sql = 'SELECT * FROM users WHERE email=:email';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->bindParam(':email', $email);
            $abfrage->execute();
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');

            return $abfrage->fetch();
            
        }

        public function findTags(){
            return Tag::findeByUserId($this->getId());
        }

        public static function setCode($email,$code)
        {
            $sql = 'UPDATE users SET code = ? WHERE users.email = ?;';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($code,$email));

        }
        
        public function findQuestions(){
            return Question::findQuestionsByUserId($this->getId());
        }
        public static function einloggen($email,$pass)
            {
                
                    $sql = 'SELECT * FROM users WHERE (email= :email AND password_hash= :password_hash) OR (username = :email AND password_hash = :password_hash)';
                    $abfrage = DB::getDB()->prepare($sql);
                    $abfrage->execute(array(":email"=> $email,
                                            ":password_hash"=> $pass
                    ));
                    $abfrage->setFetchMode(PDO::FETCH_CLASS, 'User');
        
                    return $abfrage->fetch();
                    
            }

        public function verified($aktuelleMail){
            $code = rand()."AA".rand()."FF";
            $recipient = $aktuelleMail;
            $subject = "Verified";
            $mail_body = "Just one more step... \r\n".$code;
            try{
                mail($recipient, $subject, $mail_body);
            }catch(Exception $e){
                echo $e->getMessage();
            }
            $this->setCode($aktuelleMail, $code);
        }
        
    }
?>