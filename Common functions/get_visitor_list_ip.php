<?php 
include  'get_ip_etails.php'
// get visitor details	
	function getVisitorDetails () {
				
		   $ip = $this->get_client_ip();		   
		   $visitorDetails = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
		   return $visitorDetails;		
	}
?>
