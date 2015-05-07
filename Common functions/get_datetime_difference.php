<?php
/****** Get difference between two date time stamps  *****/
function get_time_difference( $start, $end ){
	    	$uts['start']      =    strtotime( $start );
	    	$uts['end']        =    strtotime( $end );
	   		if( $uts['start']!==-1 && $uts['end']!==-1 )
	    	{
	        	if( $uts['end'] >= $uts['start'] )
	        	{
	            	$diff    =    $uts['end'] - $uts['start'];
	            	if( $days=intval((floor($diff/86400))) )
	                	$diff = $diff % 86400;
	            	if( $hours=intval((floor($diff/3600))) )
	                	$diff = $diff % 3600;
	            	if( $minutes=intval((floor($diff/60))) )
	                	$diff = $diff % 60;
	           	 		$diff    =    intval( $diff );
	           	 		if($days <9){
	           	 			$days = '0'.$days;
	           	 		}else{
	           	 			$days = $days;
	           	 		}
	           	 		
	           	 		if($hours <9){
	           	 			$hours = '0'.$hours;
	           	 		}else{
	           	 			$hours = $hours;
	           	 		}
	           	 		
	           	 		if($minutes <9){
	           	 			$minutes = '0'.$minutes;
	           	 		}else{
	           	 			$minutes = $minutes;
	           	 		}
	           	 		
	           	 		            
	            	return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
	        	}
	    	}
	}
?>
