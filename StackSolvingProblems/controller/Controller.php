<?php

class Controller {

    private $context = array();

    public function run($aktion) {
        $this->$aktion();
        $this->generatePage($aktion);
    }

    private function generatePage($template) {
        extract($this->context);
        require_once 'view/' . $template . ".tpl.php";
    }
}

?>
