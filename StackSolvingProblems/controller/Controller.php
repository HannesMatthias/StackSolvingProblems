<?php

class Controller {

    private $context = array();

    public function run($aktion) {
        $this->$aktion();
        $this->generatePage($aktion);
    }

    public function menu() {}
    private function generatePage($template) {
        extract($this->context);
        require_once 'view/' . $template . ".tpl.php";
    }
}

?>
