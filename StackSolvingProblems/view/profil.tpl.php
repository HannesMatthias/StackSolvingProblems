<?php 
    $session = Session::getInstance();
    $user;
    if($session->getSession("user") != null ) {
        $user = $session->getSession("user");
    }
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="view/styles/profil.css">
        <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
        <link href="view/forum_questions/questions.css" rel="stylesheet">
    </head>
    <body>
        <?php include_once "view/menu/menu.php"; ?>
        <img id="profilImage" src="view/images/lauch.jpg" alt="username" height="25%" width="25%">
        <div id="profil">
            <div id="username">Username: <?php echo utf8_encode($user->getUsername()); ?></div>
            <div id="userdata">
                Vorname: <div id="firstname"><?php echo utf8_encode($user->getName()); ?></div>
                Nachname: <div id="surname"><?php echo utf8_encode($user->getSurname()); ?></div>                
                Email: <div id="email"><?php echo $user->getEmail(); ?></div>
            </div>
            <div id="userquestions">
                <?php foreach($user->findQuestions() AS $key => $question) {
                $tags = $question->findTags(); 
                
                ?>
                <div class="box">
                    <div class="outer">
                        <div class="box_title"><?php echo $question->getTitle(); ?></div>
                        <div class="box_solved"><span style="font-weight: bold;">Status:</span> <br />
                        <?php echo $question->getSolved(); ?></div>
                        <div class="box_answers"><span style="font-weight: bold;">Antworten:</span> <br /><?php echo $question->findAnswerCount()['count']; ?></div>
                    </div>  
                    <div class="box_kategorie">
                        <?php foreach($tags as $t) { ?>
                        <div class="tags"><?php echo $t->getTag(); ?></div>
                        <?php }?>
                    </div>
                    <a class="edit" href="index.php?action=addQuestion"><img src="view/forum_questions/settings.png" alt="Bearbeiten" /></a>
                </div>
                <?php }?>
            </div>            
        </div>
    </body>
</html>