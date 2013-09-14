<?php

class formInput {
	
	// Query Prep (form field cleanup)
	function cleanse($value) {
		// Quote variable to make safe
	
		// Stripslashes
		if (get_magic_quotes_gpc()) {
			 $value = stripslashes($value);
		}
		
		// Escape Characters
		// This calls a MySQL function, so it has to have a connection established!!  
		// Connect before cleaning the input (it will use the previous connection used)
		$value = mysql_real_escape_string($value);
		
		return $value;
	}
	
	
	/**
	* Checks for a valid date
	*
	* @param string  Date in the format given by the format parameter.
	* @param integer Disallow years more than $yearepsilon from now (in future as well as in past)
	* @param string  Formatting string. Has to be one of 'dmy', 'dym', 'mdy', 'myd', 'ydm' or 'ymd'. (Default is 'ymd' for ISO 8601 compability)
	* @return string yyyy-mm-dd
	* @since 1.0
	* Thanks to http://us2.php.net/checkdate!!
	*/
	
	function datecheck($date, $yearepsilon=0, $format='mdy') {
		$format = strtolower($format);
		if (count($datebits=explode('-',$date))!=3) return false;
		$year = intval($datebits[strpos($format, 'y')]);
		$month = intval($datebits[strpos($format, 'm')]);
		$day = intval($datebits[strpos($format, 'd')]);
		
		if ((abs($year-date('Y'))>$yearepsilon) || // year outside given range
		($month<1) || ($month>12) || ($day<1) ||
		(($month==2) && ($day>28+(!($year%4))-(!($year%100))+(!($year%400)))) ||
		($day>30+(($month>7)^($month&1)))) return false; // date out of range
		
		if (($month < 10) && (strlen($month) < 2)) $month= '0' . $month;
		
		return $year . '-' . $month . '-' . $day;
	}
}
?>