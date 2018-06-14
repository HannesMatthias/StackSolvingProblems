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
            <img id="profilImage" src="<?php echo $user->getIcon() ?>" alt="username" height="20%" width="20%">
            <div id="username"><?php echo $user->getUsername(); ?></div>
            <div id="info">
            <div id="userdata">
                <div class="outer_left">
                    <div class="inner_left">
                        <div class="tag">Vorname:</div>
                        <div class="tag">Geburtsdatum:</div>
                        <div class="tag">Email:</div>
                    </div>
                    <div class="inner_right">
                        <div id="name"><?php echo $user->getName(); ?></div>
                        <div id="birthdate"><?php echo $user->getBirthdate(); ?></div>
                        <div id="email"><?php echo $user->getEmail(); ?></div>
                    </div>
                    </div>
                    <div class="outer_right">
                        <div class="inner_left">
                            <div class="tag">Nachname:</div>
                            <div class="tag">Geschlecht:</div>
                        </div>
                        <div class="inner_right">
                            <div id="surname"><?php echo $user->getSurname(); ?></div>
                            <div id="sex"><?php echo $user->getSex(); ?></div>
                            <a id="edit" href="index.php?action=editProfil"><img src="view/forum_questions/settings.png" alt="Bearbeiten" width="20" height="20" /></a>
                        </div>
                    </div>
                </div>
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