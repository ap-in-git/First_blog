<?php
class dbobject{
public static function find_by_sql($sql=""){
       global $database;
       $result_set=$database->query($sql);
        $object_array=[];
        while($row=$database->fetch_array($result_set)){
            $object_array[]= static::instantiate($row);
        }
        return $object_array;
   }
   
    protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(static::$db_fields as $fields) {
	    if(property_exists($this, $fields)) {
	      $attributes[$fields] = $this->$fields;
	    }
	  }
	  return $attributes;
	}
        
         private function has_attribute($attribute) {
        return array_key_exists($attribute, $this->attributes());
     }
     private static function instantiate($record){
         $class_name= get_called_class();
       $object= new $class_name;
       
       foreach ($record as $attribute => $value) {
           if($object->has_attribute($attribute)){
               $object->$attribute=$value;
           }
       }
       return $object;
       
    }
     public static function find_all($field="position"){
      return static::find_by_sql("select * from ".static::$table_name." order by ".$field." ASC");
  }
  
  public static function find_all_desc($field="position"){
      return static::find_by_sql("select * from ".static::$table_name." order by ".$field." desc");
  }
  
  public static function count_all() {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".static::$table_name;
       $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
      return array_shift($row);
	}

        protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
}
