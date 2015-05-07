<?php

public function getTimeFormat ($time){
		
		setlocale(LC_TIME, 'en_IN');
		
		$emptyTime = explode(':',$time);
		
		
		if($emptyTime['0'].':'.$emptyTime['1'] == '00:00'){
			return '-----';
		}else{
		    $timeExplode = explode(':',$time);
			$timeInHrs =  ltrim($timeExplode['0'], "0");
			$timeInMin =  ltrim($timeExplode['1'], "0");
			
			if(empty($timeInMin)){
				$timeInMin = '0';
			}
			
			if(empty($timeInHrs)){
				return $timeInMin .' '.'Min';
			}elseif(empty($timeInMin)){
			     return $timeInHrs .' '.'Hrs';
			}else{
			    return $timeInHrs .' '.'Hr' .' '. $timeInMin.' '.'Min';
		    }
		
		}
		
	}

?>
