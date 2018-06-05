<?php 
    if (empty($_POST[$questions])) {
        //return
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
        <img id="profilImage" src="view/images/lauch.jpg" alt="username" height="15%" width="15%">
        <div id="profil">
            <div id="username"><?php echo $user->getUsername(); ?></div>
            Vorname: <div id="firstname"><?php echo $user->getName(); ?></div>
            Nachname: <div id="surname"><?php echo $user->getSurname(); ?></div>                
            Email: <div id="email"><?php echo $user->getEmail(); ?></div>
            Geschlecht: <div id="sex"><?php echo $user->getSex(); ?></div>
            Points: <div id="points"><?php echo $user->getPoints(); ?></div>//Currently not implemented
            <div id="userquestions">
                <?php foreach($user->findQuestions() AS $key => $question) {
                $tags = $question->findTags();
                ?>
                <div class="box">
                    <div class="outer">
                        <div class="box_title">
                        <a class="redirect" href="index.php?action=fullQuestion&amp;id=<?php echo $question->getId();?>"><?php echo $question->getTitle(); ?></a></div>
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