<!DOCTYPE html>
<html>
    <head>
        <title>ProjectManagement</title>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="view/register/register.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
        <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1.0">
    </head>


    <body>

    <div class="top"></div>

        <div id="frame">

            <div id="titleform">Community-Projekte &amp; Forum </div>

            <form class="frameform" method="post" action="index.php?action=register"> 
            <?php if(count($errors)) {?>
                    <div id="errorBox">
                        <?php
                        foreach ($errors as $error) {
                            echo $error . "<br />";
                        }
                        ?> 
                    </div>
                <?php }?>     

                <label>Vorname</label> 
                <input type="text" name="name" value="<?php echo $user->getName(); ?>"> 
                <br />
                <br /> 
                <br />
                <label>Nachname</label> 
<<<<<<< HEAD
                <input type="text" name="surname" value="<?php echo $user->getSurname(); ?>"> 
=======
                <input type="text" name="surname" value="<?php echo $user->getSurname() ?>"> 
>>>>>>> 7f72337b7e8f9bf5c09c537c272d350c97bda865
                <br />
                <br /> 
                <br />
                <label>E-Mail</label> 
                <input type="email" name="email" value="<?php echo $user->getEmail(); ?>"> 
                <br />
                <br /> 
                <br />
                <label>Benutzername</label> 
                <input type="text" name="username" value="<?php echo $user->getUsername(); ?>"> 
                <br />
                <br /> 
                <br />
                <label>Passwort</label>
                <input type="password" name="password">
                <br />
                <br /> 
                <br />
                <label>Passwort wiederholen</label>
                <input type="password" name="re_password"> <br> <br>
                <br />
                <input type="submit" name="send" value="Abschicken">
            </form>
            <br />
            <br />
            <br />
            <a href="index.php">Zurück zur Startseite</a>
        </div>


    </body>
</html>