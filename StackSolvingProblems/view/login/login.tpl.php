<!DOCTYPE html>
<html>
    <head>
        <title>ProjectManagement</title>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="view/login/login.css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
        <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1.0">
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
                <input type="email" name="email" value="<?php echo $user->getEmail(); ?>"> 
                <br />
                <br /> 
                <br /> 
                <label>Passwort</label>
                <input type="password" name="password_hash"> <br> <br>
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