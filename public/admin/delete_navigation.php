<?php
require_once("../../include/intialize.php");
if(!$session->is_logged_in()){
    redirect_to("login.php");
}
if(empty($_GET["id"])){
    redirect_to('edit_navigation.php');
}else{
    $navigation_count=subject::count_all();
    if($navigation_count==1){
      $session->message("At least one navigation is required");
      redirect_to("edit_navigation.php");
    }else{
    $navigation=subject::find_by_id($_GET["id"]);
   
    posts::find_post_by_subject($navigation->menu_name);
    
    $posts= posts::find_all("p_id");
    foreach ($posts as $post){
    if($post->sub_name==$navigation->menu_name){
       $photo= post_photo::find_by_pid($post->p_id);
       $comments= comment::find_comments_on($post->p_id);
       foreach($comments as $comment){
           $comment->delete();
       }
         if($photo->post_id==$post->p_id){
          $post->delete();
          $photo->destroy();
 
         }
    }
}
      $delete=$navigation->delete();
    if($navigation&&$delete){
        $session->message("Navigation menu deleted sucessfully");
        redirect_to("admin_index.php");
                
    }
    else{
        redirect_to("edit_navigation.php");
    }}
}