<div class="scollView">
<?php foreach($ideas as $i) {
    $user = Project::findUser($i->getUser_id()); ?>
    <div class="ideaLabel" align="center">
        <table>
        <tr>
            <tr>
            <?php echo $user->getIcon(); ?> 
            <td class="profile"><label><img src="<?php echo $user->getIcon(); ?>" alt="<?php echo $user->getUsername(); ?>_ProfilePic" height="42" width="42"></label></td>
            <td class="title"><label><?php echo $i->getTitle(); ?></label></td> 
            <td class="status"><label><?php echo $i->getStatus(); ?></label></td>
        </tr>
            <tr>     
            <td class="username"><label><?php echo $user->getUsername(); ?></label></td>     
            <td class="description" ><label><?php echo $i->getDescription(); ?></label></td>
            
            
            <td class="likesAndDislikes">
                <table>
                    <td><button type="button" class="buttonUp"><img src="view/images/like.png" width="25"></button></td>
                    <td><button type="button" class="buttonDown"><img src="view/images/dislike.png" width="25"></button></td>
                </table>
            </td>
            
        </tr></tr>
        </table>
    </div> 
    <?php } ?>
</div>   