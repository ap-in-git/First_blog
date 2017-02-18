<?php
require_once ('../../include/intialize.php');
if($session->is_logged_in()){
    redirect_to("admin_index.php");
}
include_layout_template('login_header.php');
     $message=$username=$password=$errorname=$errorpass="";
if(isset($_POST['submit'])){
   
    $errorname= check_name($_POST["username"],"username");
    $errorpass= check_pass($_POST["password"]);
        if(!$errorname&&!$errorpass){
        $username=$_POST["username"];
        $password=$_POST["password"];
        $found_user= user::authenticate($username, $password);
        if($found_user){
            
            $session->login($found_user);
            redirect_to('admin_index.php');
            
        } else {
            $message= 'Username/Password incorrect';   
            $username="";
            $password="";
        }
        }
    
}else{
    
}
?>
<form action="login.php" method="post">
    Name:<input type="text" name="username" value="<?php echo htmlentities($username)?>">
        <?php echo  $errorname?><br>

        Pass:<input type="text" name="password" value="<?php echo htmlentities($password);?>">
    <?php echo $errorpass;?>
  <br>
    <br>
    <input type="submit" name="submit" value="submit"><br>
      <?php echo $message;?>
<?php // echo $found_user->id;?>    
</form>

<?php
include_layout_template('admin_footer.php');
?>