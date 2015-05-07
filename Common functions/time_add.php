<?php
function time_add($time1 = null, $time2 = null) 
{
		$midnight = strtotime("00:00:00");
		$ssm1 = strtotime($time1) - $midnight;
		$ssm2 = strtotime($tiome2) - $midnight;

		// This gives you the total seconds since midnight resulting from the sum of the two
		$totalseconds = $ssm1 + $ssm2;
		// will be 21960 (6 hours and 6 minutes worth of seconds)

		// If you want an output in a time format again, this will format the output in
		// 24-hour time:

		$formattedTime = date("H:i:s", $midnight + $totalseconds);
		
 }
?>
