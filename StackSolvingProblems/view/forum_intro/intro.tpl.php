<!DOCTYPE html>


<html>

    <head>
        <title>Frage die Community</title>
        <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
        <link rel="stylesheet" type="text/css" href="view/forum_intro/intro.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    </head>
    <body>
    <?php include_once "view/menu/menu.php"; ?><?php include_once "view/menu/menu.php"; ?>
        <div id="box">
            <h1 id="title">Frag die Community!</h1>
            <form method="post">
                <input id="question" type="search" placeholder="Gib deine Frage ein" />
                <button type="submit">
                    <img src="view/forum_intro/search.png" alt="Suche"/>
                </button>
            </form>
        </div>
    </body>
</html>