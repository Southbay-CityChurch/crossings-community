<?php
require_once TSDB_FRAMEWORK;



class ActiveRecordBase {
	
	var $db                  = null;
	var $table               = null; // set in the extending classes
	var $table_columns       = array(); // these are the columns in the database
	
	var $table_columns_type  = array();
	var $primary_field_key   = 'id';	
	var $primary_field_value = null;

	
	
	
	/**
	* @access public
	*
	* __CONSTRUCTOR
	*
	* if not null, we load the id
	* otherwise, create an empty AR object
	*/
	function ActiveRecordBase($id=null) {
		$this->dbConnect(); // connects and produces our db columns
		
		if (!is_null($id)) {
			$this->id= $id;
			$this->load($id);
		}
	}
	
	
	/**
	* @access public
	*
	* loads the record unique ID
	* can be statically called???
	*/
	function load($id) {		
		$id= (int) $id;
		$sql= "SELECT * FROM `" . $this->table . "` WHERE `" . $this->primary_field_key . "`='$id' LIMIT 1";
		if ($rs= $this->db->query($sql)) {
			$assoc= $this->db->makeAssoc($rs);
			foreach ($this->table_columns as $column_name) {
				// Names the object var according to db column
				if ($column_name !== $this->primary_field_key) $this->$column_name= $assoc[$column_name];
			}
			$this->primary_field_value = $assoc[$this->primary_field_key];
			
			return TRUE;
		}
		else {
			// TODO: create error handling
			return FALSE;
		}
	}
	
	
	/**
	* @access public
	*
	* saves the changed/updated/new record
	* have I been loaded or no?  $this->update() or $this->create()?
	* if it has been loaded and/or has the primary key already 
	* defined then this is an update.... if not its something new so we must create it
	*/
	function save() {
		// CHANGED: Tommy: created save method
		if (!is_null($this->primary_field_value)) {
			$this->update();
		}
		else {
			$this->create();
		}
	}
	
	
	/**
	* @access public
	*
	* RARELY called, be very careful with this one.
	* destroys (completely) the loaded record
	*/
	function destroy() {
		// DELETE
		
		$sql= "DELETE FROM `" . $this->table . "` WHERE `" . $this->primary_field_key . "`='" . $this->id . "' LIMIT 1";
		return $this->db->query($sql);
	}
	
	
	/**
	* @access protected
	* 
	* Creates a new record -- called by save()
	*/
	function create() {
		// INSERT
		$data_poop= $this->prepareData();
		
		// Lock the Table
		$this->db->lockTable($this->table);
		$sql= "INSERT INTO `" . $this->table . "` (`" . implode('`,`', array_keys($data_poop)) . "`) VALUES 
		('" . implode("', '", array_values($data_poop)) . "')";
		
		// Do the insert, who cares about the result!?
		$this->db->query($sql);
		
		// Now select the latest record
		$result= $this->db->query("SELECT `" . $this->primary_field_key . "` AS id FROM `" . $this->table . "` 
		                           ORDER BY `" . $this->primary_field_key . "` DESC LIMIT 1");
		
		// Unlock the Table
		$this->db->unlockTable();
				
      $result = $this->db->makeAssoc($result); 
		$this->primary_field_value = $result['id'];            
		
	}
	
	
	/**
	* @access protected
	* 
	* updates the loaded record -- called by save()
	*/
	function update() {
		// CHANGED: Brian (7/8/06): Refactored update() Now only one query;
		$data= $this->prepareData();
		$sql = 'UPDATE `' . $this->table . '` SET ';		
		foreach($data as $column => $value) {
		   $sql.= ' `' . $column . '` = "' . $value .'",';
		}
		//remove the last ','
		$sql = substr($sql,0,-1);
		$sql.= ' WHERE `' . $this->primary_field_key . '` = "' . $this->primary_field_value . '" LIMIT 1';
		
		return @$this->db->query($sql);
		
	}
	
	
	/**
	* @access protected
	*
	* Creates our db connection
	*/
	function DBConnect() {
		if (is_null($this->db)) {
			$this->db= new tsdb();
		}
		
		if (empty($this->table_columns)) {
			// $this->table_columns= $this->db->getColumns($this->table);
			foreach($this->db->getColumnsExtended($this->table) as $column){
			   $this->table_columns[] = $column['name'];
			   $this->table_columns_type[] = $column['type'];
			}
		}
	}
	
	
	/**
	* @access protected
	*
	* disconnects us from the db
	*/
	function DBDisconnect() {
		if (!is_null($this->db)) {
			$this->db->disconnect();
		}
	}
	
	
	/**
	* @access protected
	*
	* returns an associative array of columns=>data
	* 
	* check out: http://us2.php.net/manual/en/language.types.type-juggling.php
	* for more info on type casting in PHP
	*/
	function prepareData() {
		foreach($this->table_columns as $index => $column) {
			
			// CHANGED: Brian (7/8/06): Added limited type casting
			// TODO: Abstract this out into its own function/class (don't forget dates)
			
			// TODO: at some point add limits the data here... right now just type, not length limit
			
			if ($column !== $this->primary_field_key) {
			   $column_sql_type = $this->table_columns_type[$index];
			   $column_type = strtolower(substr($column_sql_type, 0, strpos($column_sql_type,'(')));
			   $data = $this->$column;
			   
			   switch($column_type){
			      
			      case 'int':
			      case 'smallint':
			         $data = (int) $data;
			         break;
			         
			      case 'varchar':
			         $data = (string) $data;
			         break;
			         
			      case 'decimal':
			      case 'float':
			      case 'double':
			         $data = (float) $data;
			         break;
			         
			      default:
			         $data = $data;
			         break;
			   }
			   
			   
			   $new_array[$column]= $data;
			   
			   // push it back out to the class attributes after its been type-casted
			   $this->$column = $data;
			}
		}
		
		return $new_array;
	}
	
	
	/**
	* @access protected
	*
	* returns either nothing or value of id, based on whether or not you gave it a parameter
	*/
	function id($id = null){
	   if (is_null($id))    return $this->primary_field_value;       //Act as getter
	   // else                 $this->id = int($id);   //Act as a setter
	}
	
}

?>