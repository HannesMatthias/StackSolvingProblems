<div class="scollView">
<?php foreach($ideas as $i) {
    $user = Project::findUser($i->getUser_id()); ?>
    <div class="ideaLabel" align="center">
        
        <div id="container0">
            <div class="profile"><label><img src="<?php echo $user->getIcon(); ?>" alt="<?php echo $user->getUsername(); ?>_ProfilePic" height="42" width="42"></label></div>
            <div class="title"><label><?php echo $i->getTitle(); ?></label></div>
            <div class="status"><label><?php echo $i->getStatus(); ?> test</label></div>
        </div>
        
        <div id="container1">    
            <div class="username"><label><?php echo $user->getUsername(); ?></label></div>
            <div class="description" ><label><?php if (strlen($i->getDescription()) >= 35) { echo substr($i->getDescription(), 0, 35) . "..."; } ?></label></div>
            <div class="likesAndDislikes">
                <div id="bts">
                    <div button type="button" class="buttonUp"><img src="view/images/like.png" width="25"></button></div>
                    <div button type="button" class="buttonDown"><img src="view/images/dislike.png" width="25"></button></div>
                </div>
            </div>
        </div>
    </div> 
    <?php } ?>
</div>   