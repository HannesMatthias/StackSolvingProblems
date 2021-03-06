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
            return $this->getName();
        }

        /* *** Getter und Setter *** */

        public function getId()
        {
            return $this->id;
        }

        public function setTag($tag)
        {
            $this->tag = $tag;
        }

        public function getTag()
        {
            return $this->tag;
        }

        public static function findUserTags($id)
        {
            $sql = 'SELECT * FROM tags,userhastags WHERE tags.id = userhastags.tag_id and userhastags.user_id = $id';
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Tag');
            return $abfrage->fetchAll();
        }

        public static function findByQuestionId($id)
        {
            $sql = 'SELECT * FROM tags,questionhastags WHERE tags.id = questionhastags.tag_id and questionhastags.question_id = ' . $id;
            $abfrage = DB::getDB()->prepare($sql);
            $abfrage->execute(array($id));
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Tag');
            return $abfrage->fetchAll();
        }

        public static function findAll()
        {
            $sql = 'SELECT * FROM tags ORDER BY tag';
            $abfrage = DB::getDB()->query($sql);
            $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Tag');
            return $abfrage->fetchAll();
        }
    }