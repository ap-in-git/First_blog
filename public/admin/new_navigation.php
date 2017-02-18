<?php

 require_once("../../include/intialize.php");
 if(!$session->is_logged_in()){
    redirect_to("login.php");
}
 include_layout_template("admin_header.php");
 if(isset($_POST["nav_submit"])){
     global $database;
     $menu_name=$_POST["menu_name"];
     $position=$_POST["position"];
     $menu_name=$database->escape_value($menu_name);
     $nameerror=check_name($menu_name,"name");
     if(!$nameerror){
     $subject=new subject();
     $subject->menu_name=$menu_name;
     $subject->position=$position;
     $subject->create();
     $session->message=("Navigation menu added successfully");
     redirect_to("edit_navigation.php");
     }
     
 }else{
     $nameerror="";
 }
 ?>


  
<form name="subject" action="new_navigation.php" method="POST">
    Menu name:<input type="text" name="menu_name" value=""> <?php echo $nameerror?><br><br>
   Position <select name="position">
      
        <?php
        for($count=1;$count<= subject::count_all()+1;$count++){
        echo"<option>{$count}</option>";
        
        }
        ?>
    </select>
    <br>
    <br>
    <input type="submit" name="nav_submit" value="create subject">
</form>
 
 <?php
 include_layout_template("admin_footer.php");
 

