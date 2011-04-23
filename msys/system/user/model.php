<?php
require_once './framework/db.php';

class user_model {
  
  protected $table;
  
   public function __construct($userTable) {
      $this->setTable($userTable);
   }
  
   public function setTable($userTable) {
    
     $this->table = $userTable;
     
   }
   /**
    * Returns an array of object items, one of each user 
    * @return array
    */
   public function userList() {
    
     $db = db::i();
     
     $sql = "SELECT uId,username,email FROM {$this->table}";

     return $db->fetchAll($sql,null,PDO::FETCH_OBJ);
     
   }
  
}
?>