<?
class Budget_Model extends Core_Model {
    protected static $table_name = 'budgets';
    protected static $db_fields = array(
        'id',
        'category_id',
        'name',
        'total_2012',
        'total_2013',
        'total_2014',
        'delta_p_2014_2012',
        'delta_v_2014_2012',
        'delta_p_2014_2013',
        'delta_v_2014_2013'
    );
    
    protected static $ignored_attributes = array();
    
    protected $id;
    protected $category_id;
    protected $category_name;
    protected $name;
    protected $total_2012;
    protected $total_2013;
    protected $total_2014;
    protected $delta_p_2014_2012;
    protected $delta_v_2014_2012;
    protected $delta_p_2014_2013;
    protected $delta_v_2014_2013;
    
    function __construct() { 
        parent::__construct();
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_category_id() {
        return $this->category_id;
    }
    
    public function set_category_id($value) {
        $this->category_id = $value;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function set_name($value) {
        $this->name = $value;
    }
    
    public function get_total_2012() {
        return $this->total_2012;
    }
    
    public function set_total_2012($value) {
        $this->total_2012 = $value;
    }
    
    public function get_total_2013() {
        return $this->total_2013;
    }
    
    public function set_total_2013($value) {
        $this->total_2013 = $value;
    }
    
    public function get_total_2014() {
        return $this->total_2014;
    }
    
    public function set_total_2014($value) {
        $this->total_2014 = $value;
    }
    
    public function get_delta_p_2014_2012() {
        return $this->delta_p_2014_2012;
    }
    
    public function set_delta_p_2014_2012() {
        if (isset($this->total_2014) && isset($this->total_2012)) {
            $this->delta_p_2014_2012 = $this->percent_different($this->total_2014, $this->total_2012);
        }
    }
    
    public function get_delta_v_2014_2012() {
        return $this->delta_v_2014_2012;
    }
    
    public function set_delta_v_2014_2012() {
        if (isset($this->total_2014) && isset($this->total_2012)) {
            $this->delta_v_2014_2012 = $this->value_difference($this->total_2014, $this->total_2012);
        }
    }
    
    public function get_delta_p_2014_2013() {
        return $this->delta_p_2014_2013;
    }
    
    public function set_delta_p_2014_2013() {
        if (isset($this->total_2014) && isset($this->total_2013)) {
            $this->delta_p_2014_2013 = $this->percent_different($this->total_2014, $this->total_2013);
        }
    }
    
    public function get_delta_v_2014_2013() {
        return $this->delta_v_2014_2013;
    }
    
    public function set_delta_v_2014_2013() {
        if (isset($this->total_2014) && isset($this->total_2013)) {
            $this->delta_v_2014_2013 = $this->value_difference($this->total_2014, $this->total_2013);
        }
    }
    
    function value_difference($value1, $value2) {
        return $value1 - $value2;
    }
    
    function percent_different($value1, $value2) {
        return ($value2 == 0) ? null : ($this->value_difference($value1, $value2) / $value2) * 100;
    }
}