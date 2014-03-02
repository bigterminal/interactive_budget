<?
class Budget_Category_Model extends Core_Model {
    protected static $table_name = 'budget_categories';
    protected static $db_fields = array(
        'id',
        'name'
    );
    
    protected static $ignored_attributes = array();
    
    protected $id;
    protected $name;
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function set_name($value) {
        $this->name = $value;
    }
}