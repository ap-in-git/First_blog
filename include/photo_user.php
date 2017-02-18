<?php

class photo_user extends photo{
    public   static $table_name="profile_photo";
     public static $db_fields=["photo_id","file_name","type","size","blog_name"];
    public  $photo_id;
    public  $file_name;
    public $type;
    public $size;
    public $errors=[];
    public $temp_path;
    public $target_path;
    
    public  $upload_dir="images";
    public $blog_name;





    //instating file to a object
        public function attach($file){
            if(!$file||empty($file)||!is_array($file)){
                $this->errors[]="No file was uploaded";
                return false;
            }else{
                if($file["error"]!=0){
                    $this->errors[]= $this->upload_errors[$file["error"]];
                    
                }
                else{
                    $this->temp_path=$file["tmp_name"];
                    $this->photo_id=1;
                    $this->type=$file["type"];
                    $this->file_name="produce.jpg";
                    $this->size=$file["size"];
                    return TRUE;
                }
            }
           
        
        }
        
            public function save() {
        if (isset($this->photo_id)) {
            
             $target_path=SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->file_name;
             if(move_uploaded_file($this->temp_path, $target_path))
             {
                
                 $this->update();
                 unset($this->temp_path);
                 clearstatcache();
                 return TRUE;
             }else{
                 return FALSE;
             } 
            
        } else {
            if (!empty($this->errors)) {
                return FALSE;
                }
                if(strlen($this->caption)>255){
                    $this->errors[]="caption is to long";
                    return FALSE;
                }
                
                if(empty($this->file_name)||empty($this->temp_path)){
                    $this->errors[]="File path unavilable";
                }
                $target_path=SITE_ROOT.DS."public".DS.$this->upload_dir.DS.$this->file_name;
                
             
                if(move_uploaded_file($this->temp_path, $target_path)){
                    if($this->create()){
                        unset($this->temp_path);
                        clearstatcache();
                        return TRUE;
                    }
                }else{
                    $this->errors[]="file upload failed possibly due to incorrect permssion to acces the file";
                    return FALSE;
                }
        }
    }
            

}

