<?php

require_once 'model/entities/user.php';
require_once 'model/entities/DB.php';
require_once 'controller/Controller.php';

$aktion = isset($_GET['aktion']) ? $_GET['aktion'] : 'idea/idea';
$controller = new Controller();

if (method_exists($controller, $aktion)) {

    $controller->run($aktion);
}
?>
