<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Frage hinzufügen</title>
        <link href="view/forum_addQuestion/addQuestion.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <script>
            var tagCount = 0;
            function handleSelect(){
                
                    var selBox = document.getElementById('selectTag');
                    var userInput = selBox.options[selBox.selectedIndex].text;
                    var text = document.createTextNode(" " + userInput );
                    var divTags = document.getElementById('tags');
                    var tag = document.getElementById('tag');
                    tag.appendChild(text);
                    var hidden = document.getElementById('tagPost');
                    if( tagCount == 0){
                     hidden.value +=userInput;
                    } else {
                        hidden.value +=" " + userInput;
                    }
                    divTags.appendChild(tag);
                    selBox.remove(selBox.selectedIndex);
                    tagCount = tagCount + 1;

                if(tagCount < 3) {
                    var infoDiv = document.getElementById('infoDiv');
                    infoDiv.innerHTML = 'min. 3 Tags benötigt';
                } else {
                    var infoDiv = document.getElementById('infoDiv');
                    infoDiv.innerHTML = '';
                }
            }
        </script>
   </head>
    <body>
        <script type="text/javascript" src="plugins/js/jquery.min.js"> </script>
        <script type="text/javascript" src="plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="plugins/tinymce/init-tinymce.js"></script>
        <script type="text/javascript" src="plugins/tinymce/getdata.js"> </script>

        <div id="tilte">Frage hinzufügen</div>

        <form id="sentMessage" method="post" action="index.php?action=addQuestion">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <p style="color: white;" class="subtitle">Title</p>
            <input required type="text" maxlength="50" id="title" name="title" placeholder="Gib hier deinen Titel ein" value="<?php echo $title; ?>"/>
            <p style="color: white;" class="subtitle">Frag die Community!</p>
            <textarea class="tinymce" name="content"><?php echo $preview; ?></textarea>
            <?php
            if(!$edit) { ?>
                <select name="tag[]" id="selectTag" onChange="return handleSelect()" >
                <option value="default">Select Tag</option>
                <?php foreach ($tags as $t) { ?>
                    <option value="<?php echo $t->getId() ?>"><?php echo $t->getTag() ?></option>
                <?php } ?>
                </select>
                <div id="tags" style="color:white"> 
               <span > TAG : </span> 
               <span id="tag"> </span> 
               <input id="tagPost" type="hidden" name="tagPost" value="" />
            </div>
            <div id="infoDiv" style="color:red"></div>
            <?php } ?>
            
      <div id=buttons>
            <div id="bnt_save">
                <label class="container">Speichern ?
                    <input type="submit" name="save" value="save"><span class="checkmark"></span> 
                </label>
                
            <div>
        </div>
                    
    </form>
        
            
            

    </body>
   
</html>

