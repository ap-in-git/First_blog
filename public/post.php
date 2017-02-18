<?php
require_once ("../include/intialize.php");
$page= posts::find_selected_page();
$photos= post_photo::find_all("photo_id");
if(!$page->id){
    redirect_to("index.php");
}
if(isset($_POST["submit"])){
     global $database;
    $author= $_POST["author"];
    $body= $_POST["body"];
    $checkerror= check_content($body);
    if(!$checkerror){
    {  $post_id=$page->id;
    if(!$author){
        $author="Anynomous";
    }
    $new_comment= comment::make($post_id, $author, $body);
     if($new_comment->save()){
         redirect_to("post.php?id={$post_id}");
     }{
         redirect_to("post.php?id={$post_id}");  
    }}}
     
}
 else{
 $checkerror="";   
}
include_layout_template("header.php");

?>   
    <div class ="posttitle"> <?php echo nl2br($page->post->title)?></div>
    <div class ="readyimage">
    <img src=" <?php 
         foreach ($photos as $photo){
             if($photo->post_id==$page->id){
               echo $photo->image_path();
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
      echo " <br>  ";
     echo $comment->author;
      echo ":";
     echo nl2br($comment->body);
     echo "<br>";
     echo "</div>";
     ;}
 }
        ?>
      </div>
    
    <div class="comment">
        <form name="comment" action="post.php?id=<?php echo $page->id ?>"  method="POST">
            <br>Name   <input type="text" name="author" value="" /><br>
            Comment<br>:<textarea name="body"  rows="10" cols=40></textarea><br><?php output_message($checkerror); ?>
            <input type="submit" name="submit" value="submit" />
             
        </form>
    </div>
    
    
<?php    




?>



<?php
include_layout_template("footer.php");