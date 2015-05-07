<?php
	// PayPal settings
	$paypal_email 	= 'paypal@paypal.com';
	$return_url 	= 'http://test@test.com/test/payment/return';				
	$cancel_url 	= 'http://test@test.com/test/payment/cancel';
	$url        	= 'www.paypal.com';
	$currency_code  = 'USD';
?>

<form action="https://<? echo $url;?>/cgi-bin/webscr" method="post"  target="_top">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="hosted_button_id" value="RHWL74EPK9D2C">
	<input type="hidden" name="business" value="<? echo $paypal_email;?>">
	<input type="hidden" name="item_name" value="<? echo 'Item Name'; ?>">
	<input type="hidden" name="item_number" value="<? echo '****'; ?>">
	<input type="hidden" name="amount" value="<? echo 'Amount'; ?>">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="return" value="<? echo $return_url; ?>">
	<input type="hidden" name="cancel_url" value="<? echo $cancel_url; ?>">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="currency_code" value="<? echo $currency_code; ?>">					
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, 
														easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
