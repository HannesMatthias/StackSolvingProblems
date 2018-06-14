<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="view/ideaInterface/ideaInterface.css">
</head>
<body>
    <div class="ideaLabel" align="center">
            
            <div id="container0">
                <div class="profile"><label><img src="<?php echo $user_p->getIcon(); ?>" alt="<?php echo $user_p->getUsername(); ?>_ProfilePic" height="42" width="42"></label></div>
                <div class="title"><label><?php echo $idea->getTitle(); ?></label></div>
                <div class="status"><label><?php echo $idea->getStatus(); ?> test</label></div>
            </div>
            
            <div id="container1">    
                <div class="username"><label><?php echo $user_p->getUsername(); ?></label></div>
                <div class="likesAndDislikes">
                    <div id="bts">
                        <div button type="button" class="buttonUp"><img src="view/images/like.png" width="25"></button></div>
                        <div button type="button" class="buttonDown"><img src="view/images/dislike.png" width="25"></button></div>
                    </div>
                </div>
            </div>
            <?php if($rights == true) { ?>
            <div id="container2">
                <a class="edit" href="index.php?action=addIdea&amp;id=<?php echo $idea->getId();?>"><img src="view/forum_questions/settings.png" alt="Bearbeiten" /></a>
            </div>
            <?php } ?>
    </div> 
    
        <!-- beschreibung -->
        <div id="overDescription"><Label>Description:</Label></div>
        <div id="description"><label id="description" for=""><?php echo $idea->getDescription(); ?></label></div>

    <div id="container">
        <div id="overUsers"><label>Users:</label></div>
        <div id="overConditions"><label>Consisions:</label></div>
        <div id="users"><label id="description" for=""></label></div>
        <div id="condisions"><label id="description" for=""><?php echo $user_p->getUsername(); ?></label></div>
    </div>

    
     <div id="writeComment">
     <div id="overWriteComment"><Label>Write a comment:</Label></div>
             <form action="">
                    <input type="text" name="" id="wtext"> </br>
                    <input type="submit" name="submit" id="sub" value="Send">
                </form>
      </div>

    <!-- Foreach schleife -->
    <div id="showComment">
            <label id="comment" for=""></label>
    </div>
</body>
</html>