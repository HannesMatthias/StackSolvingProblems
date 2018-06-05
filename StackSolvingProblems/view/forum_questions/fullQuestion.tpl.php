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
                  <?php } elseif($vote == 1) { ?>
                    <button disabled class="vote big"><?php echo $question->getLikes(); ?><img src="view/forum_questions/like.png"/> </button>
                    <button disabled class="vote" ><?php echo $question->getDislikes(); ?><img src="view/forum_questions/dislike.png"/> </button> 
                  <?php } else { ?>
                    <button disabled class="vote"><?php echo $question->getLikes(); ?><img src="view/forum_questions/like.png"/> </button>
                    <button disabled class="vote big"><?php echo $question->getDislikes(); ?><img src="view/forum_questions/dislike.png"/> </button> 
                <?php }  
                if($questionOwner == true){?>
                    
                        <?php if($solved == true){ ?>
                            <button title="Gelöst" style="margin-left:10px;"class="vote" name="solvedTrue" type="submit"><img src="view/forum_questions/tick.png"/></button>
                            <button title="Noch eine Antwort, bitte!" style="margin-left:10px;"class="vote" name="solvedFalse" type="submit"><img src="view/forum_questions/x.png"/> </button> 
                        <?php } else { ?>
                            <button title="Als gelöst markieren" style="margin-left:10px;"class="vote" name="solvedTrue" type="submit"><img src="view/forum_questions/tick.png"/> </button> 
                            <button title="Als ungelöst markieren" style="margin-left:10px;"class="vote" name="solvedFalse" type="submit"><img src="view/forum_questions/x.png"/> </button>      
                        <?php } ?> 
                    <?php } else { ?>
                        
                        <?php if($solved == true){ ?>
                            <button title="Gelöst" style="margin-left:10px;"class="vote"><img src="view/forum_questions/tick.png"/> </button> 
                        <?php } else { ?>
                            <button title="Noch eine Antwort, bitte!" style="margin-left:10px;"class="vote"><img src="view/forum_questions/x.png"/> </button>
                        <?php } ?> 
                 

        <?php } ?>

                </form>
            <?php if($user != null && $questionOwner) { ?>
            <a id="edit" href="index.php?action=addQuestion&amp;id=<?php echo $question->getId();?>"> <img src="view/forum_questions/settings.png" alt="Bearbeiten" /></a>
            <?php } ?>
                <div id="title"><?php echo $question->getTitle(); ?></div>
                <div id="question"><?php echo $question->getContent(); ?></div>
                
                <?php if($user != null) { ?>
                <button id="btn_answer">Antworten</button>
                <?php } ?>
                <div id="box_tags">
                <?php foreach($tags as $t) { ?>
                        <div class="tags"><?php echo $t->getTag(); ?></div>
                <?php }?>
                </div>
            </div>
            <div id="box_answer">
                <form action="index.php?action=fullQuestion&amp;id=<?php echo $question->getId();?>" method="post">
                    <textarea name="content" id="answer">Ich bin hier um zu helfen :)</textarea>
                    <input type="hidden" name="id" value="<?php echo $question->getId(); ?>"/>
                    <button id="send" name="answer_send" type="submit">Senden</button> 
                </form>
            </div> 
            <div id="box_answers">         	
            <?php foreach($question->findAnswers() AS $answersKey => $answers) { ?>
                <div class="box_fullanswer"> 
                    <div class="box_answers_autor"><?php echo User::find($answers->getUserID())->getUsername(); ?></div>
                    <div class="box_answers_user">
                        <?php echo utf8_encode($answers->getContent()); ?>
                    </div>
                    <?php if($user != null) { ?>
                        <div class="box_comments">
                            <button class="btn_comments">Antworten</button>
                        </div>
                        
                    <?php } ?>
                    <div class="line"> </div>
                </div>
            <?php } ?>
            </div>

    </body>
   
</html>
