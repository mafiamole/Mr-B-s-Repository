<?php
require_once './framework/module.php';
require_once 'model.php';

class user implements module {
  /**
   * @var user_model
   */
  protected $model;
  /**
   * 
   * @param url $url
   * @param array
   */
  public function __construct($url,$modules) {
    
    $this->model = new user_model("users");
    
    if ($url->count() > 2) {
      
      
      
    }
    else {
      
      $userlist = $this->model->userList();
      
      require 'html/userlist.php';
      
    }
    
  }
  
  
  public static function externalJoin($m2Id) {
    
    // module id goes unused in this particular case.
    
    $output = new mOut("users");
    
    $output->addColumn("username","username");
    
    $output->addColumn("email","email");
    
  }
  
  public static function externalOutput($data) {
    
    
    
  }
  
}

$page = new user($url,$moduleResolve);

?>