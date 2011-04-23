<?php
require_once("standard.php");

class SQLMySQL extends SQLStandard  {

  /**
  * Returns the SQL query as a string
  *
  * @return string
  */
  public function toString() {

    switch($this->queryType) {
    
      case "SELECT":
	return $this->genSelect();
	
      case "UPDATE":
	return $this->genUpdate();
	
      case "INSERT":
	return $this->genInsert();

      case "DELETE":
	return $this->genDelete();

      break;

      }

    }

  /**
  * Generate a SELECT query.
  *
  * @return string
  */
  protected function genSelect() {

    $orderBy = $this->genOrderBy();
    
    $limit = $this->genLimit();

  
    if (array($this->tables)) {

      $tables = implode(",",$this->tables);

      }
    
    if (!empty($this->columnSelect)) {

        $columns = implode(",", $this->columnSelect);

    }

    else {

        $columns = "*";

    }

    $wheres = $this->genWheres();

    $joinStuff = $this->genJoins();

    $join = $joinStuff[0];

    $on = $joinStuff[1];

    $query = "SELECT $columns FROM $tables $join $on $wheres $orderBy $limit";

    return $query;

    }

  /**
  * Sets a full outer join. This has to be reimplemented in this 
  * class since MySQL does not support full outer joins.
  *
  * @param string $table The table name to perform the join on.
  * @return DbStandard
  */
  public function fullOuterJoin($table) {

    if ($this->queryType != "SELECT") {

      throw new Exception("You can not add a join to a(n) {$this->queryType} statement");

      }

    throw new Exception("MySQL does not currently support full outer joins.");

    }

  /**
  * Used to overide the SQL generation of limits for the MySQL own scheme
  *
  * @return string
  */
  protected function genLimit() {
    $limit = "";
    if (is_array($this->limits)) {

	switch(count($this->limits)) {

	  case 1:

	      $lim = $this->limits[0];

	      $limit = "LIMIT $lim";

	    break;

	  case 2:

	      $lim = $this->limits[0];

	      $offset = $this->limits[1];

	      $limit = "LIMIT $lim OFFSET $offset";

	    break;

	  default:

	    //falls silently for now
	      $limit = "";
	    break;

	  }

      }
    return $limit;
    }

  }

?>