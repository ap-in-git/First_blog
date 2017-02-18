<?php
$profile_photo= photo_user::find_by_id(1);
$max_file_size = 1048576

?>


            
        <div class="rectangle">
            <h1>About The Blogger</h1>
            <div  class="circle"><img src="../<?php echo $profile_photo->image_path(); ?>"></div>
            <div class="description">Ashok Poudel</br></div>
        </div>
        <div class="Change">
            <form action="edit_photo.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
                <p><input type="file" name="upload" /></p>
                <input type="submit" name="submit" value="Change Photo" />
            </form>
        </div>