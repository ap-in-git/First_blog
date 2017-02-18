<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Decription of post_photo
 *
 * @author ashok
 */
class post_photo extends photo {
   public static $table_name="post_photo";
   public static $db_fields=["photo_id","file_name","id","post_id","size","type"];
   public $file_name;
   public $photo_id;
   public $post_id;
   public $size;
   public $type;
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
                   
                    $this->type=$file["type"];
                    $this->file_name=basename($file["name"]);
                    $this->size=$file["size"];
                    return TRUE;
                }
            }
           
        
        }
        
            public function save() {
        if (isset($this->photo_id)) {
            $this->update();
             $target_path=SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->file_name;
             move_uploaded_file($this->temp_path, $target_path);
        } else {
            if (!empty($this->errors)) {
                return FALSE;
                }
              
                
                if(empty($this->file_name)||empty($this->temp_path)){
                    $this->errors[]="File path unavilable";
                }
                $target_path=SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->file_name;
                
               if($this->file_name=="produce.jpg"){
                   $this->errors[]="cannot insert file with name produce.jpg";
                   return FALSE;
               }
              
                if(move_uploaded_file($this->temp_path, $target_path)){
                    if($this->create()){
                        unset($this->temp_path);
                        return TRUE;
                    }
                }else{
                    $this->errors[]="file upload failed ,possibly due to incorrect permssion to acces the file";
                    return FALSE;
                }
        }
    }
            
       
           
           
           
    
        
        
   
}
