
<nav id="menu">
    <ul>
        <li><a href="index.php"><img id="logo" src="view/menu/logo.png" /></a></li>
        <li>
            <form>
                <input type="search" id="searchbar" placeholder="Suche nach Fragen" />
                <input type="submit" id="searchButton" value="Suchen" />

            </form>
        </li>
        
        <li><a href="#">Frage stellen</a></li>
        <li><a href="#">Probleme lösen</a> </li>        
     
        <li><a id="einloggen" href="#">Einloggen</a>
            <form id="loginBox" method="post">
                <label>E-Mail</label>
                <input type="text" name="email" value="mh14270@gmail.com"/> 
                <label>Passwort</label>
                <input type="password" name="password" value="" /> 
                <input id="login" type="submit" name="password" value="Einloggen" />
                <a href="index.php?action=register">Jetzt registrieren</a>
            </form>
        </li>
    </ul>
</nav>