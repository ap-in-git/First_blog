<?php
require_once ("../../include/intialize.php");
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
$current_page = posts::find_selected_page();
if (!$current_page->id) {
    redirect_to("admin_index.php");
}

$photo = post_photo::find_by_pid($current_page->post->p_id);
if(isset($_POST["submit"])) {
    $titleerror = check_content($_POST["content"]);
    $contenterror = check_content($_POST["content"]);
       $photoerror=$_FILES["upload"]["error"]==0?true:false;
       
    if (!$titleerror && !$contenterror) {
        $post = new posts();
        global $database;
        $post->p_id = $current_page->post->p_id;
        $post->sub_name = $current_page->post->sub_name;
        $post->content = $database->escape_value($_POST["content"]);
        $post->title = $database->escape_value($_POST["title"]);
        $post->visible = $database->escape_value($_POST["visible"]);
        $post->update();
        if($photoerror) {
            $photon = new post_photo();
            $photon->photo_id = $photo->photo_id;
            $photon->post_id = $current_page->post->p_id;
            $photon->attach($_FILES["upload"]);
            if ($photon->save()) {
                $session->message("Post edited successfully");
                redirect_to("admin_index.php");
            }
            else 
           {    echo  $message = join("<br />", $photon->errors);}
        }else
        {
            $session->message("post edited succesfully");
            redirect_to("admin_index.php");}
    }
} else {
    
    
    $titleerror = $contenterror = "";
}
include_layout_template("admin_header.php");

output_message($message);

?>
<div class="image"><img src="../<?php echo $photo->image_path(); ?>"> </div>
<form action="edit_post.php?id=<?php echo $current_page->id ?>" enctype="multipart/form-data" method="POST">
    Title:<br><textarea name="title" rows="5" cols="80"> <?php echo $current_page->post->title; ?></textarea> <br>
<?php output_message($titleerror); ?>

    Visible: <input type="radio" name="visible" value="" checked /> No
    &nbsp;
    <input type="radio" name="visible" value="1" /> Yes

    <br>
    Content:<br> <textarea name="content" rows="20" cols="80"><?php echo $current_page->post->content; ?></textarea> <br> 
<?php output_message($contenterror); ?>

    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
    <p><input type="file"  name="upload" /></p> <?php output_message($message);?>
    <input type="submit" value="Edit" name="submit" />

</form>
<a href="delete_post.php?id=<?php echo $current_page->id ?>"><input type="submit" value="Delete" onclick="return confirm('Are you sure?');"></a>
<a href="admin_index.php"> <input type="submit" value="cancel"/></a> 
<?php
include_layout_template("admin_footer.php");
