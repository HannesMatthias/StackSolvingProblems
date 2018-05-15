<?php 
    $aktion = isset($_GET['aktion']) ? $_GET['aktion'] : 'home';
    $controller = new Controller();

    if (method_exists($controller, $aktion)) {

        $controller->run($aktion);
    }
?>