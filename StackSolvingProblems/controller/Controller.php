<?php

class Controller {

    private $context = array();

    public function run($aktion) {
        $this->$aktion();
        $this->generatePage($aktion);
    }

    public function idea() {

        $this->addContext("template", "idea/idea");

    }

     
    private function addContext($key, $value){
        $this->context[$key] = $value;
    }


    private function generatePage($template) {
        extract($this->context);
        require_once 'view/' . $template . ".tpl.php";
    }
}

?>
