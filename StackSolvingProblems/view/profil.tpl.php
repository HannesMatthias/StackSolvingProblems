<?php 
    $session = Session::getInstance();
    $user;
    if($session->getSession("user") != null ) {
        $user = $session->getSession("user");
    }
?>
<?php echo $user->getUsername(); ?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="view/styles/profil.css">
        
    </head>
    <body>
        <div id="profil_image">
            <img src="view/images/lauch.jpg" alt="Smiley face" height="25%" width="20%">
        </div>
        <div id="profil">
            <div id="username"><?php echo $user->getUsername(); ?></div>
            <div id="userdata">
                <div id="firstname"><?php echo $user->get; ?></div>
                <div id="surname"><?php echo $user->getUsername(); ?></div>
                <div id="email"><?php echo $user->getUsername(); ?></div>
            </div>
            <div id="userquestions">
                <div class="question">
                    
                </div>
            </div>            
        </div>
    </body>
</html>