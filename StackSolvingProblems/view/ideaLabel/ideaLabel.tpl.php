<div class="scollView">
<?php for ($i = 1; $i <= 10; $i++){ ?>
    <div class="ideaLabel" align="center">
        <table>
        <tr>
            <tr>
            <th class="profile"><label>profile</label></th>
            <th class="username"><label>username</label></th> 
            <th class="status"><label>status</label></th>
        </tr>
            <tr>     
            <th class="likesAndDislikesText"><label>like</label></th>     
            <th class="description" ><label>description</label></th>
            
            
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