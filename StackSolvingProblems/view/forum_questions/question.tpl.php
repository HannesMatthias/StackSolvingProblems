<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Frage hinzufügen</title>
        <link href="view/forum_questions/questions.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
    <?php include_once "view/menu/menu.php"; ?>
        <div id="box_extern">
            <?php foreach($questions AS $key => $question) {
                $tags = $question->findTags(); ?>
            <div class="box">
                <div class="outer">
                    <div class="box_title"><?php echo $question->getTitle(); ?></div>
                    <div class="box_solved">No</div>
                    <div class="box_answers">Answers <br /><?php echo $question>-> ?></div>
                </div>  
                <div class="box_kategorie">
                    <?php for($i = 0; $i < 3; $i++) { ?>
                    <div class="tags"><?php echo $tags[$i]->getTag(); ?></div>
                    <?php }?>
                </div>
                
            </div>
            <?php }?>
        </div>


        
      

    </body>
   
</html>

