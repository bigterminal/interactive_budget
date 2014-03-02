<?
class API_Process_Data_Controller extends API_Controller {
    protected $source_name = 'sopa-rsap-eng.txt';
    protected $categories_data = array();
    protected $budgets_data = array();
    protected $categories_processed = 0;
    protected $budgets_processed = 0;
    
    function __construct($url_parts, $url_params, $payload) {
        parent::__construct($url_parts, $url_params, $payload);
        try {
            if (MODE != 'PRODUCTION') {
                $this->parse_data();
                $this->process_data();
                $this->set_response_code(200);
                $this->response_contents = array(
                    array(
                        'categories_processed' => $this->categories_processed,
                        'budgets_processed' => $this->budgets_processed
                    )
                );
            } else {
                $this->set_response_code(403);
            }
        } catch (Exception $e) {
            $this->set_response_code(500);
        }
    }
    
    function parse_data() {
        $raw_data = file_get_contents(DATA_PATH.$this->source_name);
        $data = mb_convert_encoding($raw_data, 'HTML-ENTITIES', 'UTF-8');
        $lines = preg_split('/((\r?\n)|(\r\n?))/', $data);
        
        $new_category = true;
        $current_category = null;
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            array_pop($parts);
            
            if (count($parts) == 4) {
                if ($new_category) {
                    array_push($this->categories_data, $parts[0]);
                    $current_category = count($this->categories_data) - 1;
                    $new_category = false;
                } else {
                    if ($parts[0] == null && $parts[1] == null && $parts[2] == null && $parts[3] == null) {
                        $new_category = true;
                    } else {
                        if ($parts[0] != 'Total' && ($parts[1] != null && $parts[2] != null && $parts[3] != null)) {
                            $budget = array(
                                $current_category + 1,
                                $parts[0],
                                $parts[1],
                                $parts[2],
                                $parts[3]
                            );
                            array_push($this->budgets_data, $budget);
                        }
                    }
                }
            }
        }
    }
    
    function process_data() {
        $this->clear_data();
        
        foreach ($this->categories_data as $key=>$value) {
            $category = new Budget_Category_Model();
            $category->set_name($value);
            if ($category->save()) $this->categories_processed++;
        }
        
        foreach ($this->budgets_data as $value) {
            if (count($value) == 5) {
                $budget = new Budget_Model();
                $budget->set_category_id($value[0]);
                $budget->set_name($value[1]);
                $budget->set_total_2012($value[2]);
                $budget->set_total_2013($value[3]);
                $budget->set_total_2014($value[4]);
                $budget->set_delta_p_2014_2012();
                $budget->set_delta_v_2014_2012();
                $budget->set_delta_p_2014_2013();
                $budget->set_delta_v_2014_2013();
                if ($budget->save()) $this->budgets_processed++;
            }
        }
    }
    
    function clear_data() {
        global $database;
        $database->query('SET FOREIGN_KEY_CHECKS=0;');
        $database->query('TRUNCATE budget_categories');
        $database->query('TRUNCATE budgets');
        $database->query('SET FOREIGN_KEY_CHECKS=1;');
    }
}