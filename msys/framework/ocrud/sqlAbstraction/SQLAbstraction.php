<?php
/**
 * Documentation, License etc.
 *
 * @package dbAbstraction
 */

/**
* The main database interface that all database classes must adhere to.
*
* @interface sqlAbstraction
*/

interface SqlAbstraction {
  /**
  * The constructor sets the table prefix, and inital values
  *
  * @param string $tblPrefix A string of a prefix to append to table names.
  */
  public function __construct($tblPrefix = "");
  /**
  * Returns the SQL query as a string
  *
  * @return string
  */
  public function toString();

  /**
  * Creates a select query.
  *
  * @param string $cols,...$colsn Unlimited number of columns can be entered as seperate parameters
  * @return Db
  */
  public function select($cols = null);

  /**
  * Sets the tables to use in a query.
  * It also appends the prefix to each table.
  *
  * @param string $tables,... Any number of tables can be placed as seperate parameters
  * @return Db
  */
  public function from($tables);
  /**
  * Add as single column to a select query
  *
  * @param string $column The name of the column to add.
  * @param string $table Optional. The table the column is from.
  * @param string $as Optional. Set an alias for the column
  * @return Db
  */
  public function addColumn($column,$table = "", $as = "");

  /**
  * Adds one or more columns from the same table to a select query
  *
  * @param string $table The name of table to get columns from
  * @param string $column,... One or more columns as seperate parameters
  */
  public function tableColumns($table,$column);

  /**
  * Set a row limiter on a select statement
  * 
  * @param int $limit The number of rows to limit by.
  * @param int $offset An offset to start the limited number of rows selection.
  * @return Db
  */
  
  public function limit($limit,$offset);

  /**
  * Adds an order by Clause
  *
  * @param string $direction Either ASC for accending or DESC for decending order.
  * @param string $column,... one or more columns can be added, a parameter per column.
  * @return Db
  */
  public function orderBy($direction = "ASC",$column);

  /**
  * Adds a where clause, with an AND operator before it, if applicable.
  * 
  * @param string $column The name of the column.
  * @param mixed $data The value to find in the database.
  * @param string $comparator The operator to use.
  * @return Db
  */
  public function where($table,$column,$data = "");

  /**
  * Adds a where clause, with an OR operator before it, if applicable
  * 
  * @param string $column The name of the column.
  * @param mixed $data The value to find in the database.
  * @param string $comparator The operator to use.
  * @return Db
  */
  public function orWhere($table,$column,$data = "");

  /**
  * Adds a where clause, that uses the LIKE operator for comparason, with an AND operator before it, if applicable
  * 
  * @param string $column The name of the column.
  * @param mixed $data The value to find in the database.
  * @param string $wildCardPlacement If to place the % on the left, right or both sides of the supplied data.
  * @return Db
  */  
  public function like($column,$data,$wildCardPlacement);

  /**
  * Adds a where clause, that uses the LIKE operator for comparason, with an OR operator before it, if applicable
  * 
  * @param string $column The name of the column.
  * @param mixed $data The value to find in the database.
  * @param string $wildCardPlacement If to place the % on the left, right or both sides of the supplied data.
  * @return Db
  */
  public function orLike($column,$data,$wildCardPlacement);

  /**
  * Allows for multiple values to be compared for a single column. Places an AND operator after the previous
  * Item in the WHERE clause if applicable.
  *
  * @param string column  The column to place compare the values against.
  * @param string $val,... One or more values to be passed as seperate parameters after the column.
  * @return Db
  */
  public function in($column,$val);

  /**
  * Allows for multiple values to be compared for a single column. Places an OR operator after the previous
  * Item in the WHERE clause if applicable.
  *
  * @param string column  The column to place compare the values against.
  * @param string $val,... One or more values to be passed as seperate parameters after the column.
  * @return Db
  */
  public function orIn($column,$val);

  /**
  * Return results where a column has values between two provided.
  *
  * @param string $column The Column to find the range in.
  * @param string $val1 The start of the range.
  * @param string $val2 The end of the range.
  * @return Db
  */
  public function between($column,$val1,$val2);

  /**
  * Return results where a column has values that are not between two provided.
  *
  * @param string $column The Column to find the range in.
  * @param string $val1 The start of the range.
  * @param string $val2 The end of the range.
  * @return Db
  */
  public function notBetween($column,$val1,$val2);

  /**
  * Begins an INSERT Query
  *
  * @param string $table The table to insert to.
  * @param string $columns,... One or more columns to be passed as seperate parameters
  * @return Db
  */ 
  public function insert($table);

  /**
  * Sets a row of values you wish to insert into the database
  *
  * @param string $values,... An array of the values you wish to insert. They need to be in the same order as the columns set by the insert method
  * @return Db
  */
  public function values($value);
    
  /**
  * Begin an UPDATE query
  *
  * @param string $table The name of the table the update operations are being performed on.
  * @return Db
  */
  public function update($table);

  /**
  * Set the values of the columns to change. Enter the parameters as column 1,value 1,column 2,value 2, ... column n,value n
  *
  * @param string $column The name of the column to utilise
  * @param string $value The value to change on the column before hand.
  * @return Db
  */  
  public function set($column,$value);

  /**
  * Begin a DELETE query
  *
  * @param string $table The name of the table to remove data from
  */
  public function delete($table);

  /**
  * Sets the columns to match in a JOIN operation
  *
  * @param array $column1 The first column to compare with.
  * @param array $column2 The second to compare with.
  * @param string $operator The operator to use, eg =,!= etc.
  */
  public function on($column1,$column2,$operator = "=");

  /**
  * Sets an Inner JOIN
  *
  * @param string $table The table name to perform the join on.
  * @return Db
  */
  public function innerJoin($table);

  /**
  * Sets a Natural JOIN
  *
  * @param string $table The table name to perform the join on.
  * @return Db
  */
  public function naturalJoin($table);

  /**
  * Sets a cross JOIN
  *
  * @param string $table The table name to perform the join on.
  * @return Db
  */
  public function crossJoin($table);

  /**
  * Sets a left outer join JOIN
  *
  * @param string $table The table name to perform the join on.
  * @return Db
  */
  public function leftOuterJoin($table);

  /**
  * Sets a right outer join
  *
  * @param string $table The table name to perform the join on.
  * @return Db
  */
  public function rightOuterJoin($table);

  /**
  * Sets a full outer join
  *
  * @param string $table The table name to perform the join on.
  * @return Db
  */
  public function fullOuterJoin($table);

  }



