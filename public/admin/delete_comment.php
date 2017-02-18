<?php
require_once ("../../include/intialize.php");
if(!$_GET["id"]&&!$_GET["p_id"]){
    redirect_to("admin_index.php");
}

    $comment= comment::find_by_id($_GET["id"]);
    if($comment->delete()){
        redirect_to("read_admin.php?id=".$_GET["p_id"]);
    }else{

    }
    
