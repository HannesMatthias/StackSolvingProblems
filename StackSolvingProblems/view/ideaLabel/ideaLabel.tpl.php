<div class="scollView">
<?php if ($user != NULL) { ?>
    <div id="addContentContainer">
        <div id="addContent">
            <button id="addContentButton">
            <img src="view/images/addContent.png" width="40">
            </button>
        </div>
     </div>
<?php }
foreach($ideas as $i) {
    $user_d = Project::findUser($i->getUser_id()); ?>
    <div class="ideaLabel" align="center">
        
        <div id="container0">
            <div class="profile"><label><img src="<?php echo $user_d->getIcon(); ?>" alt="<?php echo $user_d->getUsername(); ?>_ProfilePic" height="42" width="42"></label></div>
            <div class="title"><label><a href="index.php?action=ideaInterface&amp;id=<?php echo $i->getId(); ?>"><?php echo $i->getTitle(); ?></a></label></div>
            <div class="status"><label><?php echo $i->getStatus(); ?> test</label></div>
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
        
<<<<<<< HEAD
    </div> 
    <!-- Nur der Besitzer darf einsehen -->
=======
    </div>
    <?php 
        if($user != NULL && $i->getUser_id() == $user->getId()) {
    ?>
>>>>>>> b93b81ac325e1254af7ca6338a35bc012d4cff6e
    <div id="container2">
            <button id="cancelButton"><img src="view/images/cancel.png" width="20"></button>
            <button id="cancelButton"><img src="view/images/settings.png" width="20"></button>
    </div>
    <?php 
        }
    } ?>
</div>   