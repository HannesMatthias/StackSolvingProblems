<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="styles/profil.css">
    </head>
    <body>
        <div id="Profil">
            <h1>Profil</h1>
            <div id="left">
                <!-- Profilbild
                Der Pfad des Bildes muss noch Variabel durch das Backend-Team implementiert werden -->
                <img src="view/images/background.png" alt="Ihre Fresse">
                <p>
                    <font class="value"><!--Benutzername--></font>
                </p>
                <hr/>
                <p>
                    <font class="value"><!--Status--></font>
                </p>
                <hr/>
            </div>
            <div id="right">
                <div id="userdata">
                    <p>
                        Vorname: <font class="value"></font>
                    </p>
                    <p>
                        Nachname: <font class="value"></font>
                    </p>
                    <p>
                        Status: <font class="value"></font>
                    </p>
                    <p>
                        Email: <font class="value"></font>
                    </p>
                </div>
                <div if="projects">
                    <!-- PHP Typen sollen do foreachen mit die Projekte fa die User!!!!!!! Not a FrontEnd Problem :P 
                        <div class="project"> Do kemmen nor die Projekte eini dormit mir sie formatieren kennen </div>
                    -->
                </div>
            </div>
        </div>
    </body>
</html>