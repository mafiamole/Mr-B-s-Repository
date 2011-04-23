<?php
require_once './framework/module.php';

class forumLoader implements module {
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
  
  protected function loadType($type) {
    require_once 'forums.php';

    $forum = new forums($this->id,$this->conf);
              
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
}

$bob = new forumLoader($moduleData->m2Id,$moduleConf);
?>
