<html>
<head>
    <link rel="stylesheet" type="text/css" href="view/addIdea/addIdea.css">
</head>
<body>
    <div id="outerfield">
    <form id="sendIdea" method="post" action="index.php?action=addIdea">
    <table>
         <tr><div id="overTitle"><Label>Title:</Label></div></tr>
         <tr><div id="title"><input id="title" name="title" type="text" value="<?php echo $idea->getTitle(); ?>"></div></tr>
         <tr><div id="overDescription"><Label>Description:</Label></div></tr>
         <tr><div id="description"><input id="description" name="description" type="text" value="<?php echo $idea->getDescription(); ?>"></div></tr>
       <!--  <tr><div id="overConditions"><Label>Conditions & byset2:</Label></div></tr>
    <tr>
        <div id="conditions">
            <div id="innterConditions"> <input id="innterConditionsText" type="text"> </div>
        </div>

        <div id="byset2"><input id="byset2Text" type="text"></div>
    </tr>-->
    <tr>
    <div id="outerButton"><input id="initButton" type="submit"  value="Commit"></div>

    </tr>
    </table>
    </form>
    </div>
</body>
</html>