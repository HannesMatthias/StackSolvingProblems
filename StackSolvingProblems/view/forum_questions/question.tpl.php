<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Fragen anzeigen</title>
        <link href="view/forum_questions/questions.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
    <?php include_once "view/menu/menu.php"; ?>
        <div id="box_extern">
            <?php foreach($questions1 AS $key => $question) {
                $tags = $question->findTags(); 
                ?>
            
                <div class="box">
                    <div class="outer">
                    <a class="redirect" href="index.php?action=fullQuestion&amp;id=<?php echo $question->getId();?>"> 
                    <div class="box_title"><?php echo $question->getTitle(); ?></div> </a>
                        <div class="box_solved"><span style="font-weight: bold;">Status:</span> <br />
                        <?php if($question->getSolved() ) { ?>
                            <img class="solvestate" src="view/forum_questions/like.png"/>
                        <?php }else { ?>
                            <img class="solvestate" src="view/forum_questions/x.png"/>
                      <?php  } ?></div>
                        <div class="box_answers"><span style="font-weight: bold;">Antworten:</span> <br /><?php echo $question->findAnswerCount()['count']; ?></div>
                    </div>  
                    <div class="box_kategorie">
                        <?php foreach($tags as $t) { ?>
                        <div class="tags"><?php echo $t->getTag(); ?></div>
                        <?php }?>
                    </div>
                    <?php if($question->getUserId() == $user->getId()) { ?>
                    <a class="edit" href="index.php?action=addQuestion&amp;id=<?php echo $question->getId();?>"><img src="view/forum_questions/settings.png" alt="Bearbeiten" /></a>
                    <?php } ?>
                </div>
            
           
            <?php }?>
        </div>

      

    </body>
   
</html>

