<?php
    class Vote
    {
        private $id = 0;
        private $vote = '';
        private $userid;
        private$questionid;

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
            return $this->getVote();
        }

        /* *** Getter und Setter *** */

        public function getId()
        {
            return $this->id;
        }

        public function setVote($Vote)
        {
            $this->vote = $Vote;
        }

        public function getVote()
        {
            return $this->vote;
        }

        public function setUserid($id)
        {
            $this->userid = $id;
        }

        public function getUserid()
        {
            return $this->userid;
        }

        public function setQuestionid($id)
        {
            $this->questionid = $id;
        }

        public function getQuestionid()
        {
            return $this->questionid;
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
            $sql = 'DELETE FROM vote WHERE id=?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute( array($this->getId()) );
            // Objekt existiert nicht mehr in der DB, also muss die ID zurückgesetzt werden
            $this->id = 0;
        }

        /* ***** Private Methoden ***** */

        private function _insert()
        {
            $sql = 'INSERT INTO vote (vote, user_id, question_id) '
                 . 'VALUES (:vote, :userid, :questionid)';

            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute($this->toArray(false));
            // setze die ID auf den von der DB generierten Wert
            $this->id = DB::getDB()->lastInsertId();
        }

        private function _update()
        {
            $sql = 'UPDATE vote SET vote=:vote'
                 . 'WHERE id=:id';
            $abfrage = self::$db->prepare($sql);
            $abfrage->execute($this->toArray());
        }

        public static function findVoteByUseridAndQuestionud($userid,$questionid)
        {
            $session = Session::getInstance();
            $user = $session->getSession("user");
            $sql = 'SELECT * FROM vote WHERE user_id = ? and question_id= ?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($userid,$questionid));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Vote');
            return $abfrage->fetch();
        }
    }