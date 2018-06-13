<header>



<img id="mobile_logo" src="view/images/logo.png" alt="Logo" /> 
<nav id="menu">
    
    <ul>
        <li><a id="alogo" href="index.php"><img id="logo" src="view/menu/logo.png" /></a></li>
        <li>
            <a href="index.php">Startseite</a>
        </li>
        <li>
            <form id="searchOptions" action="index.php?action=search" method = "POST">
                <input type="search" name="search" list="searchQuestions" id="searchbar" placeholder="Suche nach Fragen" />
               <!-- <input type="submit"  id="searchButton" value="Suchen" />   -->
               <button id="searchButton" type="submit">
                    <img src="view/forum_intro/search.png" alt="Suche"/>
                </button>
            </form>
        </li>    
        
        <li>
            <a href="index.php?action=addQuestion">Frage stellen</a>
        </li>
        <li style="line-height:1.4em;">
            <a href="index.php?action=questions">Frage beantworten</a>
        </li>

        <li>
        <?php 
            $session = Session::getInstance();
            if($session->getSession("user") == null ) { ?>
                <a id="einloggen" href="#">Einloggen</a>
                
                <form id="loginBox" action="index.php?action=login" method="post">
                <label>E-Mail oder Benutzername</label>
                <input type="text" name="name" placeholder="Benutzername"/> 
                <label>Passwort</label>
                <input type="password" name="password_hash" /> 
                <input id="login" type="submit" name="login" value="Einloggen" />
                <a href="index.php?action=register">Jetzt registrieren</a>
            </form>
        <?php   
            }else { 
                $user = $session->getSession("user"); ?>
                <a id="profile" href="#">
                    <img src="view/menu/tmpUser.png" alt="ProfilePhoto"/>
                <?php echo $user->getUsername(); ?> </a>
                <div id="usermenu">
                    <a href="index.php?action=profil">
                        <div class="profileIcon"><img src="view/menu/profile.png"/></div>
                        <div class="profileText">Profil</div>
                    </a>
                    <a href="#">
                        <div class="profileIcon"><img src="view/menu/message.png"/></div>
                        <div class="profileText">Beiträge</div>
                    </a>
                    <a href="index.php?action=logout">
                        <div class="profileIcon"><img src="view/menu/logout.png"/></div>
                        <div class="profileText">Logout</div>
                    </a>
                   

                </div>
                

    <?php   } ?>
       
           
        </li>
    </ul>
</nav>
<?php require_once 'model/entities/question.php'; ?>

    <datalist id="searchQuestions">
        <?php $questions = Question::findAll();
            foreach($questions AS $key => $q) { ?>
                <option value="<?php echo $q->getTitle(); ?>">
           <?php } ?>  
    </datalist>
</header>


