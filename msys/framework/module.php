<?php

interface module {
  
  public static function externalJoin($m2Id);
  public static function externalOutput($data);
  public static function views();
  public static function loadView($viewName);
    
}

class mOut {
  /**
   * 
   * @var string
   */
  protected $tablename;
  /**
   * 
   * @var array
   */
  protected $columnsNames;
  
  /**
   * Set and/or obtain the table name
   * @param string $name
   * @return string
   */ 
  public function __construct($name) {
    
      $this->tablename = $name;
      
      $this->columnsNames = array();
      
  }
  /**
   * Set and/or obtain the table name
   * @param string $name
   * @return string
   */
  public function table($name = null) {
    
    if ($name !== null) {
      
      $this->tablename = $name;
      
    }
    
    return $this->tablename;
    
  }
  /**
   * Returns the columns as an array. The name includes the table name for absolute resolution, and their alias (as clause).
   * 
   * @return array;
   */
  public function columns() {
    
    $output = array();
    
    foreach($this->columnsNames as $column) {
      
      $name = $this->tablename . "." . $column['title'];
      
      $alias = $column['alias'];
      
      $output[] = $name . " AS " . $alias;
      
    }
    return $output;
  }
  
  /**
   * 
   * 
   */
  public function addColumn($name,$alias) {
    
    $this->columnsNames[] = array(
      'name' => $name,
      'alias' => $alias
      );
    
  }
  
}
?>