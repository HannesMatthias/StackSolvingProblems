<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="view/slcPref/slcPref.css">
    <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

</head>
<body>

    <video autoplay muted loop id="myVideo">
        <source src="view/images/backcode.mp4" type="video/mp4">
    </video>


<?php include_once "view/menu/menu.php"; ?>
    <?php if(!empty($info) ) {
            if(!isset($success) && empty($success) ) { ?>
            <div id="newsbox">          
                    <?php echo $info; ?>     
            </div>
      <?php }else { ?>
            <div id="newsbox" style="background-color: rgba(0, 255, 0, 0.7);">          
                <?php echo $info; ?>     
            </div> 
     <?php  }
        } ?>

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
