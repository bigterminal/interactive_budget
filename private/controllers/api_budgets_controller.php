<?
class API_Budgets_Controller extends API_Controller {
    protected $total_2012 = 0;
    protected $total_2013 = 0;
    protected $total_2014 = 0;
    
    function __construct($url_parts, $url_params, $payload) {
        parent::__construct($url_parts, $url_params, $payload);
        $this->can_cache = true;
        
        try {
            $categories = Budget_Category_Model::find_all();
            $budgets = Budget_Model::find_all();
            foreach ($categories as $category) {
                $category->total_2012 = 0;
                $category->total_2013 = 0;
                $category->total_2014 = 0;
                
                $category->budgets = array();
                foreach ($budgets as $budget) {
                    if ($budget->get_category_id() == $category->get_id()) {
                        $category->total_2012 += $budget->get_total_2012();
                        $category->total_2013 += $budget->get_total_2013();
                        $category->total_2014 += $budget->get_total_2014();
                        array_push($category->budgets, Budget_Model::encode_objects($budget));
                    }
                }
                
                $this->total_2012 += $category->total_2012;
                $this->total_2013 += $category->total_2013;
                $this->total_2014 += $category->total_2014;
            }
            
            $this->set_response_code(200);
            $this->response_contents = array(
                'total_2012' => $this->total_2012,
                'total_2013' => $this->total_2013,
                'total_2014' => $this->total_2014,
                'categories' => Budget_Category_Model::encode_objects($categories)
            );
        } catch (Exception $e) {
            $this->set_response_code(500);
        }
    }
}