<?php 
    $username;
    $status;
    $likes;
    $dislikes;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="view/main/main.css">
    <link rel="stylesheet" type="text/css" href="view/ideaLabel/ideaLabel.css">
    <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
    <link rel="stylesheet" type="text/css" href="view/infoboxes/infoboxes.css">
</head>
<body>
<div class="menu">
    <?php include_once "view/menu/menu.php";?>
</div>
<div class="infoboxes">
    <?php include_once "view/infoboxes/infoboxes.php";?>
</div>
<div>
    <?php include_once "view/ideaLabel/ideaLabel.php";?>
</div>
</body>
</html>
