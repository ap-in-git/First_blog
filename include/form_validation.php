<?php
 function trim_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

  function check_name($name,$field="name") {
    if(isset($name)){
        $name= trim_data($name);
    if (empty($name)) {
         $nameerror="{$field} Required";
         return $nameerror;
      
    } else{
      // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
         $nameerror="Only letters and white space allowed";
        return $nameerror;}
}

        }
        else{//form not submitted
            
            $nameerror="";
           return $nameerror;            
        }

        }
 function check_pass($password){
    if(isset($password)){
        $password= trim_data($password);
        if(empty($password))
        {$passerror="password required";
        return $passerror;
        }
        
    }
    else{
        
        $passerror="";
       return $passerror;
        
    }
 }

 function check_content($content) {
     
     if(isset($content)){
        
         if(empty($content)){
             $content="content required";
             return $content;
         }
     } else {
         $content="";
         return $content;
         
     }
    
}

function check_upload($file){
    if(empty($file)){
        $filemsg="File required";
       
    }else{
        $filemsg="";
    }
}
    
 

?>