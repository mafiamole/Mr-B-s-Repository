<?php
namespace html;

class Tag {
  
  protected $name;
  
  protected $attr;
  
  protected $selfClosing;
  
  protected $value;
   /**
   * @param string $name
   * @param string $value
   * @param bool $selfClosing
   */   
  public function __construct($name,$value ="",$selfClosing = false) {
    
    $this->name = $name;
    
    $this->attr = array();
    
    $this->selfClosing = $selfClosing;
    
    $this->value = $value;
    
  }
   /**
   * @param string $name
   * @param string $value
   */ 
  public function addAttr($name,$value) {
    
    $this->attr[$name] = $value;
    
  }
  /**
   * @param string $name
   */  
  public function getAttr($name) {
    
    return $this->attr[$name];
    
  }
  /**
   * @param string $name
   */
  public function remAttr($name) {
    
    if (isset($this->attr[$name])) {
      
      unset($this->attr[$name]);
      
    }
    
  }
  /**
   * @return string 
   */
  public function getData() {
    
    return $this->value;
    
  }
  /**
   *  @return string
   */
  public function full() {
    
    $output = $this->open();
    
    $output .= $this->value;
    
    $output .= $this->close();
    
    return $output;
    
  }
  /**
   *  @return string
   */  
  public function open() {
    
    $output = "<{$this->name}";
    
    if (!empty($this->attr)) {
      
      foreach ($this->attr as $name => $value) {
        
        $output .= " {$name}=\"{$value}\"";
        
      }
      
    }
    if (!$this->selfClosing) {
      
      $output .= ">";
      
      }
    else {
      
      $output .= " />";
      
    } 
    
    return $output;
    
  }
  /**
   *  @return string
   */  
  public function close() {
    
    if (!$this->selfClosing) {
      return "</{$this->name}>";
      }
    else {
      
      return "";
      
    } 
    
  }
  
}
/**
 * @package html\OptionList
 * 
 */
class OptionList {
  /**
   *  @var array
   */  
  protected $options;
   /**
   *  @var string
   */ 
  protected $selectMatch;
  
  public function __construct($selectMatch = null) {
    
      $this->options = array();
      
      $this->selectMatch = $selectMatch;
      
  }
   /**
    *
    * @param string $name
    * @param string value
    * @param bool $selected
    * @param string $class HTML class attribute value.
    * @return optionList
    */
  public function add($name,$value,$selected = false,$class = null) {
    
      $option = new Tag("option",$name);
      
      $option->addAttr("value",$value);
      
      if ($selected !== false) {
        
        $option->addAttr("selected","selected");
        
      }
       else if ($this->selectMatch !== null) {
        
        $option->addAttr("selected","selected");        
        
      }
      else {
        
        
      }   
      
      if ($class !== null) {
        
        $option->addAttr("class",$class);
        
      }
      
      $this->options[] = $option;
      
    return $this;
    
  }
  /**
   * @param mixed $valueMatch
   */
  public function show($valueMatch = null) {
    
    $output = "";
        
    foreach($this->options as $option) {
      
      if ($valueMatch == $option->getAttr("value")) {
        
        $tempNode = clone $option;
        
        $tempNode->addAttr("selected","selected");
        
        $output .= $tempNode->full();
                
      }
      else {
        
       $output .= $option->full() . "\n";       
        
      }
        
     
    }
    
    return $output;
  }
  
}

class form {
  /**
   * @param string $action
   * @param string $class
   * @param string $method
   * @return string
   */
  static public function form_open($action,$class = "",$method = "post")  {
    
    $output = new Tag("form");
    if ($class !== "") {
      $output->addAttr("class",$class);
      }
    $output->addAttr("method",$method);
    $output->addAttr("action",$action);
    
    return $output->open();
    
  }
  /**
   * 
   * @return string
   */
  static public function form_end() {
    
    return "</form>";
    
  }
  /**
   * @param string $name
   * @param OptionList $optionList
   * @param string $optionSelect
   * @param string $class
   * 
   * @return string
   */
  static public function select($name,$optionList, $optionSelect = null, $class = null) {
    
    if ($optionList instanceof OptionList) {
      
      $options = $optionList->show($optionSelect);
      
    }

    $output = new Tag("select",$options);
    
    
    $output->addAttr("name",$name);

    if ($class !== null) {
      
      $output->addAttr("class",$class);  
      
    }
    
    return $output->full();
  
  }
  /**
   * @param string $selectedMatch
   * @return OptionList
   */
  static public function optionList($selectMatch = null) {

    return new OptionList($selectMatch);
    
  }
  
  static public function hidden($name,$value) {
    
    $hidden = new Tag("input","",true);
    $hidden->addAttr("name",$name);
    $hidden->addAttr("value",$value);
    $hidden->addAttr("type","hidden");
    return $hidden->full();
    
  }
}

?>