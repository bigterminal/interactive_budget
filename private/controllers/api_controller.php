<?
class API_Controller extends Core_Controller {    
    protected $request_method;
    protected $response_code;
    protected $response_message;
    protected $response_contents;
    protected $response_headers;
    
    /*
    * __construct API_Controller
    *
    * @param $url_parts: exploded (around '/'s) request url parts
    * @param $url_params: dynamic request url paramater parts (key value array)
    * @param $payload: request data payload
    */
    function __construct($url_parts, $url_params, $payload) {
        parent::__construct($url_parts, $url_params, $payload);
        $this->can_cache = false;
        
        try {
            $this->request_method = $_SERVER['REQUEST_METHOD'];
            $this->response_contents = array();
            $this->set_response_code(503);
            $this->response_headers = array(
                'Cache-Control: no-cache, must-revalidate',
                'Content-type: application/json'
            );
        } catch (Exception $e) {
            $this->set_response_code(500);  
        }
    }
    
    /*
    * render API_Controller's response
    *
    * @display: JSON encoded API response
    * @return: true
    */
    public function render() {
        try { 
            $response = array(
                'requested' => $this->request_method.' /'.implode('/', $this->url_parts),
                'response' => array(
                    'code' => $this->response_code,
                    'message' => $this->response_message,
                    'contents' => $this->response_contents
                )
            );
            
            foreach ($this->response_headers as $header) {
                header($header);
            }
            
            return json_encode(array_remove_empty($response));
        
        } catch (Exception $e) {
            if (DEBUG) {
                throw new Exception('Something went wrong', 0, $e);
            } else {
                die('Something went wrong');
            }
        }
        
        return false;
    }
    
    /*
    * set API_Controller's response code
    *
    * @param $code: code id to set for response
    * @param $message: optional override response message
    *
    * @return: true
    */
    protected function set_response_code($code, $message = null) {
        switch ($code) {
            case(200):
                $this->response_code = 200;
                $this->response_message = 'Success';
                break;
            
            case(201):
                $this->response_code = 201;
                $this->response_message = 'Created';
                break;
            
            case(204):
                $this->response_code = 204;
                $this->response_message = 'No Content';
                break;
            
            case(400):
                $this->response_code = 400;
                $this->response_message = 'Bad Request';
                break;
            
            case(403):
                $this->response_code = 403;
                $this->response_message = 'Forbidden';
                break;
            
            case(404):
                $this->response_code = 404;
                $this->response_message = 'Not Found';
                break;
            
            case(500):
                $this->response_code = 500;
                $this->response_message = 'Internal Server Error';
                break;
            
            case(501):
                $this->response_code = 501;
                $this->response_message = 'Not Implemented';
                break;
            
            case(503):
                $this->response_code = 503;
                $this->response_message = 'Service Unavailable';
                break;
        }
        
        if (!empty($message)) {
            $this->response_message = $message;
        }
        
        return true;
    }
}