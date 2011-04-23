<?php
/**
 * 
 * @package Db
 */
require_once './config/db.php';

class Db {
  
  /**
   * PDO Instance for class
   * @var pdo
   */
  protected $pdo;
  /**
   * Main instance of class
   * @var db
   */
  static protected $instance;
  
  protected function __construct() {
    
    $this->pdo = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
    
  }
  /**
   * returns an instance of this class
   * 
   * @return db
   */
  static public function i() {
    
    if (!(db::$instance instanceof db)) {
      
     db::$instance = new self;      
    }

    
    return db::$instance;
    
    
  }
  /**
   * Performs a standard prepared PDO query and returns a single row of results
   * 
   * @param string $sql SQL query to perform,with parameters
   * @param array $data An array of data, which its structure depending on the parameter types used as defined in the PDO documentation.
   */
  public function fetchOne($sql,$data,$returnMode = null) {
    
    $query = $this->performFetchQuery($sql,$data);
    
    if ($returnMode !== null) {

      return $query->fetch($returnMode);
      
    }
    else {
      
      return $query->fetch();
      
    }
    
  }
  
  public function fetchAll($sql,$data,$returnMode = null) {
    
    $query = $this->performFetchQuery($sql,$data);
    
    if ($returnMode !== null) {

      return $query->fetchAll($returnMode);
      
    }
    else {
      
      return $query->fetchAll();
      
    }
        
  }
  
  /**
   * Performs a query and returns if it was sucessful or not.
   * @param string $sql see fetchOne
   * @param array $data see fetchOne
   * @return bool
   */
  public function performQuery($sql,$data) {
    
    $query =  $this->pdo->prepare($sql);

    return $query->execute($data);
            
  }
  /**
   * General form of the fetch methods.
   * @param string $sql see fetchOne
   * @param array $data see fetchOne
   * @return PDOStatement
   */
  protected function performFetchQuery($sql,$data) {
    
    $query =  $this->pdo->prepare($sql);
    if ($data != NULL) {
      $query->execute($data);
    }
    else {
      
      $query->execute();
      
    }
    return $query;
    
  }
  
}
