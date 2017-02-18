<?php
require_once("../../include/intialize.php");
if(!$session->is_logged_in()){
    redirect_to("login.php");
}
if(empty($_GET["id"])){
    redirect_to("admin_index.php");
}else{
   
    $photo= post_photo::find_by_pid($_GET["id"]);
    $post= posts::find_by_id($_GET["id"]);
     $comments= comment::find_comments_on($_GET["id"]);
     foreach ($comments as $comment){
         $comment->delete();
     }
     
   if($photo->destroy()&&$post->delete())
      {   $session->message("post delete succesfull");
       redirect_to("admin_index.php");
    
      }else{
           $session->message("post delete failed");
       redirect_to("admin_index.php");
           
       }
}