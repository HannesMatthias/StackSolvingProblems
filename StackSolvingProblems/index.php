<?php

require_once 'model/entities/user.php';
require_once 'model/entities/DB.php';
require_once 'controller/Controller.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'idea';
$controller = new Controller();

if (method_exists($controller, $action)) {

    $controller->run($action);
}
?>
