<?php
require_once 'db.php';

class themeManager {
  /**
   * 
   * @var db
   */
  protected $db;
  
  public function __construct() {
   
    $db =  Db::i();
    
  }
  
  public function themePageModules($id) {
    
    $sql = "SELECT `sectionName`,`m2Id` FROM `themeLayout` WHERE `themeId`= ? ";
    
    $items = $this->db->fetchAll($sql,array($id),PDO::FETCH_ASSOC);
    
    $output = array();
    
    foreach ($items as $item) {
      
      $output[$item['sectionName']][] = $item['m2Id'];
      
    }
    
    return $output;
    
  }
  
  public function getCurrentTheme() {
    
    
  }
 
}

?>