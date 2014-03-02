<?
class API_Budgets_Controller extends API_Controller {
    function __construct($url_parts, $url_params, $payload) {
        parent::__construct($url_parts, $url_params, $payload);
        $this->can_cache = true;
        
        try {
            $categories = Budget_Category_Model::find_all();
            $budgets = Budget_Model::find_all();
            foreach ($categories as $category) {
                $category->budgets = array();
                foreach ($budgets as $budget) {
                    if ($budget->get_category_id() == $category->get_id()) {
                        array_push($category->budgets, Budget_Model::encode_objects($budget));
                    }
                }
            }
            
            $this->set_response_code(200);
            $this->response_contents = array(
                array(
                    Budget_Category_Model::encode_objects($categories)
                )
            );
        } catch (Exception $e) {
            $this->set_response_code(500);
        }
    }
}