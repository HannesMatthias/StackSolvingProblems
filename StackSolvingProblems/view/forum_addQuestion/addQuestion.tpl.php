<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Frage hinzufügen</title>
        <link href="view/forum_addQuestion/addQuestion.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <script>
            function handleSelect(myForm){
                
                var selBox = document.getElementById('selectTag');
                var userInput = selBox.options[selBox.selectedIndex].text;
                var text = document.createTextNode(" " + userInput );
                var divTags = document.getElementById('tags');
                var tag = document.getElementById('tag');
                tag.appendChild(text);

                divTags.appendChild(tag);
                selBox.remove(selBox.selectedIndex);
            }
        </script>
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
                    echo "Frage ID: " . $id;
                }
                ?>
            </div>

            <p  class="subtitle">Vorschau - Titel </p>
            <div class="text_center"><?php echo $title; ?></div>

            <p class="subtitle">Vorschau - Frage</p><br />
            <div id="question"><?php echo $preview; ?></div>


        </div>

        <form id="sentMessage" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input required type="text" maxlength="50" id="title" name="title" placeholder="Gib hier deinen Titel ein" value="<?php echo $title; ?>"/>
            <p style="color: white;" class="subtitle">Frag die Community!</p>
            <textarea class="tinymce" name="content"><?php echo $preview; ?></textarea>
            <?php
            if(!$edit) { ?>
                <select name="tag[]" id="selectTag" onChange=" return handleSelect()" >
                <option value="default">Select Tag</option>
                <?php foreach ($tags as $t) { ?>
                    <option value="<?php echo $t->getId() ?>"><?php echo $t->getTag() ?></option>
                <?php } ?>
                </select>
            <?php } ?>
            <div id="tags" style="color:white"> 
               <span > TAG : </span> 
               <span id="tag">  </span> 
            </div>
      <div id=buttons>
            <div id="bnt_vorschau">
                <input type="submit" value="Vorschau anzeigen" />
            </div>
            <div id="bnt_save">
                <label class="container">Speichern ?
                    <input type="checkbox" name="save" value="save"><span class="checkmark"></span> 
                </lable>
                
            <div>
        </div>
                    
        </form>
        
            
            

    </body>
   
</html>

