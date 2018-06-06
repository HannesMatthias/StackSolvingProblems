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
            <div id="userdata">
                <form action="index.php?action=saveProfil" method="POST">
                    <div class="outer_left">
                        <div class="inner_left">
                            Vorname:
                            Geburtsdatum:
                            Email:
                        </div>
                        <div class="inner_right">
                            <input type="text" name="name" value="<?php echo $user->getName(); ?>">
                            <input type="text" name="birthdate" value="<?php echo $user->getBirthdate(); ?>">
                            <input type="text" name="email" value="<?php echo $user->getEmail(); ?>">
                        </div>
                    </div>
                    <div class="outer_right">
                        <div class="inner_left">
                            Nachname:
                            Geschlecht:
                        </div>
                        <div class="inner_right">
                            <input type="text" name="surname" value="<?php echo $user->getSurname(); ?>">
                            <input type="range" min="-5" max="5" step="1.0" id="sex_range" name="sex">
                        </div>
                    </div>
                    <input type="submit" name="submit" value="Ändern">
                </form>
            </div>
        </div>
    </body>
</html>