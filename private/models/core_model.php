<?
class Core_Model {
    protected static $table_name;
    protected static $db_fields;
    protected static $ignored_attributes;
    
    function __construct() {
    
    }
    
    public static function get_table_name() {
        return static::$table_name;
    }
    
    public static function get_db_fields() {
        return static::$db_fields; 
    }
    
    /*
    * converts this object into an array
    * never directly called
    * called from ::encode_objects($objects)
    * 
    * @return: $array representation of $this
    */
    function make_array() {  
        $array = get_object_vars($this); 
        foreach($array as &$value) {
            if(is_object($value) && method_exists($value,'make_array')) {
                $value = $value->make_array();
            }
        }
        
        return $array;
    }
    
    /*
    * format and encode models into data structures
    *
    * @param $objects: objects to be encoded
    * @param $json_encode[false]: if objects should be encoded into json or not
    * @param $key[null]: key of wrapping arra
    * @return: encoded $data of $objects
    */
    public static function encode_objects($objects, $json_encode = false, $key = null) {  
        if (!is_array($objects)) $objects = array($objects);
        
        $data = array();
        foreach ($objects as $object) {
            if(is_object($object) && method_exists($object,'make_array')) {
                if (!empty($key)) {
                    $data[$key][] = $object->make_array($object); 
                } else {
                    $data[] = $object->make_array($object);
                }
            }
        }
        
        if ($json_encode) {
            return json_encode($data);
        }
        
        return $data;
    }
    
    /*
    * counts all records of model type
    *
    * @return: (int)query count
    */
    public static function count_all() {   
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$table_name;
        $result = $database->fetch_array($database->query($sql));
        
        return $result[0];
    }
    
    /*
    * find records of model type by sql
    *
    * @param $sql: SQL to be queried
    * @return: $object_array of query result
    */
    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        
        $object_array = array();  
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);  
        }
        
        return $object_array; 
    }
    
    /*
    * find all records of model type
    *
    * @return: $object_array of query result
    */
    public static function find_all() { 
        return static::find_by_sql("SELECT * FROM ".static::$table_name);
    }
    
    /*
    * find records of model type by id
    *
    * @param $id: if of model record to be queried
    * @return: $object_array of query result
    *          false if not found
    */
    public static function find_by_id($id = null) {
        if (is_null($id)) return false;
        $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id = {$id} LIMIT 1");  
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    /*
    * instantiate model from query record
    *
    * @param $record: MySQL result record to be instantiated
    * @return: instantiated $object
    */
    protected static function instantiate($record) { 
        $class_name = get_called_class();
        $object = new $class_name;
        
        foreach($record as $attribute=>$value) {
            if($object->has_attribute($attribute)) {
                if (is_numeric($value)) {
                    if (is_int($value)) {
                        $object->$attribute = (int)$value;
                    } else {
                        $object->$attribute = (float)$value; 
                    }
                } else {
                    if ($value == null) {
                        $object->$attribute = 'null';
                    } else {
                        $object->$attribute = $value;
                    }
                }
            }
        }
        
        return $object;
    }
    
    /*
    * check if this model has attribute
    *
    * @param $attribute: attribute to check existance
    * @return: true or false if exists
    */
    private function has_attribute($attribute) {
        $object_vars = $this->attributes(); 
        return array_key_exists($attribute, $object_vars);     
    }
    
    /*
    * fetches all attributes of model type
    *
    * @return: array of model type $attributes
    */
    protected function attributes($skip_ignored = true) { 
        $attributes = array();
        foreach(static::$db_fields as $field) {
            if ($skip_ignored || !in_array($field, static::$ignored_attributes)) {
                if(property_exists($this, $field)) $attributes[$field] = $this->$field;
            }      
        }
        
        return $attributes;
    }
    
    /*
    * sanitize attributes of model type
    *
    * @return: sanitized array of $clean_attributes
    */
    protected function sanitized_attributes($skip_ignored = true) { 
        global $database;
        $clean_attributes = array();
        
        foreach($this->attributes($skip_ignored) as $key => $value) {
            if (is_null($value)) {
                $clean_attributes[$key] = null;
            } else {
                $clean_attributes[$key] = $database->escape_value($value);
            }
        }
        
        return $clean_attributes;
    }
    
    /*
    * save model as record
    *
    * @return: if isset($this->id) $this->update()
    *          else $this->create()
    */
    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }
    
    /*
    * create record of model instance
    *
    * @return: true if created
    *          false if not created
    */
    public function create() { 
        global $database;
        $attributes = $this->sanitized_attributes(false);
        
        $sql  = "INSERT INTO " . static::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES (";
        
        foreach ($attributes as $key => $attribute) {  
            if (is_null($attribute)) {  
                $attributes[$key] = 'null'; 
            } else {
                $attributes[$key] = "'" . $attributes[$key] . "'"; 
            }
        }
        
        $sql .= join(", ", array_values($attributes));
        $sql .= ")";
        
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true; 
        }
        
        return false;
    }
    
    /*
    * update record of model instance
    *
    * @return: true if updated
    *          false if not updated
    */
    public function update() { 
        global $database;
        $attributes = $this->sanitized_attributes(false);
        
        foreach($attributes as $key => $value) {   
            if (is_null($value)) {
                $attributes_pairs[] = "{$key}=null";
            } else {
                $attributes_pairs[] = "{$key}='{$value}'";
            }
        }
        
        $sql  = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(", ", $attributes_pairs);
        $sql .= " WHERE id=" . $database->escape_value($this->id);
        $database->query($sql);
        
        return ($database->affected_rows() == 1) ? true : false;
    }
    
    /*
    * delete record of model instance
    *
    * @return: true if deleted
    *          false if not deleted
    */
    public function delete() { 
        global $database;
        $sql  = "DELETE FROM " . static::$table_name;
        $sql .= " WHERE id='" . $database->escape_value($this->id);
        $sql .= "' LIMIT 1";
        $database->query($sql);
        
        return ($database->affected_rows() == 1) ? true : false; 
    }

}