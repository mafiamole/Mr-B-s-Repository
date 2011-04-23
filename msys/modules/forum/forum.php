<?php
require_once '././framework/module.php';

class Forum implements module {
  /**
   * @var Url
   */
  protected $Url;
  /**
   * @var int
   */
  protected $id;
  /**
   * 
   * @var array
   */
  protected $conf;
  /**
   * Begins the execution of the forums app
   * @param int $id
   */
  public function __construct($id,$conf) {
    
    $this->Url = new Url();
    
    $open = $this->Url->getItem(1);
    
    $this->id = $id;
    
    $this->conf = $conf;
     
    $this->loadType($open);
    
  }
  
  
  public function loadContents($url) {
      
  }
  
  
  protected function loadType($type) {
    require_once 'forumModel.php';

    $forum = new forumModule($this->id,$this->conf);
              
    switch($type) {
     
      case "thread":
          
          $posts = $forum->posts($this->Url->getItem(2));
          $thread = $forum->thread($this->Url->getItem(2));
          require 'html/thread.php';
          
          
        break;
        
      case "forum":
        
          $forumList = $forum->childForums($this->Url->getItem(2));
          
          $threads = $forum->threads($this->Url->getItem(2));
                    
          require 'html/forum.php';
          
          require 'html/threads.php';
          
        break;
        
      default:
          
          $forumList = $forum->childForums(0);
          
          require 'html/forum.php';
          
        break;
      
    }
    
  }
 public static function externalJoin($m2Id) {
  /** currently the forum has no such capability**/ 
  }
  
  public static function externalOutput($data) {
    
    
  }
  
    
  public static function views() {
    
    array (
      
      'thread',
      'forum',
      'posts',
      'index'
      
      );
    
  }
  
  public static function loadView($name) {
    
    switch ($name) {
      
      case 'thread': 
        
        break;
      case 'forum':
        
        break;
      case 'café':
        
        break;
      case 'posts':
        
        break;
        
      case 'index':
        break;
      
    }
  }
}

?>
