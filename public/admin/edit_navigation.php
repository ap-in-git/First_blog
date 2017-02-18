<?php
 require_once('../../include/intialize.php');
 
if(!$session->is_logged_in()){
    redirect_to("login.php");
}
include_layout_template('admin_header.php');

$selected_page= subject::find_selected_subject();

if(isset($_POST["edit_subject"])){
    global $database;
    $name=$_POST["menu_name"];
    $nameerror= check_name($name,"subject");
     if(!$nameerror){
         $subject=new subject();
          $subject->sub_id=$selected_page->id;
          $subject->menu_name=$database->escape_value($_POST["menu_name"]);
          $subject->position=(int)$_POST["position"];          
          $updated=$subject->update($subject,$subject->sub_id);
          if($updated){
             $session->message("Navigation edited sucessfully");
             redirect_to("edit_navigation.php");
          }else{
              $session->message("Navigation editing Failed");
              redirect_to("edit_navigation.php");
              
        }
          
     }
}else{
    $nameerror="";
   
}

 
 subject::view_navigation(TRUE,FALSE);
 echo output_message($message);
 ?>

<?php 
 if($selected_page->selected){?>
<h2> Edit Navigation:  <?php  echo $selected_page->subject->menu_name;   ?> </h2>
    <form action="edit_navigation.php?id=<?php  echo urlencode($selected_page->id);?>" method="POST">
        <p> Menu-name:<input type="text" name="menu_name" value="<?php echo htmlentities($selected_page->subject->menu_name); ?>" /> <?php echo $nameerror ?></p>
       <select name="position">
         <?php
         for($count=1;$count<= subject::count_all();$count++){
        echo"<option value =\"{$count}\"";
        if ($selected_page->subject->position==$count) {
            echo "selected";
        }
            echo ">{$count}</option>";
        
        }
        
        ?>
       </select>
        <br>
        
       <input type="submit" name="edit_subject" value="Edit Subject" />
    </form>
<a href="delete_navigation.php?id=<?php echo urlencode($selected_page->id);?>" onclick="return confirm('Are you sure?');" > <input type="submit" value="delete" /></a> 
 <?php   }
 
 include_layout_template("admin_footer.php");