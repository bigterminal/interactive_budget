<?
class MySQL_Database {
    private $connection;
    private $magic_quotes_active;
    private $real_escape_string_exists;

    public $last_query;
    
    /*
    * on __construct() of MySQL_Database
    *   open database connection
    *   set magic quote
    *   check if the real escapestring method exists
    */
    function __construct() {
        $this->open_connection();
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->real_escape_string_exists = function_exists("mysql_real_escape_string");
    }
    
    /*
    * on __destruct() of MySQL_Database
    *   close database connection
    */
    function __destruct() {
        $this->close_connection();
    }
    
    /*
    * open MySQL database connection
    *
    * @return: true if connection opened,
    *          else die({message}) - verbose if DEBUG = true
    */
    public function open_connection() {  
        $this->connection = mysql_pconnect(DB_HOST, DB_USER, DB_PASS);
        
        if (!$this->connection) { 
            if (DEBUG) {
                die("Database connection failed: " . mysql_error());
            } else { 
                die("Database connection failed");
            }
        } else { 
            $db_select = mysql_select_db(DB_NAME, $this->connection);
            
            if (!$db_select) {
                if (DEBUG) {
                    die("Database selection failed: " . mysql_error());
                } else {
                    die("Database selection failed");
                }
            }  
        }
        return true;
    }
    
    /*
    * close MySQL database connection
    *
    * @return: true if connection close
    *          false if $this->connection !isset
    */
    public function close_connection() {
        return true; // using mysql_pconnect
        
        if (isset($this->connection)) {  
            mysql_close($this->connection);
            unset($this->connection);
            return true;
        } 
        return false;
    }
    
    /*
    * query MySQL database & confirm result
    *
    * @param: $sql
    * @return: query $result
    */
    public function query($sql) {
        $this->last_query = $sql;
        $result = mysql_query($sql, $this->connection);
        $this->confirm_query($result);
        
        return $result;
    }
    
    /*
    * escape values before including in a query
    *
    * @param: $value
    * @return: sanitized $value
    */
    public function escape_value($value) {
        if ($this->real_escape_string_exists) {
            $value = ($this->magic_quotes_active) ? stripslashes($value) : $value;
            $value = mysql_real_escape_string($value);
        } else {
            $value (!$this->magic_quotes_active) ? addslashes($value) : $value;   
        }  
        return $value;
    }
    
    /*
    * fetch array from result
    *
    * @param: $result_set
    * @return: mysql_fetch_array($result_set)
    */
    public function fetch_array($result_set) {
        return mysql_fetch_array($result_set);	
    }
    
    /*
    * fetch number of affected rows from result
    *
    * @param: $result_set
    * @return: mysql_num_rows($result_set)
    */
    public function num_rows($result_set) {
        return mysql_num_rows($result_set);
    }
    
    /*
    * insert id on this connection
    *
    * @return: mysql_insert_id($this->connection)
    */
    public function insert_id() {
        return mysql_insert_id($this->connection);	
    }
    
    /*
    * fetch affected rows from this connection
    *
    * @return: mysql_affected_rows($this->connection)
    */
    public function affected_rows() {
        return mysql_affected_rows($this->connection);	 
    }
    
    /*
    * confirms a results query
    *
    * @param: $result
    * @return true if result is good
    *         false if result is not good
    *           if DEBUG = true output debug info
    */
    private function confirm_query($result) {
        if (!$result) {
            if (DEBUG) {     
                $output = "Database query failed: " . mysql_error();
                $output .= "<br /><br />Last SQL query: " . $this->last_query;   
                print $output;   
            }
            return false;
        }
        return true;
    }
}

// instantiate global $database object
$database = new MySQL_Database();