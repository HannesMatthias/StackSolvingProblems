<div class="scollView">
<?php if ($user != NULL) { ?>
    <div id="addContentContainer">
        <div id="addContent">
            <a id="addContentButton" href="index.php?action=addIdea"><img src="view/images/addContent.png" width="40" alt="Add" /></a>
        </div>
     </div>
<?php }
foreach($ideas as $i) {
    $user_d = Project::findUser($i->getUser_id()); ?>
    <div class="ideaLabel" align="center">
        
        <div id="container0">
            <div class="profile"><label><img src="<?php echo $user_d->getIcon(); ?>" alt="<?php echo $user_d->getUsername(); ?>_ProfilePic" height="42" width="42"></label></div>
            <div class="title"><label><a href="index.php?action=ideaInterface&amp;id=<?php echo $i->getId(); ?>"><?php echo $i->getTitle(); ?></a></label></div>
            <div class="status"><label><?php echo $i->getStatus(); ?> </label></div>
        </div>
        
        <div id="container1">    
            <div class="username"><label><?php echo $user_d->getUsername(); ?></label></div>
            <div class="description" ><label><?php if (strlen($i->getDescription()) >= 35) { echo substr($i->getDescription(), 0, 35) . "..."; } else { echo $i->getDescription(); } ?></label></div>
            <div class="likesAndDislikes">
                <div id="bts">
                    <div button type="button" class="buttonUp"><img src="view/images/like.png" width="25"></button></div>
                    <div button type="button" class="buttonDown"><img src="view/images/dislike.png" width="25"></button></div>
                </div>
            </div>
        </div>
        
    </div>
    <?php 
        if($user != NULL && $i->getUser_id() == $user->getId()); {
    ?>
    <div id="container2">
            <form action="index.php?action=main" method="POST" >
                <input type="hidden" name="deleteId" value="<?php echo $i->getId();?>" />
                <input type="image" class="alterButton" src="view/images/cancel.png" alt="löschen" width="20" />
            </form>
            <a class="alterButton" href="index.php?action=addIdea&amp;id=<?php echo $i->getId();?>"><img src="view/forum_questions/settings.png" alt="Bearbeiten" width="20"/></a>
           
    </div>
    <?php 
        }
    } ?>
</div>