<?php

class EasyDB {
	
	private $host;
	private $user;
	private $password;
	private $dbname;
	private $mysql;
	private $sql;
	public $pdo;
	
	function EasyDB($config, $pdo = false) {
		
		$this->host = $config['host'];
		$this->user = $config['user'];
		$this->password = $config['password'];
		$this->dbname = $config['dbname'];
		$this->pdo = $pdo;		
	}
	
	function setPDO($pdo) {
		
		$this->pdo = $pdo;
	}
	
	function openDB() {
		
		$this->mysql = mysql_connect($this->host, $this->user, $this->password);
		
		mysql_select_db($this->dbname, $this->mysql);		
		
	}
	
	function closeDB() {
		
		mysql_close($this->mysql);
	}
	
	function createDB($dbname) {
		
		$this->openDB();	
		
		$dbname = mysql_real_escape_string($dbname);
		
		$result = mysql_query("CREATE DATABASE IF NOT EXISTS $dbname",$this->mysql) or die( mysql_error() );
		
		$this->closeDB();
		return $result;
	}
	
	function dropTable($tablename) {
		
		$this->openDB();	
		
		$tablename = mysql_real_escape_string($tablename);
		
		$result = mysql_query("DROP TABLE IF EXISTS $tablename",$this->mysql) or die( mysql_error() );		
		
		$this->closeDB();
		return $result;
	}	
	
	function useDB($dbname) {

		$this->dbname = mysql_real_escape_string($dbname);
	}
	
	function createTable($tablename, $columns) {
		
		$this->openDB();
		$tablename = mysql_real_escape_string($tablename);
		
		$column_string = '';
		
		if( is_array($columns) ) {
			
			$escaped_columns = array();
			
			foreach($columns as $column => $type) {
				
				$escaped_columns[] = '`'.mysql_real_escape_string($column).'`' . ' ' . $type;
			}
						
			$column_string = '(' . implode(', ',$escaped_columns) . ')';
			
		}
		
		$this->sql = "CREATE TABLE $tablename $column_string";
		
		$result = mysql_query( $this->sql ) or die( mysql_error() );
		
		$this->closeDB();
		
		return $result;		
		
	}
	
	function tableExists($tablename) {
		
		$this->openDB();
		
		$tablename = mysql_real_escape_string($tablename);
		
		$this->sql = "SHOW TABLES LIKE '$tablename'";
		
		$result = mysql_query( $this->sql ) or die( mysql_error() );
		
		$return = false;
		
		if(mysql_num_rows($result) > 0 ) {
			
			$return = true;
		}
		$this->closeDB();	
		
		return $return;
		
	}
	
	
	function selectOne($columns, $tablename, $wheres = NULL, $order = NULL) {

		$this->openDB();
		$tablename = mysql_real_escape_string($tablename);
		$column_string = '';
		$where_string = '';
		
		
		/* HANDLE COLUMNS */
		if( is_array($columns) ) {
			$escaped_columns = array();
			
			foreach($columns as $column) {
				
				$escaped_columns[] = '`'.mysql_real_escape_string($column).'`';
			}
			
			$column_string = implode(', ',$escaped_columns);
			
		}
		else{
			 
			 $column_string = mysql_real_escape_string($columns);
		}
		/* END HANDLE COLUMNS */
		
		/* HANDLE WHERES */
		
		$this->sql = "SELECT $column_string FROM $tablename";
		
		if(isset($wheres) && is_array($wheres) ) {
			
			$escaped_where = array();
			
			foreach($wheres as $column => $value) {
				
				$escaped_where[] = '(' . '`'.mysql_real_escape_string($column).'`' . ' = "' .mysql_real_escape_string($value) . '")';
			}
			$where_string = implode(' AND ', $escaped_where);
			
			$this->sql .= " WHERE $where_string";
		}
		
		/* END HANDLE WHERES */
				
		
		if(isset($order)) {
		
			$order = mysql_real_escape_string($order);
			$this->sql.= " ORDER BY $order";
		}
		
		//echo $this->sql;
		
		$result = mysql_query( $this->sql ) or die( mysql_error() );
		
		$this->closeDB();
		
		return mysql_fetch_assoc($result);
	}
	


	function selectAll($columns, $tablename, $wheres = NULL, $order = NULL) {

		$this->openDB();
		$tablename = mysql_real_escape_string($tablename);
		$column_string = '';
		$where_string = '';
		
		
		/* HANDLE COLUMNS */
		if( is_array($columns) ) {
			$escaped_columns = array();
			
			foreach($columns as $column) {
				
				$escaped_columns[] = '`'.mysql_real_escape_string($column).'`';
			}
			
			$column_string = implode(', ',$escaped_columns);
			
		}
		else{
			 
			 $column_string = mysql_real_escape_string($columns);
		}
		/* END HANDLE COLUMNS */
		
		/* HANDLE WHERES */
		
		$this->sql = "SELECT $column_string FROM $tablename";
		
		if(isset($wheres) && is_array($wheres) ) {
			
			$escaped_where = array();
			
			foreach($wheres as $column => $value) {
				
				$escaped_where[] = '(' . '`'.mysql_real_escape_string($column).'`' . ' = "' .mysql_real_escape_string($value) . '")';
			}
			$where_string = implode(' AND ', $escaped_where);
			
			$this->sql .= " WHERE $where_string";
		}
		
		/* END HANDLE WHERES */
				
		
		if(isset($order)) {
		
			$order = mysql_real_escape_string($order);
			$this->sql.= " ORDER BY $order";
		}
		
		//echo $this->sql;
		
		$result = mysql_query( $this->sql ) or die( mysql_error() );
		$results = array();
		while( $row = mysql_fetch_assoc($result) ) {
			
			$results[] = $row;
		}
		$this->closeDB();
		return $results;
	}
	
