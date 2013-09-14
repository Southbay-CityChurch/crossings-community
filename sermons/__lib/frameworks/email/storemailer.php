<?php
require_once('mailer/class.phpmailer.php');

class tmMailer extends PHPMailer {
	var $priority = 3;
	var $to_name;
	var $to_email;
	var $FromName = 'Tina Marie'; // from email name
	var $From = 'tinamarie@bridalhairdesign.com';
	var $Sender = 'tinamarie@bridalhairdesign.com';
	//var $Mailer = 'sendmail'; // For the VPS Server, this needs to be set to "sendmail"
	
	var $mailConfig= array();
  
	function tmMailer() {
		$this->Priority = $this->priority;
	}
	
	function setSubject($subject) {
		$this->Subject= $subject;
	}
	
	function setBody($body) {
		$this->Body= $body;
	}
	
	function setAltBody($altbody) {
		$this->AltBody= $altbody;
	}
	
	function setFromAddress($from) {
		$this->From= $from;
	}
}
?> 
