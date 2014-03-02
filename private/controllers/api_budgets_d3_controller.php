<?
class API_Budgets_D3_Controller extends API_Controller {
    protected $response;
    protected $scale = 10000;
    
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
                        if ($size > 0) {
                            array_push($category_response['children'], array(
                                'name' => $budget->get_name(),
                                'delta' => $budget->get_delta_p_2014_2013(),
                                'size' => $size
                            ));
                        }
                    }
                }
                
                if (count($category_response['children']) > 0) {
                    array_push($this->response['budget']['children'], $category_response);
                }
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