	function insert($tablename, $data) {
		
		$this->openDB();
		$tablename = mysql_real_escape_string($tablename);
		
		$columns = array();
		$values = array();
		
		$column_string = '';
		$value_string = '';
		
		
		foreach($data as $column => $value) {
			
			$columns[] = '`'.mysql_real_escape_string($column).'`';
			$values[] = '"' . mysql_real_escape_string($value) . '"';
		}
		
		$column_string = '(' . implode(', ',$columns) . ')';
		$value_string = '(' . implode(', ', $values) . ')';
		
		$this->sql = "INSERT INTO $tablename $column_string VALUES $value_string";
		
		$result = mysql_query( $this->sql ) or die( mysql_error() );
		$id= mysql_insert_id();
		$this->closeDB();
		return $id;

	}
	
	function update($tablename, $data, $wheres = NULL) {
		
		$this->openDB();
		$tablename = mysql_real_escape_string($tablename);
		
		$set = array();
		
		$set_string = '';
				
		foreach($data as $column => $value) {
			
			$set[] = '`'.mysql_real_escape_string($column).'`' .' = "' . mysql_real_escape_string($value) . '"';
		}
		
		$set_string = implode(', ',$set);
		
		$this->sql = "UPDATE $tablename SET $set_string";
		
		/* HANDLE WHERES */
				
		if(isset($wheres) && is_array($wheres) ) {
			
			$escaped_where = array();
			
			foreach($wheres as $column => $value) {
				
				$escaped_where[] = '(' . '`'.mysql_real_escape_string($column).'`' . ' = "' .mysql_real_escape_string($value) . '")';
			}
			$where_string = implode(' AND ', $escaped_where);
			
			$this->sql .= " WHERE $where_string";
		}
		
		/* END HANDLE WHERES */		
		
		$result = mysql_query( $this->sql ) or die( mysql_error() );
		$this->closeDB();
		return $result;

	}
	
	function insertOrUpdateIfExists($tablename, $data, $wheres) {
		
		if( $this->selectOne('*', $tablename, $wheres) ) {
			
			return $this->update($tablename, $data, $wheres);
		}
		else {
			
			return $this->insert($tablename, $data);
		}
	}
	
	function delete($tablename, $wheres = NULL) {

		$this->openDB();
		$tablename = mysql_real_escape_string($tablename);
		
		$this->sql = "DELETE FROM $tablename";
		
		/* HANDLE WHERES */
				
		if(isset($wheres) && is_array($wheres) ) {
			
			$escaped_where = array();
			
			foreach($wheres as $column => $value) {
				
				$escaped_where[] = '(' . '`'.mysql_real_escape_string($column).'`' . ' = "' .mysql_real_escape_string($value) . '")';
			}
			$where_string = implode(' AND ', $escaped_where);
			
			$this->sql .= " WHERE $where_string";
		}
		
		/* END HANDLE WHERES */		
		
		$result = mysql_query( $this->sql ) or die( mysql_error() );
		$this->closeDB();
		return $result;		
		
	}
	
	function query($sql,$variables = NULL) {
		
		$this->openDB();
		

		if(isset($variables) && is_array($variables) && stristr($sql, '$')) {
			
			$escaped_variables = array();			
			foreach($variables as $variable) {
				
				$escaped_variables[] = mysql_real_escape_string($variable);	
			}
			
			$pieces = explode('$',$sql);
			$sql = '';
			for($x = 0; $x < count($pieces); $x++) {
				
				if(isset($escaped_variables[$x])) {
					$var = 	$escaped_variables[$x];
				}
				else {
					$var = '';
				}
				$sql .= $pieces[$x] . $var;
			}			
		}
		
		$this->sql = $sql;
		$result = mysql_query( $this->sql ) or die( mysql_error() );
		
		$this->closeDB();
		
		return $result;					
	}

	function prepareInsert($tablename, $columns) {

		$tablename = mysql_real_escape_string($tablename);
		
		$col = array();
		
		foreach($columns as $column) {
			
			$col[] = mysql_real_escape_string($column);
		}
		
		$column_string = '(`' . implode('`, `',$col) . '`)';
		$value_string = '(:' . implode(', :', $col) . ')';
		$return = "INSERT INTO $tablename $column_string VALUES $value_string";
		return 	$return;	

	}
	
	function prepareUpdate($tablename, $columns, $where_columns) {

		$tablename = mysql_real_escape_string($tablename);
		
		$set = array();
		
		$set_string = '';
				
		foreach($columns as $column) {
			
			$set[] = '`'.mysql_real_escape_string($column).'`' .' = :' . mysql_real_escape_string($column);
		}
		
		$set_string = implode(', ',$set);
		
		$return = "UPDATE $tablename SET $set_string";
		
		/* HANDLE WHERES */
				
		if(isset($where_columns)) {
			
			$escaped_where = array();
			
			foreach($where_columns as $column) {
				
				$escaped_where[] = '(' . '`'.mysql_real_escape_string($column).'`' . ' = :' .mysql_real_escape_string($column) . ')';
			}
			$where_string = implode(' AND ', $escaped_where);
			
			$return .= " WHERE $where_string";
		}
		return $return;	
	}	
	
	function getLastQuery() {
	
		return $this->sql;
	}
}
?>