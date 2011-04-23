<?php
require_once 'db.php';

class moduleData {
  /**
   * 
   * @var Db
   */
  protected $Db;
  
  
  public function __construct() {
    
    $this->Db = Db::i();
        
  }
  
  public function getAllLinked($m2Id,$type,$link) {
    
    $data = array(
      ':m2Id' => $m2Id,
      ':type' => $type,
      ':link' => $link
      );
    $sql = "SELECT `mcId`,`title`,`content`,`type` FROM `moduleContent` WHERE `link`=:link AND `type`=:type AND `m2Id` = :m2Id";

    return $this->Db->fetchAll($sql,$data,PDO::FETCH_OBJ);
    
  }
  
  public function getOneLinked($m2Id,$type,$link) {

    $data = array(
      ':m2Id' => $m2Id,
      ':type' => $type,
      ':link' => $link
      );
    $sql = "SELECT `mcId`,`title`,`content`,`type` FROM `moduleContent` WHERE `link`=:link AND `type`=:type AND `m2Id` = :m2Id";
    
    return $this->Db->fetchOne($sql,$data,PDO::FETCH_OBJ);
    
  }
  
  
}

?>