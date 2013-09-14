<?php
/*
This class is meant to be a repository for page utility stuff like form validation, etc.
Add to it as needed...

Trying to keep all of this static.

*/


class validate {
	
	// Checks the field to make sure it's not empty
	function checkField($field) {
		if ((strlen(trim($field)) < 1) || (is_null($field))) return FALSE;
		else return TRUE;
	}
	
	
	
	// Thanks to ilovejackdaniels.com
	// Validates the email address for syntax
	function emailAddress($email) {
		// First, we check that there's one @ symbol, and that the lengths are right
		
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
			// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
			return false;
		}
		
		// Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
				return false;
			}
		}
		
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
				return false; // Not enough parts to domain
			}
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
					return false;
				}
			}
		}
		return true;
	}
	
	
	// Checks to make sure a file name doesn't have any special characters in it
	// RETURNS false on failure
	function checkFileName($file) {
		if(!eregi('^[A-Z_0-9][A-Z_0-9.]*$', $file)) return FALSE;
		else return TRUE;
	}
	
	
	// Makes sure there are no symbols or numbers in a piece of data
	function alpha($data) {
		$data= trim($data);
		if (!validate::checkField($data)) return FALSE;
		if (!eregi("^[A-Za-z]+$", $data)) return FALSE;
		else return TRUE;
	}
	
	
	
	// Makes sure there are no alpha or symbols in a piece of data
	function numeric($data) {
		$data= trim($data);
		if (!validate::checkField($data)) return FALSE;
		//if (!eregi("^[0-9]+$", $data)) return FALSE;
		if (!is_numeric($data)) return FALSE;
		else return TRUE;
	}
	
	
	// Makes sure the data is alphanumeric
	function alphaNumeric($data) {
		$data= trim($data);
		if (!validate::checkField($data)) return FALSE;
		if (!eregi("^[A-Za-z0-9]+$", $data)) return FALSE;
		else return TRUE;
	}
	
	
}
?>