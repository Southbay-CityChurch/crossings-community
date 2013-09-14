<?php


class tsDB {
	
	
	var $host;
	var $user;
	var $pass;
	var $db;
	
	// Collections
	var $dbRows=array(); // Rows from initial queries
	
	
	
	
	/**
	* @access public
	*
	* CONSTRUCTOR
	* Database host, username, password, database constants set in CONFIG file.
	*/
	function tsDB() {
		$this->host= DB_HOST;
		$this->user= DB_USER;
		$this->pass= DB_PASS;
		$this->db= DB_NAME;		
		
		if (!$this->dbConnect()) return FALSE;
		else return TRUE;
	}
	
	
	
	
	/**
	* @access private
	* @param 
	*
	* Database connection
	*/
	function dbConnect() {
		$link= @mysql_connect($this->host, $this->user, $this->pass);
		if (!$link) return FALSE;
		$db= @mysql_select_db($this->db);
		if (!$db) return FALSE;
		
		return TRUE;
	}
	
	/**
	* @access protected
	*
	* Database disconnect
	*/
	function dbDisconnect() {
		@mysql_close();
	}
	
	
	//TODO: Tommy: can you document this
	/**
	* @access protected
	*
	* Gets the table columns from the database
	*/
	function getColumns($table_name) {
		
		$sql= "SHOW COLUMNS FROM `$table_name`";
		
		if (!$cols= $this->query($sql)) {
			return FALSE;
		}
		else {
			while ($col = mysql_fetch_array($cols)){
				$array[]= $col[0];
			}
			return $array;
		}
	}
	
	
	//TODO: Tommy: can you document this too?
	/**
	* @access protected
	*
	* TODO: BRIAN -- not sure what this does????  :)  Is this for typecasting?  sorry...
	*/
	function getColumnsExtended ($table_name){
	  $sql= "SHOW COLUMNS FROM `$table_name`";
	  if (!$cols= $this->query($sql)) {
			return FALSE;
		} else {
			while ($col = mysql_fetch_assoc($cols)){
				$columns[$col['Field']] = array('name' => $col['Field'],
				                                'type' => $col['Type'],
				                                'null' => $col['Null'],
				                                'key_type' => $col['Key'],
				                                'default' => $col['Default']);
			}
			return $columns;
		}
	}
	
	
	// CHANGED: Tommy (7/9/06) Removed resetRows()
	
	
	// CHANGED: Brian (7/8/06): Add DB locking before INSERT query
	// CHANGED: Brian (7/8/06): Create DB unlocking method
	/**
	* @access public
	* @return true or false if operation was successful
	*
	* Base lockTable
	* 
	* You can read: http://dev.mysql.com/doc/refman/4.1/en/lock-tables.html to get
	* a good grasp on how table locking works.
	* "If a thread obtains a READ lock on a table, that thread (and all other threads) can only read from the table. 
	* If a thread obtains a WRITE lock on a table, only the thread holding the lock can write to the table. 
	* Other threads are blocked from reading or writing the table until the lock has been released."
	*
	* To reduce complexity at the price of speed, we are only supporting the "harsher" WRITE lock.
	*/
	
	function lockTable($table_name) {
	   return $this->query("LOCK TABLES $table_name WRITE");
	}
	function unlockTable() {
	   return $this->query("UNLOCK TABLES");
	}
	function unlockTables() {return $this->unlockTable();} // a nice alias, since it reads better :)
	
	
	/* ------------------- ** PRIVATE ** Record Methods ------------------------ */
	
	/**
	* @access private
	* @return FALSE on error, the record set if SELECT is used, the # of affected rows if UPDATE, DELETE, or INSERT is used
	*
	* Base query
	*/
	
	// CHANGED: Change the condition if it's an INSERT query -- return the ID <-- This is not a TSDB concern. TSDB doesn't know what an ID is.
	// CHANGED: Brian(7/8/06): Refactored TSDB::Query()
	
	function query($query, $debug_query = false) {
		//$sqlRS= mysql_query($query) or die('Query Error: ' . mysql_error() . ' in:<br /> "' . $query . '"');
		
		if ($debug_query) echo 'QUERY:<br />' . $query . '<br /><br />';
		
		// Gets the query type from the query
		$query_type = strtoupper(reset(explode(' ', trim($query))));      
				
		if (!$sqlRS= mysql_query($query)) {
		   if ($debug_query) echo "\n<br /> Invalid query: " . mysql_error() . "\n <br />";
			$output = FALSE;
		}
		
		switch ($query_type) {	   
		   case 'UPDATE' :
		   case 'DELETE' :
		   case 'INSERT' :
		      $output = mysql_affected_rows();
		      break;
		   
		   default:
		   case 'SHOW' :
	      case 'SELECT' :
		      $output = $sqlRS; 
		      break;   // this is unnecessary, but I'll keep it for good form
		}
		
		// echo "<br />\n";
		// var_dump($output);
		// echo "<br />\n";
		
		return $output;
	}
	
	
	
	
	/**
	* @access private
	*
	* Initial query to gather records.
	* Loads the records into the dbRows array
	*/
	function getRows($table, $fields=null, $options=array()) {
		$query= "SELECT";
		
		if (!is_null($fields)) {
			$query .= " $fields";
		} else {
			$query .= " *";
		}
		
		$query .= " FROM `$table`";
		
		if (count($options) > 0) extract($options);
		if ($where) $query .= " WHERE $where";
		if ($order_by) $query .= " ORDER BY $order_by";
		if ($limit) $query .= " LIMIT $limit";
		
		//debug
		//echo 'Select:<br />' . $query . '<br /><br />';
		
		if (!$rows= $this->query($query)) {
			return FALSE;
		} else {
			for ($r=0; $r < mysql_num_rows($rows); $r++) {
				$this->dbRows[] = $this->makeAssoc($rows);
			}
			return $this->dbRows;
		}
	}
	
	
	/**
	* @access private
	*
	* Gets the total number of records for a given table
	*/
	//CHANGED: Brian (7/8/06): Refactored totalRecords() now uses SQL to get the count, not PHP;
	// TODO: Test totalRecords()
	
	function totalRecords($table, $where) {
		$sql= "SELECT COUNT(*) AS total_count FROM $table WHERE $where";
		if (!$rs= $this->query($sql)) return false;
		else {
		   $rows = $this->makeAssoc($rs);
			return $rows['total_count'];
		}
	}
	
	
	
	/**
	* @access private
	* @return Object, Array, or Assoc. Array
	*
	* Record handling methods
	*/
	function makeObj($rs) { return mysql_fetch_object($rs); }
	function makeArray($rs) { return mysql_fetch_array($rs); }
	function makeAssoc($rs) { return mysql_fetch_assoc($rs); }
	
	
	
	
	/**
	* @access private
	* @param Table to update
	* @param ARRAY - field to update and value to set
	* @param ARRAY - ID field in the table (like userID), and ID of the record to update
	*
	* Record Updating
	*/
	function update($table, $field_val, $id) {
		$field= key($field_val);
		$val= $field_val[$field];
		$id_field= key($id);
		$id_val= $id[$id_field];
		
		$sql= "UPDATE `$table` SET `" . $field . "`='" . $val . "' WHERE `" . $id_field . "`='" . $id_val. "' LIMIT 1";
		
		//debug
		//echo 'Update:<br />' . $sql . '<br /><br />';
		
		return $this->query($sql);
	}
	
}

?>
