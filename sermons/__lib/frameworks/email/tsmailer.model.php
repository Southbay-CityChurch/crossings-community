<?php
require_once('mailer/class.phpmailer.php');

class tsMailer extends PHPMailer {
    var $priority = 3;
    var $to_name;
    var $to_email;
	var $FromName = 'Orbital Data Support'; // from email name
	var $From = 'supportreg@orbitaldata.com';
	var $Sender = 'supportreg@orbitaldata.com';
	//var $Mailer = 'sendmail'; // For the VPS Server, this needs to be set to "sendmail"
	 
	 var $mailConfig= array();
  
	function tsMailer() {
		
		/* Email Settings */
		// Just in case we need to relay to a different server, provide an option to use external mail server.
		$this->mailConfig['smtp_mode'] = 'enabled'; // enabled or disabled
		$this->mailConfig['smtp_host'] = 'exchange.orbitaldata.com';
		$this->mailConfig['smtp_port'] = '25';
		//$this->mailConfig['smtp_username'] = ''; 
		//$this->mailConfig['smtp_password']= '';
		/* EOF Settings */
		
		if ($this->mailConfig['smtp_mode'] == 'enabled') {
			$this->Host = $this->mailConfig['smtp_host'];
			$this->Port = $this->mailConfig['smtp_port'];
			
			if ($mailConfig['smtp_username'] != '') {
				$this->SMTPAuth  = true;
				$this->Username  = $this->mailConfig['smtp_username'];
				$this->Password  =  $this->mailConfig['smtp_password'];
			}
			$this->Mailer = "smtp";
		}
		
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
