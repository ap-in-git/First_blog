<?php
class subject extends dbobject{
   public static $table_name="nav_subject";
   public static $db_fields=['sub_id','menu_name','position'];
   public $sub_id;
   public $menu_name;
   public $position;
  public $selected;
  public $id;
   public $subject_id;
   
   public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE sub_id={$id} order by position asc");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  
   public function find_default_subject(){
      
       $sql="SELECT * FROM nav_subject ORDER by position LIMIT 1";
        $result_array= self::find_by_sql($sql);
        return  !empty($result_array)?  array_shift($result_array):false;
   

  }

  public static function  find_selected_subject(){
      if(isset($_GET["id"])){
          $id=$_GET["id"];
    $current_subject=new self;
    $current_subject->id=$id;
        $current_subject->subject=self::find_by_id($current_subject->id);
        $current_subject->selected=true;
    return $current_subject;
}else{
    $current_subject=new self;
 $current_subject->subject=self::find_default_subject();
         $current_subject->id=$current_subject->subject->sub_id;
    $current_subject->selected=false;
    return $current_subject;
    
  }
  }
  
 

  
  
  
  public static function view_navigation($admin=true,$main="true"){
      
     $selected_subject= subject::find_selected_subject();
        echo "<div id=\"nav\">";
        echo "<ul class=\"span\">";
       foreach(self::find_all() as $navi):
        echo"<li class=\"span ";
       if($selected_subject->id===$navi->sub_id)
       {echo "a ";}
    
      echo "\">";
         if($admin)
         {if($main)
         {echo "<a href=\"admin_index.php?id=";}
         else{echo "<a href=\"edit_navigation.php?id=";}}
         else{echo "<a href=\"index.php?id=";
             
         }
         echo urlencode($navi->sub_id);
        
        echo "\">";
        echo $navi->menu_name;

        echo "</a></li>";
        
        endforeach;
        if($admin){
            if($main){
              
         
         echo "<li  class=\"span\"><a href=\"edit_navigation.php\">Edit_navigation</a></li>";
         echo "<li  class=\"span\"><a href=\"new_post.php?id=";
          echo $selected_subject->id;
         echo "\">Add New Story</a></li>";
                
            }
            else{
                echo "<li  class=\"span\"><a href=\"admin_index.php\">Main Page</a></li>";
               echo "<li  class=\"span\"><a href=\"new_navigation.php\">Add a navigation</a></li>";
            }
            }
              echo "<div class=\"clearfix\"></div>";
   echo" </ul>";
  
 echo "</div>";
}



  public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
	      $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	        $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	   
	    return true;
	  } else {
	    return false;
	  }
	}
        
        

	public function update() {
	  global $database;
		
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE sub_id=". $database->escape_value($this->sub_id);
                $sql .=" Limit 1";
	  $database->query($sql);
	  return ($database->affected_rows()==1) ? TRUE: FALSE;
}
        
        

	public function delete() {
		global $database;
		
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE sub_id=". $database->escape_value($this->sub_id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}
        
        
 
	
}