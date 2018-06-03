<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Frage hinzufügen</title>
        <link href="view/forum_questions/fullQuestion.css" rel="stylesheet">
        
        <script src="plugins/js/jquery.min.js"></script>
        <script src="plugins/js/clickmenu.js"></script>
        <script src="plugins/js/addAnswer.js"></script>
        <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
    <?php include_once "view/menu/menu.php"; ?>
       
            
            <div id="box_outer">
                <form action="index.php?action=fullQuestion&amp;id=<?php echo $question->getId();?>" method="post">
                  <?php if($vote == 0){ ?>
                    <button class="vote" name="like" type="submit" ><?php echo $question->getLikes(); ?><img src="view/forum_questions/like.png"/> </button>
                    <button class="vote" name="dislike" type="submit"><?php echo $question->getDislikes(); ?><img src="view/forum_questions/dislike.png"/> </button>    
                  <?php } else { ?>
                    <button disabled class="vote"  ><?php echo $question->getLikes(); ?><img src="view/forum_questions/like.png"/> </button>
                    <button disabled class="vote" ><?php echo $question->getDislikes(); ?><img src="view/forum_questions/dislike.png"/> </button> 
                <?php }  
                if($questionOwner == true){?>
                        <text> Frage gelöst? </text>
                        <?php if($solved == true){ ?>
                            <button style="margin-left:10px; border: 1px solid red;"class="vote" name="solvedTrue" type="submit"><img src="view/forum_questions/tick.png"/> </button>
                            <button style="margin-left:10px;"class="vote" name="solvedFalse" type="submit"><img src="view/forum_questions/x.png"/> </button> 
                        <?php } else { ?>
                            <button style="margin-left:10px;"class="vote" name="solvedTrue" type="submit"><img src="view/forum_questions/tick.png"/> </button>
                            <button style="margin-left:10px; border: 1px solid red;"class="vote" name="solvedFalse" type="submit"><img src="view/forum_questions/x.png"/> </button>      
                        <?php } ?> 
                    <?php } else { ?>
                        <text> Frage gelöst? </text>
                        <?php if($solved == true){ ?>
                            <button style="margin-left:10px;"class="vote" disabled><img src="view/forum_questions/tick.png"/> </button> 
                        <?php } else { ?>
                            <button style="margin-left:10px;"class="vote" disabled><img src="view/forum_questions/x.png"/> </button>
                        <?php } ?> 
                  <?php } ?>

                </form>
            <a id="edit" href="index.php?action=addQuestion&amp;id=<?php echo $question->getId();?>"> <img src="view/forum_questions/settings.png" alt="Bearbeiten" /></a>
                <div id="title"><?php echo $question->getTitle(); ?></div>
                <div id="question"><?php echo $question->getContent(); ?></div>
                <button id="btn_answer">Antworten</button>
            </div>
            <div id="box_answer">
                <form action="index.php?action=fullQuestion&amp;id=<?php echo $question->getId();?>" method="post">
                    <textarea name="content" id="answer">Ich bin hier um zu helfen :)</textarea>
                    <input type="hidden" name="id" value="<?php echo $question->getId(); ?>"/>
                    <button id="send" name="answer_send" type="submit">Senden</button> 
                </form>
            </div> 
           
        


        
      

    </body>
   
</html>

