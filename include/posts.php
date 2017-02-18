<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of posts
 *
 * @author ashok
 */
class posts extends dbobject {
    public static $table_name="posts";
    public static $db_fields=["content","p_id","sub_name","title","visible"];
    public $content;
    public $p_id;
    public $sub_name;
    public $visible;
    public $title;
    
          public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE p_id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
         public static function find_post_by_subject($name="") {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE sub_name= \"{$name}\" LIMIT 1 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
        
  public function find_default__post_for_subject($subject_id) {
      global $database;
		$page_set = find_post_for_subject($sub_id);
		if($first_page = $database->fetch_array($page_set)) {
			return $first_post;
		} else {
			return null;
  }}
  
    
    	public function create() {
		global $database;
		
		$attributes = $this->sanitized_attributes();
	      $sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	        $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->p_id = $database->insert_id();
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
		$sql .= " WHERE p_id=". $database->escape_value($this->p_id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
		
	  $sql = "DELETE FROM ".static::$table_name;
	  $sql .= " WHERE p_id=". $database->escape_value($this->p_id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		
	}
        
        
        
        
  public static function  find_selected_page(){
      if(isset($_GET["id"])){
          $id=$_GET["id"];
    $current_page=new self;
    $current_page->id=$id;
        $current_page->post=self::find_by_id($current_page->id);
        $current_page->selected=true;
    return $current_page;
}else{
    $current_page=new self;
    $current_page->page="";
   $current_page->selected=false;
    return $current_page;
    
  }
  }
        
        
}
