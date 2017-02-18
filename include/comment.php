<?php

class comment extends dbobject{
    public static $table_name="comments";
    public static $db_fields=["id","post_id","created","author","body"];
    public $id;
    public $post_id;
    public  $created;
    public $author;
    public $body;
    
    	public static function make($post_id, $author="Anonymous", $body="") {
    if(!empty($post_id) && !empty($author) && !empty($body)) {
			$comment = new Comment();
	    $comment->post_id = (int)$post_id;
	    $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
	    $comment->author = $author;
	    $comment->body =$body;
	    return $comment;
		} else {
			return false;
		}
	}
	
	public static function find_comments_on($post_id=0) {
    global $database;
    $sql = "SELECT * FROM " . self::$table_name;
    $sql .= " WHERE post_id=" .$database->escape_value($post_id);
    $sql .= " ORDER BY created ASC";
    return self::find_by_sql($sql);
    
	}
        public function create() {
		global $database;
		
		$attributes = $this->sanitized_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
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
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;

	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		
        }
        public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
        public static function find_by_id($id=0){
            
           $sql="select *from ".self::$table_name." where id={$id} limit 1";
           $result_array= self::find_by_sql($sql);
           return !empty($result_array) ? array_shift($result_array) : false;
        }
}