<div class="scollView">
<?php foreach($ideas as $i) { ?>
    <div class="ideaLabel" align="center">
        <table>
        <tr>
            <tr>
            <th class="profile"><label>profile</label></th>
            <th class="title"><label><?php echo $i->getTitle(); ?></label></th> 
            <th class="status"><label><?php echo  $i->getStatus(); ?></label></th>
        </tr>
            <tr>     
            <th class="username"><label><?php echo $i->findUsername(); ?></label></th>     
            <th class="description" ><label><?php echo  $i->getDescription(); ?></label></th>
            
            
            <th class="likesAndDislikes">
                <table>
                    <th><button type="button" class="buttonUp"><img src="view/images/like.png" width="25"></button></th>
                    <th><button type="button" class="buttonDown"><img src="view/images/dislike.png" width="25"></button></th>
                </table>
            </th>
            
        </tr></tr>
        </table>
    </div> 
    <?php } ?>
</div>   