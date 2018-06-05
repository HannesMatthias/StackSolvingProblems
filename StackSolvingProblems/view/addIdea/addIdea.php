
<?php 

    $title;
    $description;
    $condisions;
    $byset2;
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="addIdea.css">
</head>
<body>
    <div id="outerfield">
    <form action="">
    <table>
         <tr><div id="overTitle"><Label>Title:</Label></div></tr>
         <tr><div id="title"><input id="title" type="text"></div></tr>
         <tr><div id="overDescription"><Label>Description:</Label></div></tr>
         <tr><div id="description"><input id="description" type="text"></div></tr>
         <tr><div id="overConditions"><Label>Conditions & byset2:</Label></div></tr>
    <tr>
        <div id="conditions">
            <div id="innterConditions"> <input id="innterConditionsText" type="text"> </div>
        </div>

        <div id="byset2"><input id="byset2Text" type="text"></div>
    </tr>
    <tr>
        <form action="">
                <div id="outerButton"><input id="initButton" type="submit"  value="Commit"></div>
        </form>

    </tr>
    </table>
    </form>
    </div>
</body>
</html>