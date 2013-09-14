<?php

/**
 *
 * Each one of the variables defined in each method will get translated
 * into a DB_<<VARIABLE_NAME>> constant.
 *
 * init.php now includes the line:
 *       Environment::Database('brians_laptop');
 * Where the argument passed is the name of the method to use 
 * to create the DB connection constant parameters.
 *
 */


class DatabaseConfig {

	function brians_laptop() {
		$this->host    = '127.0.0.1'; // this is because my mysql.sock is not working right
		$this->user    = 'root';
		$this->pass    = 'root1';
	}
	
	function production() {
		$this->host= '';
		$this->user= '';
		$this->pass= '';
	}
	
}
?>