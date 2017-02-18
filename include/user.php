<?php
require_once(LIB_PATH.DS.'database.php');

class user extends dbobject{
    protected  static $table_name="users";
    protected static  $db_fields=['id','username','password','first_name','last_name'];
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
   

    public function fullname(){
        if(isset($this->first_name)&&isset($this->last_name)){
            return $this->first_name." ".$this->last_name;
        }else{
            return "";
        }
    }
    
     public static function authenticate($username="",$password=""){
       global $db;
      $username=$db->escape_value($username);
        $password=$db->escape_value($password);
       $sql= "select *from users ";
       $sql.="where username='{$username}' ";
       $sql.="and password='{$password}' ";
       $sql.="limit 1";
       
       $result_Array= self::find_by_sql($sql);
       
        return !empty($result_Array)? array_shift($result_Array):null;
       }
       
        public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
}