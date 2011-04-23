<?php

require_once("sqlAbstraction/standard.php");

/**
 * @package Crud
 */
class Crud {
    const SINGLE = 0;

    const MULTI = 1;

    const PAGINATE = 2;

    const ROWCOUNT = 3;

    static private $instance;
    public $db;
    private $tables;
    private $dbType;
    private $tablePrefix;
    private $mode;
    private $query;
    private $whereData; //used for prepared statements to ensure escaped data

    /**
     *
     * @param PDO $dbPDO
     * @param string $username
     * @param string $password
     */

    private function __construct($dbPDO, $username=null, $password=null) {
        $this->mode = PDO::FETCH_BOTH;
        if ($dbPDO instanceof PDO) {

            $this->db = $dbPDO;
        } else if (is_string($dbPDO)) {
            // assumes input is dsn.
            if ($username == null or $password == null) {

                throw new Exception("Username and password can not be null!");
            }

            $this->db = new PDO($dbPDO, $username, $password);
        } else {


            throw new Exception("First argument is invalid");
        }

        $this->dbType = $this->db->getAttribute(PDO::ATTR_DRIVER_NAME);

        $this->tablePrefix = "";
    }

    public function setPrefix($value) {

        $this->tablePrefix = $value;
    }

    /**
     *
     * @param PDO|string $dbPDO
     * @param string $username
     * @param string $password
     * @return Crud
     */
    static public function instance($dbPDO=null, $username=null, $password=null) {
        if (self::isInitialised()) {
            return Crud::$instance;
        } else {
            if ($dbPDO == null) {
                throw new Exception("You are required to provide a DSN string or a PDO instance for the first argument.");
            } else {
                self::$instance = new self($dbPDO, $username, $password);
                return Crud::$instance;
            }
        }
    }

    static private function isInitialised() {

        $result = (Crud::$instance instanceof self ? true : false);

        return $result;
    }

    public function setTable($name, $rows) {

        $this->tables[] = array(
            'name' => $rows
        );
    }

    public function create($mode, $table, $columns, $data) {

        $aliases = array();

        $newData = array();

        switch ($mode) {

            case 0:
                
                $i = 0;

                foreach($data as $vals) {
                    
                    $alias =":vals_$i";

                    $aliases[] = $alias;

                    $newData[$alias] = $vals;

                    $i++;
                    
                }

                $query = $this->getSQLClass();

                $query->insert($table,$columns)->values($aliases);

                break;

            case 1:
                
                $i = 0;$j=0;

                $query = $this->getSQLClass();

                $query->insert($table, $columns);

                foreach ($data as $vals) {

                    foreach ($data as $values) {
                        
                        $alias = ":vals_$ix$j";

                        $aliases[] = $alias;

                        $newData[$alias] = $values;

                        $j++;

                    }

                    $query->values($aliases);

                    $aliases = array();

                    $i++;

                    $j=0;
                    
                }

                break;
        }
        $sql = $query->toString();

        $st = $this->db->prepare($sql);

        return $st->execute($newData);

        
    }

    /**
     *
     * @param int $mode
     * @param array|string $tables
     * @param array $columns
     * @param array $limiters
     * @param array $orderBy
     * @param int $page
     * @param int $numResults
     * @return <type>
     */
    public function read($mode, $tables, $columns = null, $limiters = null, $orderBy = null, $page = 1, $limit = 10) {

        $this->whereData = array();

        $this->query = $this->getSQLClass();

        $this->query->select($columns)->from($tables);

        if ($limiters !== null) {
            $this->setWheres($limiters);
        }
    
        if ($orderBy !== null) {
            if (isset($orderBy[1])) {

              $this->query->orderBy($orderBy[0],$orderBy[1]);
               }
            else {
              $this->query->orderBy($orderBy[0],"ASC");
            }
        }
        switch ($mode) {

            case 0:

                // Single row fetch for search.
                $sql = $this->query->toString();
                
                $st = $this->db->prepare($sql);

                $results = $st->execute($this->whereData);

                if (!$results) {

                    $dbErr = $st->errorInfo();
                    $error .= "There is an database execution error:";
                    $error .= $dbErr[2];
                    $error .= ". <br />";
                    $error .= "This occured when executing <br />\n" . $sql;
                    echo $error;
                    //throw new Exception($error);
                    
                } else {

                    return $st->fetch($this->mode);
                }

                break;

            case 1:
                // multiple row fetch for search.
                $sql = $this->query->toString();
                
                $st = $this->db->prepare($sql);

                $results = $st->execute($this->whereData);

                if (!$results) {
                    
                    $dbErr = $st->errorInfo();
                    $error = "There is an database execution error:";
                    $error .= $dbErr[2];
                    $error .= ". <br />";
                    $error .= "This occured when executing <br />\n" . $sql;

                    throw new Exception($error);
                    
                } else {

                    return $st->fetchAll($this->mode);
                }

            case 2:

                if ($page <= 0) {
                    $page = 1;
                    
                }

                $offset = ($page -1) * $limit;

                $this->query->limit($limit, $offset);

                $sql = $this->query->toString();

                $st = $this->db->prepare($sql);


                $results = $st->execute($this->whereData);

                if (!$results) {

                    throw new Exception($st->errorInfo());

                    } else {

                    return $st->fetchAll($this->mode);
                }

                break;

            case 3:

                $statement = $this->query->toString();

                $st = $this->db->prepare($statement);

                $st->execute($this->whereData);

                if ($st) {

                    return count($st->fetchAll());
                } else {

                    throw new Exception("There was a database error, we do appologise.");
                }

                break;
        }
    }

    private function setWheres($limiters) {

        if (is_array($limiters)) {

            foreach ($limiters as $where) {

                if (isset($where[3])) {

                    switch ($where[3]) {

                        case "OR":
                            
                            $this->whereData[":where_{$where[0]}"] = $where[2];

                            $this->query->orWhere($where[0], ":where_" . $where[0], $where[1]);

                            break;

                        case "AND":

                            $this->whereData[":where_{$where[0]}"] = $where[2];

                            $this->query->where($where[0], ":where_" . $where[0], $where[1]);

                            break;
                    }
                } else {

                    $this->whereData[":where_{$where[0]}"] = $where[2];

                    $this->query->orWhere($where[0],":where_" . $where[0], $where[1]);
                }
            }
        }
    }

    public function update($table, $data, $where) {

        $this->whereData = array();
    
        $this->query = $this->getSQLClass();

        $this->query->update($table);
        
        $setData = array();

        foreach ($data as $key => $value) {

            $val = ":update_$key";

            $setData[$val] = $value;

            $this->query->set($key, $val);

        }
        
        $this->setWheres($where);

        $sql = $this->query->toString();

        $st = $this->db->prepare($sql);
        
        $filters = array_merge($setData,  $this->whereData);
        
        return $st->execute($filters);

    }

    public function delete($table, $where) {

        $this->whereData = array();

        $this->query = $this->getSQLClass();

        $this->query->delete($table);

        $this->setWheres($where);


        $sql = $this->query->toString();
        
        $st = $this->db->prepare($sql);

        return $st->execute($this->whereData);

    }

    public function getSQLClass() {

        switch ($this->dbType) {

            case "mysql":

                require_once "sqlAbstraction/mysql.php";

                return new SQLMySQL($this->tablePrefix);

                break;

            default:

                return new SQLStandard($this->tablePrefix);

                break;
        }
    }

    public function setReturnMode($mode) {

        $this->mode = $mode;
    }

}
?>
