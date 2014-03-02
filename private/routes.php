<?
class Routes {
    private $request_method;
    private $uri_string;
    private $url_parts;
    private $url_params;
    private $payload;
    private $controller;
    private $controller_patterns;
    private $cache_key;
    
    function __construct() { 
        $this->controller_patterns = array(
            'Home_Controller' => array(
                array()                           
            ),
            'API_Budgets_Controller' => array(
                array('api', 'budgets')                                
            ),
            'API_Process_Data_Controller' => array(
                array('api', 'process', 'data')                      
            )
        );
    }
    
    /*
    * resolve incoming routes
    * 
    * @return: if controller valid rendered result of resolved controller
    *          else false
    */
    public function resolve() {
        $cache = $this->check_cache();
        
        if ($cache) {
            print $cache;
            return true; 
        } else {  
            $this->initialize_routes();
            $this->resolve_controller();
            
            if (is_object($this->controller) && method_exists($this->controller, 'render')) {
                $output = $this->controller->render();
                
                if ($output) {
                    print $output;
                    global $memcache;
                        if ($this->controller->can_cache && isset($memcache)) {
                        $memcache->set($this->cache_key, $output, 0, $this->controller->cache_expiration);
                    }
                }
                return true;
            }
        }
        return false;
    }
    
    /*
    * initialize routes object
    * capture/formate required information
    *
    * @return: true
    */
    private function initialize_routes() {
        // capture request method, url string, and break url string into parts (around '/')
        $this->request_method = $_SERVER['REQUEST_METHOD'];
        $this->url_parts_string = (isset($_GET['p'])) ? rtrim(strtolower($_GET['p']), '/'): '';
        $this->url_parts = explode('/', $this->url_parts_string);
        
        // capture request payload
        $this->payload = array();
        if ($this->request_method == 'POST') {   
            // POST data if avaiable
            if (!empty($_POST)) {
                $this->payload = $_POST;
                
            // raw JSON if aviaible
            } else {
                $fp = fopen('php://input', 'r');
                $raw_data = stream_get_contents($fp);
                $posted_json = (array)json_decode($raw_data);
                
                if (!empty($posted_json)) {
                    $this->payload = $posted_json;
                }
            }
        }
        
        // type cast all dynamic url parts as INT or FLOAT else leave as STRING
        $preg_pattern = '/[a-zA-Z]/';
        foreach ($this->url_parts as $key=>$value) {
            preg_match($preg_pattern, $value, $matches);
            if (empty($matches)) {
                if ((int)$value != null) $this->url_parts[$key] = (int)$value;
                else if ((float)$value != null) $this->url_parts[$key] = (float)$value; 
            }
        }
        
        return true;
    }
    
    /*
    * resolve required controller to render
    *
    * @return: true
    */
    private function resolve_controller() {
        $match = false;
        foreach ($this->controller_patterns as $controller=>$patterns) {
            if ($match) break;
            foreach ($patterns as $pattern) {
                if ($match) break;
                $pattern_string = '';
                
                foreach ($pattern as $pattern_key=>$pattern_value) {
                
                    $pattern_needle = '~'.$pattern_value;
                    if (strpos($pattern_needle, '{') && strpos($pattern_needle, '}')) {
                    
                        $stripped_pattern = str_replace(array('{', '}'), '', $pattern_value);
                        $param_options = explode('||', $stripped_pattern);
                        $param_match = false;
                        
                        if (isset($this->url_parts[$pattern_key])) {
                            foreach ($param_options as $param_option) {
                                $data = explode(':', $param_option);
                                if ($data[0]($this->url_parts[$pattern_key])) {    
                                    $this->url_params[$data[1]] = $this->url_parts[$pattern_key];
                                    $param_match = true;
                                    break;
                                }
                            }
                        }
                        if ($param_match) $pattern_string .= $this->url_parts[$pattern_key];
                    } else {
                        $pattern_string .= $pattern_value;
                    }
                    if ($pattern_key != (sizeof($pattern)-1)) $pattern_string .= '/';
                }
                
                // if url pattern matches controller pattern, set match=true & the controller to be rendered
                if ($pattern_string == $this->url_parts_string) { 
                    $match = true;
                    $this->controller = new $controller($this->url_parts, $this->url_params, $this->payload);
                    break;
                
                // else set url_params to null and let the default controller be returned
                } else {  
                    $this->url_params = null;
                }
            }
        }
        
        // if not controller resolved handle result
        if (empty($this->controller)) {
            // if url is a subset of /api return API 404 controller
            if ($this->url_parts[0] == 'api') {
                $this->controller = new API_404_Controller($this->url_parts, $this->url_params, $this->payload);
            // else redirect the user to the front page
            } else {
                redirect('/'); 
            }
        }
        
        return true;
    }
    
    private function check_cache() {
        global $memcache;
        if (isset($memcache)) {
            $this->cache_key = "page::" . md5(http_build_query($_GET));
            $result = $memcache->get($this->cache_key);
            if ($result) return $result;
        }
        
        return false;
    }
}

// instantiate global $routes object
$routes = new Routes();

// instantiate global $memcache object
if (class_exists('Memcache') && defined('CACHE') && CACHE === true) {
    $memcache = new Memcache;
    $success = $memcache->connect('localhost', 11211);
    if (!$success) unset($memcache);
}