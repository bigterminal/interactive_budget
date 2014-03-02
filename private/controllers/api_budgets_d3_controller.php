<?
class API_Budgets_D3_Controller extends API_Controller {
    protected $response;
    protected $scale = 1000;
    
    function __construct($url_parts, $url_params, $payload) {
        parent::__construct($url_parts, $url_params, $payload);
        $this->can_cache = true;
        
        try {
            $categories = Budget_Category_Model::find_all();
            $budgets = Budget_Model::find_all();
            
            $this->response = array(
                'budget' => array(
                    'name' => 'Budget',
                    'children' => array()
                )
            );
            
            foreach ($categories as $category) {
                $category_response = array(
                    'name' => $category->get_name(),
                    'children' => array()                           
                );
                
                foreach ($budgets as $budget) {
                    if ($budget->get_category_id() == $category->get_id()) {
                        $size = (int)round($budget->get_total_2014() / $this->scale);
                        array_push($category_response['children'], array(
                            'name' => $budget->get_name(),
                            'size' => $size
                        ));
                    }
                }
                
                array_push($this->response['budget']['children'], $category_response);
            }
            
            $this->set_response_code(200);
            $this->response_contents = array(
                $this->response
            );
        } catch (Exception $e) {
            $this->set_response_code(500);
        }
    }
}