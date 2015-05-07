<?php 
	function days_in_month($month, $year) {
		// Using first day of the month, it doesn't really matter
	    	$date = $year."-".$month."-1";
	 	return date("t", strtotime($date));
 	}
?>
