<?php

require_once 'model/entities/user.php';
require_once 'model/entities/DB.php';
require_once 'model/entities/tag.php';
require_once 'model/entities/question.php';
require_once 'model/entities/project.php';
require_once 'model/entities/answer.php';
require_once 'model/entities/comment.php';
require_once 'model/entities/vote.php';
require_once 'model/entities/commentar.php';
require_once 'model/session.php';
require_once 'controller/Controller.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'slcPref';
$controller = new Controller();

if (method_exists($controller, $action)) {

    $controller->run($action);
}
?>
