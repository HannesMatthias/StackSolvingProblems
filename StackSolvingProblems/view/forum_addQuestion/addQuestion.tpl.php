<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Frage hinzufügen</title>
        <link href="view/forum_addQuestion/addQuestion.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
        <script type="text/javascript" src="plugins/js/jquery.min.js"> </script>
        <script type="text/javascript" src="plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="plugins/tinymce/init-tinymce.js"></script>
        <script type="text/javascript" src="plugins/tinymce/getdata.js"> </script>

        <div id="tilte">Frage hinzufügen</div>
        <div id="box">
           
            <div id="box_info">
                <?php 
                if($id==0) {
                    echo "Neue Frage";
                }else {
                    echo "Box ID: " . $id;
                }
                ?>
            </div>

            <p class="subtitle">Vorschau - Titel </p>
            <div class="text_center"><?php echo $title; ?></div>

            <p class="subtitle">Vorschau - Frage</p><br />
            <div id="question"><?php echo $preview; ?></div>


        </div>

        <form id="sentMessage" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="text" maxlength="50" id="title" name="title" placeholder="Gib hier deinen Titel ein" value="<?php echo $title; ?>"/>
            <p class="subtitle">Deine Frage</p>
            <textarea class="tinymce" name="question"><?php echo $preview; ?></textarea>
            <?php
            for($i = 0; $i < 3; $i++) { ?>
            <select name="tag[]">
                <?php foreach ($tags as $t) { ?>
                <option value="<?php echo $t->getId() ?>"><?php echo $t->getTag() ?></option>
                <?php } ?>
            </select>
            <?php } ?>
            <p>Senden? <input type="checkbox" name="save" value="save"></p>
            <input type="submit" value="Vorschau anzeigen" />
        </form>

    </body>
   
</html>

