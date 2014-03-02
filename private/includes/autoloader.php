<?
class Autoload_Class {
    private $class_name;
    private $class_file;
    
    /*
    * register $this->autoload() function as __autoload() implementation
    */
    function __construct() {
        spl_autoload_register(array($this, 'autoload'));
    }
    
    /*
    * autoload a class file: resolve path to file and include
    * 
    * @param $class_name: name of class attempting to instantiate
    * @return: true or false if file exists
    */
    private function autoload($class_name) {
        $this->class_name = $class_name;
        $this->get_class_file();
        
        if (!empty($this->class_file) && @file_exists($this->class_file)) {
            include_once($this->class_file);
            return true;
        }
        return false;
    }
    
    /*
    * resolve path of class to include
    * 
    * class containing files follow a convention
    *   private/
    *     models/
    *       {model_class}_model.php
    *     controllers/
    *       {controller_class}_controller.php
    *
    * class names follow a convention
    *   {model_class}_Model
    *   {controller_class}_Controller
    *
    * @return: true
    */
    private function get_class_file() {
        $this->class_name = strtolower($this->class_name);
        $this->class_file = '';
        
        if (strpos('~'.$this->class_name, 'model')) {
            $this->class_file = MODEL_PATH.$this->class_name.'.php';
        } else if (strpos('~'.$this->class_name, 'controller')) {
            $this->class_file = CONTROLLER_PATH.$this->class_name.'.php';
        }
        return true;
    }
}

// instantiate global $autoloader object
$autoloader = new Autoload_Class();