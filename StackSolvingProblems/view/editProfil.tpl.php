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
            <img id="profilImage" src="<?php echo $user->getIcon() ?>" alt="username" height="15%" width="15%">
            <div id="username"><?php echo $user->getUsername(); ?></div>
            <div id="userdata">
                <form action="index.php?action=saveProfil" method="POST" enctype="multipart/form-data">
                    <div class="outer_left">
                        <div class="inner_left">
                            Vorname:
                            Geburtsdatum:
                            Email:
                            Profilbild:
                        </div>
                        <div class="inner_right">
                            <input type="text" name="name" value="<?php echo $user->getName(); ?>">
                            <input type="date" name="birthdate" max="<?php echo date("Y-m-d") ?>" value="<?php echo $user->getBirthdate(); ?>">
                            <input type="email" name="email" value="<?php echo $user->getEmail(); ?>">
                            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
                        </div>
                    </div>
                    <div class="outer_right">
                        <div class="inner_left">
                            Nachname:
                            Geschlecht:
                        </div>
                        <div class="inner_right">
                            <input type="text" name="surname" value="<?php echo $user->getSurname(); ?>">
                            <input type="radio" name="sex" value="m" <?php if ($user->getSex() == "m") echo "checked";?>> Männlich
                            <input type="radio" name="sex" value="w" <?php if ($user->getSex() == "w") echo "checked";?>> Weiblich
                        </div>
                    </div>
                    <input type="submit" name="submit" value="Ändern">
                </form>
            </div>
        </div>
    </body>
</html>