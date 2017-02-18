<?php
 require_once ("../../include/intialize.php");

 if(!$session->is_logged_in()){
    redirect_to("login.php");
}

 $photoerror=$_FILES["upload"]["error"]==0?false:true;
 if(!$photoerror){
    $photoi=new photo_user();
   
     $photoi->attach($_FILES["upload"]);
     if($photoi->save()){
         $session->message("photograph edited succesfully");
         redirect_to("admin_index.php");
      
     } else {
        $message = join("<br />", $photoi->errors);  
        redirect_to("admin_index.php");
   
     }
     
 } else {
   $session->message("Photograph cannot be edited");
     redirect_to("admin_index.php");
     
}

