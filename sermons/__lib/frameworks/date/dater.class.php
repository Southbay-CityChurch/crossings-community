<?php

class dater {
	
	var $date=null;
	
	function dater($date=null) {
		if (is_null($date)) $this->setDate();
		else $this->setDate($date);
	}
	
	
	// --------- Utilities ---------- //
	function getDateTime($date=null) {
		if (!is_null($date)) $use= $date;
		else $use= $this->date;
		return dater::formatDate($use);
	}
	
	
	function getStandardDate($date=null) {
		if (!is_null($date)) $use= $date;
		else $use= $this->date;
		return dater::formatDate($use, 'n/d/Y');
	}
	
	
	function getStandardTime($date=null) {
		if (!is_null($date)) $use= $date;
		else $use= $this->date;
		return dater::formatDate($use, 'g:ia');
	}
	
	
	function getFormalDate($date=null)   {
		if (!is_null($date)) $use= $date;
		else $use= $this->date;
		return dater::formatDate($use, 'F j, Y');
	}
	
	
	function getMonth($date=null) {
		if (!is_null($date)) $use= $date;
		else $use= $this->date;
		
		return dater::formatDate($use, 'F');
	}
	
	
	function getDay($date=null) {
		if (!is_null($date)) $use= $date;
		else $use= $this->date;
		
		return dater::formatDate($use, 'j');
	}
	
	
	function getYear($date=null) {
		if (!is_null($date)) $use= $date;
		else $use= $this->date;
		
		return dater::formatDate($use, 'Y');
	}
	
	
	
	// This verifies the date format to make sure that we are getting a good format for the db
	function verifyDateFormat($date) {
		$date= trim($date);
		$arr= explode('-', $date);
		$currentyear= date('Y');
		
		if (strlen($arr[0]) !== 4) return FALSE;
		if ($arr[0] < $currentyear) return FALSE;
		
		if (strlen($arr[1]) !== 2) return FALSE;
		if ($arr[1] > 12) return FALSE;
		
		if (strlen($arr[2]) !== 2) return FALSE;
		if ($arr[2] > 31) return FALSE;
		
		if (($arr[1] == '02') && ($arr[2] > '29')) return FALSE;
		
		if (($arr[1] == '00') || ($arr[2] == '00')) return FALSE;
		
		return TRUE;
	}
	
	
	
	// ** Somewhat PRIVATE to get the date into the object **//
	function setDate($date=null) {
		if (is_null($date)) $this->date= time();
		else $this->date= $date;
	}
	
	
	// Date formatter to set the date to a good format
	function formatDate($date, $format= 'n/d/Y g:ia') {
		$time = strtotime($date); // Convert the date to seconds (UNIX epoch)
		$formatted_date = date($format, $time); // Convert it back to the format we'd like of m/dd/yyyy h:mm(am/pm)
		return $formatted_date;
	}
	
}

?>
