<?php 
    if (empty($_POST[$questions])) {
        //<link href="index.html" rel="stylesheet">
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
        <div id="profil">
            <img id="profilImage" src="view/images/lauch.jpg" alt="username" height="15%" width="15%">
            <div id="username"><?php echo $user->getUsername(); ?></div>
            <div id="info">
            <div id="userdata">
                <table>
                <tr>
                    <td> <div id="firstname">Vorname:<?php echo $user->getName(); ?></div></td>
                    <td> <div id="surname">Nachname:<?php echo $user->getSurname(); ?></div></td>
                </tr>
                <tr>
                <div id="userdata2">
                    <td id="email">Email:<?php echo $user->getEmail(); ?></td>
                    <td id="points">Punkte:<?php echo $user->getPoints(); ?></td>
</div>
                </tr>
                </table>
                <!--Vorname: <div id="firstname"><?php /*echo $user->getName(); ?></div>
                Nachname: <div id="surname"><?php echo $user->getSurname(); ?></div>                
                Email: <div id="email"><?php echo $user->getEmail(); ?></div>
                Points: <div id="points"><?php echo $user->getPoints(); */ ?></div>-->
            </div>
            <a id="edit" href="index.php?action=editProfil"><img src="view/forum_questions/settings.png" alt="Bearbeiten" width="20" height="20" /></a>
            </div>
            <div id="userquestions">
                <h2>Ihre Fragen</h2>
                <?php 
                    if (empty($questions)) {
                ?>
                        <div id="noquestions">Es konnten keine Fragen geladen werden!</div>
                <?php
                    } 
                    else {
                        foreach($user->findQuestions() AS $key => $question) {
                            $tags = $question->findTags();
                ?>
                            <div class="box">
                                <div class="outer">
                                    <div class="box_title">
                                    <a class="redirect" href="index.php?action=fullQuestion&amp;id=<?php echo $question->getId();?>"><?php echo $question->getTitle(); ?></a></div>
                                    <div class="box_solved"><span style="font-weight: bold;">Status:</span> <br />
                                    <?php echo $question->getSolved();
                ?>
                                </div>
                                    <div class="box_answers"><span style="font-weight: bold;">Antworten:</span> <br />
                                        <?php echo $question->findAnswerCount()['count']; ?> 
                                    </div>
                                </div>  
                                <div class="box_kategorie">
                <?php               
                                    foreach($tags as $t) { 
                ?>
                                        <div class="tags"><?php echo $t->getTag(); ?></div>
                <?php               
                                    }
                ?>
                                </div>
                                <a class="edit" href="index.php?action=addQuestion"><img src="view/forum_questions/settings.png" alt="Bearbeiten" /></a>
                            </div>
                <?php 
                        }
                    }
                ?>
                
            </div>            
        </div>
    </body>
</html>