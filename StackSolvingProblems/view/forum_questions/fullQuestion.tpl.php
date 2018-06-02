<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Frage hinzufügen</title>
        <link href="view/forum_questions/fullQuestion.css" rel="stylesheet">
        <script src="plugins/js/jquery.min.js"></script>
         <script src="plugins/js/clickmenu.js"></script>
        <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
    <?php include_once "view/menu/menu.php"; ?>
       
            
            <div id="box_outer">
            <a id="edit" href="index.php?action=addQuestion"><img src="view/forum_questions/settings.png" alt="Bearbeiten" /></a>
                <div id="title"><?php echo $question->getTitle(); ?></div>
                <div id="question"><?php echo $question->getContent(); ?></div>
                <div id="answer">Antworten</div>
            </div>
           
        


        
      

    </body>
   
</html>

