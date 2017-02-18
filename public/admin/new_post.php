<?php
require_once ("../../include/intialize.php");
if(!$session->is_logged_in()){
    redirect_to("login.php");
}

$current_subject= subject::find_selected_subject();


if(isset($_POST["submit"])){
    $titleerror= check_content($_POST["title"]);
    $posterror= check_content($_POST["content"]);
     
$photoerrors=$_FILES["upload"]["error"]==0?true:false;
    if(!$posterror&&!$titleerror&&$photoerrors){
        global $database;
       $post=new posts();
        $post->sub_name=$current_subject->subject->menu_name;
        $post->title=$_POST["title"];
         $post->content=$_POST["content"];
        $post->visible=$_POST["visible"];
        $post->create();
        
         $photo=new post_photo();
         $photo->post_id=$post->p_id;
         $photo->attach($_FILES["upload"]);
         if($photo->save())
         {
             $session->message("Story Added Successfully");
             redirect_to("admin_index.php");
         }else{
            $message="file is empty";
         }
       
     }else{
        $message="file is empty";
        redirect_to("new_post.php");
     }
    
    
}else{
  $titleerror=$posterror="";  
  $message="";
}
    
    




include_layout_template("admin_header.php");

 ?>
<h1>Add a post under : <?php echo $current_subject->subject->menu_name;?></h1>
<form action="new_post.php?id=<?php echo $current_subject->id ?>" enctype="multipart/form-data" method="POST">
    Title:<br><textarea name="title" rows="5" cols="80"></textarea> <br><?php echo output_message($titleerror )?>
 
    
    Visible: <input type="radio" name="visible" value="" checked /> No
        &nbsp;
        <input type="radio" name="visible" value="1" /> Yes
     
        <br>
        Content:<br> <textarea name="content" rows="20" cols="80"></textarea> <br> <?php echo output_message($posterror); ?>
        
         <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
                <p><input type="file" name="upload" /></p>
            
                <?php echo output_message($message);?>
      <input type="submit" value="publish" name="submit" />
                 
               
           

</form>
 <a href="admin_index.php"> <input type="submit" value="cancel"/></a>

<?php

include_layout_template("admin_footer.php");
