<?php
    class Vote
    {
        private $id = 0;
        private $vote = '';

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
            $this->tag = $Vote;
        }

        public function getVote()
        {
            return $this->vote;
        }

        public static function findVoteByUseridAndQuestionud($id)
        {
            $session = Session::getInstance();
            $user = $session->getSession("user");
            $sql = 'SELECT * FROM vote WHERE user_id = ? and question_id= ?';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($user->getId(),$id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Vote');
            return $abfrage->fetchAll();
        }
    }