<?php 
    $session = Session::getInstance();
    $user;
    if($session->getSession("user") != null ) {
        $user = $session->getSession("user");
    }
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="view/styles/profil.css">
        
    </head>
    <body>
        
        <img id="profileImage" src="view/images/lauch.jpg" alt="Smiley face" height="25%" width="20%">
     
        <div id="profil">
            <div id="username">Pluto</div>
            <div id="userdata">
                <div id="firstname">Simon</div>
                <div id="surname">Premstaller</div>
                <div id="email">test@test.gmail.com</div>
            </div>
            <div id="userquestions">
                <div class="question">
                    
                </div>
            </div>            
        </div>
    </body>
</html>