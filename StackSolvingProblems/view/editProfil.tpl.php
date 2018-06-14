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
            <div id="userdata">
                <form action="index.php?action=saveProfil" method="POST" enctype="multipart/form-data">
                    <div id="form">
                        <div class="outer_left">
                            <div class="inner_left">
                                <div class="tag">Vorname:</div>
                                <div class="tag">Geburtsdatum:</div>
                                <div class="tag">Email:</div>
                            </div>
                            <div class="inner_right">
                                <div class="tag"><input type="text" name="name" value="<?php echo $user->getName(); ?>"></div>
                                <div class="tag"><input type="date" name="birthdate" max="<?php echo date("Y-m-d") ?>" value="<?php echo $user->getBirthdate(); ?>"></div>
                                <div class="tag"><input type="email" name="email" value="<?php echo $user->getEmail(); ?>"></div>
                            </div>
                        </div>
                        <div class="outer_right">
                            <div class="inner_left">
                                <div class="tag">Nachname:</div>
                                <div class="tag">Geschlecht:</div>
                                <div class="tag">Profilbild:</div>
                            </div>
                            <div class="inner_right">
                                <div class="tag"><input type="text" name="surname" value="<?php echo $user->getSurname(); ?>"></tag>
                                <div class="tag"><input type="radio" name="sex" value="m" <?php if ($user->getSex() == "m") echo "checked";?>> Männlich
                                <input type="radio" name="sex" value="w" <?php if ($user->getSex() == "w") echo "checked";?>> Weiblich</div>
                                <div class="tag"><input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"></div>
                            </div>
                        </div>
                    </div>
                    <input id="submit" type="submit" name="submit" value="Ändern">
                </form>
            </div>
        </div>
    </body>
</html>