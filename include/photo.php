
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of photo
 *
 * @author ashok
 */

class photo extends dbobject{
    //put your code here
  
    

    
    public function size_as_text() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}
        
            protected $upload_errors = array(
        // http://www.php.net/manual/en/features.file-upload.errors.php
        UPLOAD_ERR_OK => "No errors.",
        UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL => "Partial upload.",
        UPLOAD_ERR_NO_FILE => "No file.",
        UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
    );
     
  
  public static function find_by_id($id=0) {
	  global $database;
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE photo_id=".$database->escape_value($id)." LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function find_by_pid($id=0) {
	  global $database;
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE post_id=".$database->escape_value($id)." LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }



	
	
	
	
	public function create() {
		global $database;
		
		$attributes = $this->sanitized_attributes();
	      $sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	        $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->photo_id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}
        
        
        public function update() {
	  global $database;
		
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE photo_id=". $database->escape_value($this->photo_id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

         	public function delete() {
		global $database;
		
	  $sql = "DELETE FROM ".static::$table_name;
	  $sql .= " WHERE photo_id=". $database->escape_value($this->photo_id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
		}
		
          
                
                      public function destroy(){
               if($this->delete()){
                   $target_path= SITE_ROOT.DS."public".DS.$this->image_path();
                   return unlink($target_path)?TRUE:FALSE;
               } else {
                   return FALSE;    
               }
           }
             public function image_path(){
               return $this->upload_dir.DS.$this->file_name;
           }

         
           
        
}
