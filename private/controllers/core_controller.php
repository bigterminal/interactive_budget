<?
class Core_Controller {
    protected $url_parts;
    protected $url_params;
    protected $payload;
    protected $template;
    protected $template_data;
    
    public $can_cache;
    public $cache_expiration;
    
    /*
    * @method: __construct Core_Controller
    *
    * @param $url_parts: exploded (around '/'s) request url parts
    * @param $url_params: dynamic request url paramater parts (key value array)
    * @param $payload: request data payload
    */
    function __construct($url_parts, $url_params, $payload) {
        try {
            $this->url_parts = $url_parts;
            $this->url_params = $url_params;
            $this->data = $payload;
            $this->templates = array('404');
            $this->template_data = array();
            $this->can_cache = true;
            $this->cache_expiration = 300;
        } catch (Exception $e) {
            $this->set_response_code(500);  
        }
    }
    
    /*
    * render Core_Controller's response
    *
    * @display: rengered templates
    * @return: $output
    */
    public function render() {
        try {
            // require Mustache library
            require_once(INCLUDE_PATH.'Mustache/Autoloader.php');
            Mustache_Autoloader::register();
            
            // init Mustache object
            $m = new Mustache_Engine(array('cache' => TEMPLATE_PATH.'cache'));
            $payload = $this->template_data;
            
            $output = '';
            foreach ($this->templates as $template_name) {
                // capture then print template contents and data
                $template = file_get_contents(TEMPLATE_PATH.$template_name.'.tpl');
                $output .= $m->render($template, $payload);
            } 
            return $output;
        } catch (Exception $e) { 
            if (DEBUG) {
                throw new Exception('Something went wrong', 0, $e); 
            } else {
                die('Something went wrong'); 
            } 
        } 
        return false;   
    }
}