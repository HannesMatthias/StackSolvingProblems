<?php

require_once 'model/entities/DB.php';
require_once 'model/entities/seminartermin.php';
require_once 'model/entities/benutzer.php';
require_once 'model/entities/seminar.php';

require_once 'controller/Controller.php';


$aktion = isset($_GET['aktion']) ? $_GET['aktion'] : 'register';
$controller = new Controller();

if (method_exists($controller, $aktion)) {

    $controller->run($aktion);
}
?>
