<?php

/************Converts date to the default format dd-MM-YY************/
    function dateConvert($data){
		$date = explode(' ', $data);
		$dates = explode('-', $date['0']); 
		if($dates[1]==01) $dates[1]='Jan'; 
		elseif($dates[1]==2){ $dates[1]='Feb'; }
		elseif($dates[1]==3){ $dates[1]='Mar'; }
		elseif($dates[1]==4){ $dates[1]='Apr'; }
		elseif($dates[1]==5){ $dates[1]='May'; }
		elseif($dates[1]==6){ $dates[1]='Jun'; }
		elseif($dates[1]==7){ $dates[1]='Jul'; }
		elseif($dates[1]==8){ $dates[1]='Aug'; }
		elseif($dates[1]==9){ $dates[1]='Sept'; }
		elseif($dates[1]==10){ $dates[1]='Oct'; }
		elseif($dates[1]==11){ $dates[1]='Nov'; }
		elseif($dates[1]==12){ $dates[1]='Dec';}
		return $dates[1]." ".$dates[2]." , ".$dates[0];
	}
?>
