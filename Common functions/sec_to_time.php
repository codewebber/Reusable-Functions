<?php 
/********Function to convert seconds to HH:MM:SS format************/
   function sec_to_time($seconds) {
			$hours = floor($seconds / 3600);
			$minutes = floor($seconds % 3600 / 60);
			$seconds = $seconds % 60;
			return ($hours . ":" . $minutes . ":" . $seconds);
	}

?>
