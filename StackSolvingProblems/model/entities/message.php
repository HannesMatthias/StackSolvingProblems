<?php 
    class Message{  
        private $id = 0;
        private $message = 0;
        private $creator_id = 0;
        private $create_date = 0;
        private $parent_message_id = 0;
        private $expiry_date = 0;

        //getter und setter
        public function getId()
        {
            return $this->id;
        }
        public function setId($id)
        {
            $this->id=$id;
        }
    
        public function getMessage()
        {
            return $this->message;
        }
        public function setMessage($message)
        {
            $this->message=$message;
        }

        public function getCreator_id()
        {
            return $this->creator_id;
        }
        public function setCreator_id($creator_id)
        {
            $this->creator_id=$creator_id;
        }

        public function getCreate_date()
        {
            return $this->create_date;
        }
        public function setCreate_date($create_date)
        {
            $this->create_date=$create_date;
        }

        public function getParent_message_id()
        {
            return $this->parent_message_id;
        }
        public function setParent_message_id($parent_message_id)
        {
            $this->parent_message_id=$parent_message_id;
        }

        public function getExpiry_date()
        {
            return $this->expiry_date;
        }
        public function setExpiry_date($expiry_date)
        {
            $this->expiry_date=$expiry_date;
        }

        //methoden

        //public function 
    }
?>