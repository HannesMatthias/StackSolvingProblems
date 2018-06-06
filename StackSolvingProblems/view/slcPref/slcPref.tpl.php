<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="view/slcPref/slcPref.css">
    <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src="plugins/js/jquery.min.js"></script>
        <script src="plugins/js/clickmenu.js"></script>
        <script src="plugins/js/addAnswer.js"></script>
</head>
<body>
<?php include_once "view/menu/menu.php"; ?>

    <div id="newsbox">
                Oops!, Du hast dich noch nicht verifiziert! Schau in dein Email Postfach
                <?php
                    //echo $info;
                ?>     
    </div>
    <div id="container">
        
        <a href="index.php?action=questions">
            <div class="box">
                <div class="imgholder"> 
                    <img src="view/images/forumIntro.png" alt="Forum">
                </div>
                <div class="title">
                    <span style="font-weight: bold;">Forum</span> <br /> Frag die Community!
                </div>
            </div>
        </a>
        <a href="index.php?action=main">
            <div class="box">
                <div class="imgholder"> 
                    <img src="view/images/ideaIntro.png" alt="Intro">
                </div>
                <div class="title">
                    <span style="font-weight: bold;">PIM</span> <br /> Erstelle dein Traumprojekt!
                </div>
            </div>  
        </a>
    </div>
</body>
</html>
