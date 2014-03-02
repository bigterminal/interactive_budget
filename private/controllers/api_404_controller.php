<?
class API_404_Controller extends API_Controller {

    function __construct($url_parts, $url_params, $payload) {
        parent::__construct($url_parts, $url_params, $payload);
        try {
            $this->set_response_code(404);
        } catch (Exception $e) {
            $this->set_response_code(500);
        }
    }
}