
<?php 

    $title;
    $description;
    $condisions;
    $byset2;
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="viewIdea.css">
</head>
<body>  
    <div id="outerfield">
    <table>
         <tr><div id="overTitle"><Label>Title:</Label></div></tr>
         <tr><div id="title"><label></label></div></tr>
         <tr><div id="overDescription"><Label>Description:</Label></div></tr>
         <tr><div id="description"><label></label></div></tr>
         <tr><div id="overConditions"><Label>Conditions & byset2:</Label></div></tr>
    <tr>
        <div id="conditions">
            <?php for ($i=0; $i<10; $i++){ ?>
                <tr><div id="innterConditions"></div></tr> 
            <?php } ?>
        </div>

        <div id="byset2"><label></label></div>
    </tr>
    <tr>
        <form action="">
                <div id="outerButton"><input id="initButton" type="submit"  value="Join"></div>
        </form>

    </tr>
    </table>
    </div>
</body>
</html>