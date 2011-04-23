<?php
/**
 * Modules Management Package
 * This class is used to obtain lists of modules and resolve loading of modules
 * @package ModulesManagement
 * @author Paul Robert Brown
 */

/**
 * Modules class
 * This class is used to obtain lists of modules and resolve loading of modules
 * @package Modules
 */
class Modules {
  
  /**
   * An array of system modules.
   * @var array
   */
  protected $sysModules;
  /**
   * Database object
   * @var Db
   */
  protected $Db;
  
  /**
   * The constructor sets the sysModules and Db member variables.
   * @param array $sysModules
   */
  function __construct($sysModules) {
    
      $this->sysModules = $sysModules;
      
      $this->Db = db::i();
    
  }
  /**
   * Returns a list of all modules
   * 
   * @return array
   */
  public function listModules() {
    
      return $this->Db->fetchAll("SELECT mId,name,dir FROM modules",null,PDO::FETCH_OBJ);
      
    
  }
  
  /**
   * Used to resolve a module
   * 
   * @param string $url
   * @return array
   */
  public function resolveInstance($url) {
    
    $isSys = $this->findSysModule($url);
    
    if ($isSys === false) {
      
      $data = array($url);
      
      $output = $this->Db->fetchOne("
              SELECT `moduleInstances`.`m2Id` , `moduleInstances`.`mId` , `moduleInstances`.`title` , `moduleInstances`.`url` , `modules`.`dir`
              FROM `moduleInstances`
              INNER JOIN `modules` ON `moduleInstances`.`mId` = `modules`.`mId`
              WHERE `moduleInstances`.`url` =?",
              $data,PDO::FETCH_OBJ);
              
      if ($output) {
        
          return $output;
          
      }
      else {
        
        return false;
        
      }

    }
    else {
      
      return $isSys;
      
    }
    
  }
  
  public function instancesList() {
    
    $sql = "SELECT `moduleInstances`.`m2Id` , `moduleInstances`.`mId` , `moduleInstances`.`title` , `moduleInstances`.`url` , `modules`.`dir` , `modules`.`name`
            FROM `moduleInstances`
            INNER JOIN `modules` ON `moduleInstances`.`mId` = `modules`.`mId`";
    
    return $this->Db->fetchAll($sql,null,PDO::FETCH_OBJ);
    
  }
  
  public function addInstance($mId,$title,$url) {
    $sql = "INSERT INTO `moduleInstances` (`mId`,`title`,`url`)
            VALUES (:mId,:title,:url);";
    $data = array(
      ':mId'=>$mId,
      ':title'=>$title,
      ':url'=>$url              
      );    
  return $this->Db->performQuery($sql,$data);

  }
  
  public function editInstance($m2Id,$mId,$title,$url) {
    $sql = "UPDATE `MSys`.`moduleInstances`
            SET
            `m2Id` = :m2Id,
            `mId` = :mId,
            `title` = :title,
            `url` = :url
            WHERE m2Id = :m2Id;
            ";
    $data = array(
      ':m2Id'   => $m2Id,
      ':mId'    => $mId,
      ':title'  =>$title,
      ':url'    => $url
      );
      
    $this->Db->performQuery($sql,$data);
    
  }
  
  public function removeInstance($m2Id) {
    
    $data = array($m2Id);
    
    $sql ="DELETE FROM `moduleInstances`
           WHERE m2Id = ?";

    $this->Db->performQuery($sql,$data);
    
  }
  /**
   * Returns an array containing information to load a system module
   * @param string
   * @return array
   */
  public function findSysModule($url) {
    
    foreach ($this->sysModules AS $module) {
      
      if ($module['instances'] == $url) {
        $mod = new stdClass();
        $mod->dir = $module['dir'];
        $mod->name = $module['name'];
        $mod->instance = $module['instances'];
        $mod->m2Id = 0;
        return $mod;
      
      }
      
    }
    return false;
    
  }
  
  public function instanceConfig($id) {
    
    $sql = "SELECT `name`,`value` FROM `moduleConfig` WHERE `m2Id`=?";
    
    $data = array($id);
    
    $data = $this->Db->fetchAll($sql,$data,PDO::FETCH_NUM);
    
    $conf = array();
    
    foreach ($data as $value) {
      
      $conf[$value[0]] = $value[1];
      
    }
    
    return $conf;
    
  }
  
}
?>