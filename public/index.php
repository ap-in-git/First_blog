<?php
require_once('../include/intialize.php');

$posts= posts::find_all_desc("p_id");
include_layout_template("header.php");
$selected= subject::find_selected_subject();
 $photos= post_photo::find_all("photo_id");
 subject::view_navigation(false);
?>

<div id="hante">
    <div class ="baula "></div>
    <div class ="baula c">
        
        <?php
     
        foreach ($posts as $post):
            if($post->sub_name==$selected->subject->menu_name){ ?>
        <div class="post">
            <div class="title"><?php echo $post->title;?></div>
            <?php foreach ($photos as $photo):
                if($post->p_id==$photo->post_id){
                ?>
            <div class="image"><img src="<?php echo (string)$photo->image_path();?>"></div>
                <?php }endforeach;?>
            <div class="short_description"><?php echo $post->content; ?> </div>
            <div class="more">
                <a href="post.php?id=<?php echo $post->p_id ?>"><h4>Read More</h4></a>
                
               </div>

        </div>
            <?php        }endforeach;?>
        </div>
    <div class ="baula d">
          <?php include_layout_template("about.php") ?>
    </div>
    <div class="clearfix"></div>
</div>




<?php
include_layout_template('footer.php');
