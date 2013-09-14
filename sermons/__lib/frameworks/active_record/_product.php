<?php

require 'base.php';

class product extends ActiveRecordBase {
	
	var $table= 'products';
	
	function product($id=null) {
		parent::ActiveRecordBase($id);
	}
	
	
}

?>