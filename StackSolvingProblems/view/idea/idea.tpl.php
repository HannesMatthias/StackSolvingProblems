<?php 
    $username;
    $status;
    $likes;
    $dislikes;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="view/idea/idea.css">
    <link rel="stylesheet" type="text/css" href="view/menu/menu.css">
    <script src="plugins/js/jquery.min.js"> </script>
    <link rel="stylesheet" type="text/css" href="view/infoboxes/infoboxes.css">
</head>
<body>
<div class="menu">
    <?php include_once "view/menu/menu.php"; ?>
</div>
<div class="infoboxes">
    <?php include_once "view/infoboxes/infoboxes.php"; ?>
</div>
<div class="scollView">
<?php for ($i = 1; $i <= 10; $i++){ ?>
    <div class="ideaLabel">
        <table>
        <tr>
            <th class="username"><label>username</label></th>  
            <th class="profile"><label>profile</label></th>          
            <th class="status"><label>status</label></th>
            <th class="likesAndDislikes">
                <table>
                    <tr><th><button type="button" class="buttonUp"><img src="view/images/up.png" width="15"></button></th></tr>
                    <tr><th><button type="button" class="buttonDown"><img src="view/images/down.png" width="15"></button></th></tr>
                </table>
            </th>
            <th class="likesAndDislikesText" align="center"><label>like</label></th>
        </tr>
        </table>
    </div> 
    <?php } ?>
</div>   

</body>
</html>
