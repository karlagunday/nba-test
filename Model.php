<?php
include 'include/utils.php';

class Model {
    protected static $_fields = array();
    protected static $_tableName;
    private static $_mysqli_db;
    protected static $_idField;

    public function __construct($data) {
        $this->set($data);
    }

    public function set(array $data) {
        if(isset($data) && is_array($data)){
            foreach ($data as $property => $value){
                if(in_array($property, static::$_fields)){
                    $this->$property = $value;
                }
            }

            return $this;
        }

        return null;
    }



    public static function add_fields(...$fields) {
        if(is_array($fields)){
            static::$_fields = array_merge(static::$_fields, $fields);
        }
    }

    public static function search($search) {
        if(!is_array($search)){
            $search = array(
                static::$_idField => $search
            );
        }

        $where_parts = [];

        foreach(static::$_fields as $field){
            if(isset($search[$field])){
                $where_parts[] = "$field ='" . addslashes($search[$field]) . "'";
            }
        }

        $where = implode(' AND ', $where_parts);

        $fields = implode(',', static::$_fields);
        $sql = "
            SELECT
                $fields
            FROM
                " . static::$_tableName . "
            WHERE
              $where     
        ";


        $results = self::query($sql);

        $collection  = array();

        if(is_array($results)){
            foreach ($results as $result) {
                $player = new static($result);
                $collection[] = $player;
            }
        }

        //die(var_dump($collection));

        return $collection;


    }

    public function save() {
        $sql_parts = array();

        if(isset($this->{static::$_idField})){
            foreach(static::$_fields as $field){
                if(isset($this->$field)){
                    $sql_parts[] = "$field = '" . addslashes($this->$field) . "'";
                }
            }

            $sql = "
                UPDATE
                    " . static::$_tableName . "
                SET
                    " . implode(',', $sql_parts) . "
            ";
        }
        else{
            $this->{static::$_idField} = rand(0, 9999);

            foreach(static::$_fields as $field){
                if(isset($this->$field)){
                    $sql_parts[] = "'" . addslashes($this->$field) . "'";
                }
            }

            $sql = "
                INSERT INTO
                    " . static::$_tableName . "
                    (" . implode(', ', static::$_fields) . ")
                VALUES
                    (" . implode(',', $sql_parts) . ")
            ";
        }

        //die(var_dump($sql));

        if(!$this->query($sql)){
            return null;
        }

        return $this;
    }

    public function retrieve($id) {
        if(isset($id)){
            $fields = implode(',', static::$_fields);
            $sql = "
                SELECT
                    $fields
                FROM
                    " . static::$_tableName . "
                WHERE
                  " . static::$_idField . " = '" . addslashes($id) . "'
                LIMIT 1        
            ";
            //var_dump($sql);
            $result = $this->query($sql);

            //var_dump($result);

            if(is_array($result) && isset($result[0])){
                foreach(static::$_fields as $field){
                    $this->$field = $result[0][$field];
                }
            }
        }

        return $this;
    }

    public function delete($id) {
        if(isset($id)){
            $sql = "
                DELETE
                FROM
                  " . static::$_tableName . "
                WHERE 
                  " . static::$_idField . " = '" . addslashes($id) . "'          
            ";

            if(!$this->query($sql)){
                return null;
            }
        }

        return $this;
    }

    public static function get($id) {
        $result = static::search($id);
        return isset($result[0]) ? $result[0] : null;
    }

    public function describe() {
        return '';
    }

    /**
     * Execute a query & return the resulting data as an array of assoc arrays
     * @param string $sql query to execute
     * @return boolean|array array of associative arrays - query results for select
     *     otherwise true or false for insert/update/delete success
     */
    protected static function query($sql) {
        if(!self::$_mysqli_db){
            self::$_mysqli_db = new mysqli('localhost', 'root', '', 'nba');
        }
        $result = self::$_mysqli_db->query($sql);
        if (!is_object($result)) {
            return $result;
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * Debug method - dumps a print_r of any passed variables and exits
     * @param mixed any number of variables you wish to inspect
     */
    private function dump() {
        $args = func_get_args();
        global $noexit;
        foreach ($args as $arg) {
            $out = print_r($arg, 1);
            echo '<pre>' . $out . '</pre><hr />';
        }
        if (!$noexit) {
            $bt = debug_backtrace();
            exit('<i>Called from: ' . $bt[0]['file'] . ' (' . ($bt[1]['class'] ? $bt[1]['class'] . ':' : '') . $bt[1]['function'] . ')</i>');
        }
    }

}