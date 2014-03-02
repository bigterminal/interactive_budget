<?
class Process_Data_Controller extends Core_Controller {
    function __construct($url_parts, $url_params, $payload) {  
        parent::__construct($url_parts, $url_params, $payload);
        
        try {  
            $this->templates = array(
                'home',
            );
            
            $html_classes = array('home');

            $this->template_data = array(
                'html_classes' => implode(' ', $html_classes),
                'site_url' => SITE_URL
            );
        } catch (Exception $e) {
            $this->set_response_code(500);  
        }
    }
}