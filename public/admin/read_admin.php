<?php
require_once ("../../include/intialize.php");
$page= posts::find_selected_page();
$photos= post_photo::find_all("photo_id");
if(!$_GET["id"]){
    redirect_to("admin_index.php");
}

include_layout_template("admin_header.php");

?>   <div class ="posttitle"> <?php echo nl2br($page->post->title)?></div>
    <div class ="readyimage">
    <img src=" <?php 
         foreach ($photos as $photo){
             if($photo->post_id==$page->id){
               echo "../".$photo->image_path();
             }
         }
    ?> ">
    </div>
      
    <div class="content"><?php echo nl2br($page->post->content); ?></div>
    
    <div class="view_comment">
        <?php $comments= comment::find_comments_on($page->id);
 foreach ($comments as $comment) {
     if($page->id==$comment->post_id)
         { echo "<div class=\"single\">";
         echo  datetime_to_text($comment->created);
      echo "<br>";
     echo $comment->author;
      echo "<br>";
     echo $comment->body;
    
    ?>   <br>
        <a href="delete_comment.php?id=<?php echo $comment->id; ?>&p_id=<?php echo $page->id?>">    <input type="submit" value="delete comment" name="delete" />   </a>
         <br>
        </div>
        <?php
      }
 }
        ?>
      </div>
    
    
  <?php
include_layout_template("footer.php");