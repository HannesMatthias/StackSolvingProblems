<!DOCTYPE html>
<html>
    <head>
        <title>ProjectManagement</title>

        <link rel="stylesheet" href="view/login/login.css" />

        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>


    <body>

    <div class="top"></div>

        <div id="frame">

            <div id="titleform">Community-Projekte &amp; Forum </div>

            <form class="frameform" method="post"> 
            <?php if(count($errors)) {?>
                    <div id="errorBox">
                        <?php
                        foreach ($errors as $error) {
                            echo $error . "<br />";
                        }
                        ?> 
                    </div>
                <?php }?>     

                <label>E-Mail</label> 
                <input type="text" name="email" value="<?php echo $user->getEmail(); ?>"> 
                <br />
                <br /> 
                <br /> 
                <label>Passwort</label>
                <input type="password" name="password"> <br> <br>
                <br /> 
                <input type="submit" name="send" value="Abschicken">
            </form>
            <br />
            <br />
            <br />
            <a href="../index.php">Zurück zur Startseite</a>
        </div>


    </body>
</html>