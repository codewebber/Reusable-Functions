<?php

/***** Return the money format  *****/
public function amountFormat ($amount)	{
		
		
		if($amount < 0){
			if($amount <= -100000 && $amount >= -99999999){
				$monthAmount = ($amount/-1000);
				$amt = money_format('%!(.0n',$monthAmount);
				$amnt    = '('.$amt.') '.'K';			
				return $amnt;
			}
			elseif($amount <= -100000000){
				$monthAmount = ($amount/-1000000);
				$amt = money_format('%!(.0n',$monthAmount);
				$amnt    = '('.$amt.') '.'M';
				return $amnt;
			}
			else{
				$amt = money_format('%!(.0n',$amount);
				return $amt;
			}
		}
		else{
			if($amount >= 100000 && $amount <= 99999999){
				$monthAmount = ($amount/1000);
				$amt = money_format('%!(.0n',$monthAmount);
				$amnt    = $amt.' '.'K';			
				return $amnt;
			}
			elseif($amount >= 100000000){
				$monthAmount = ($amount/1000000);
				$amt = money_format('%!(.0n',$monthAmount);
				$amnt    = $amt.' '.'M';
				return $amnt;
			}
			else{
				$amt = money_format('%!(.0n',$amount);
				return $amt;
			}
		}
	}
	else{							
		$amt = money_format('%!(.0n',$amount);
		return $amt;
	} 
	

?>
