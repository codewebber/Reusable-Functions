<?php

function sendSmsNotification ($gateway_name,$gateway_username,$gateway_password,$gateway_custid,$sms_text,$phone_num,$originator) {
		
	if($gateway_name == 'hslmobile') {

		$host 		= 'sms.haysystems.com';
		$port 		= '80';
		$action 	= 'sendtxt';
		$client_id 	= $gateway_username;
		$text 		= $sms_text;
		$destaddr 	= $phone_num;
		$secret 	= $gateway_password;
	
		// Compute the MD5 hash (digest)
		$hash = md5($secret . $text . $destaddr);
		
		// Build and encode the URL.
		// Note we are careful to URL-encode the message content as it is the only part
		// of the URL likely to contain reserved characters.
		$url = "https://$host:$port/$action/?client_id=$client_id&text="
		       . urlencode($text) . "&destaddr=$destaddr&key=$hash";
					   
		// Make the HTTP call (you could use CURL on PHP 4+) we nab the content that
		// readfile would normally output directly with the ob_start, ob_get_contents
		// and ob_end_clean calls.
		ob_start();
		$result = @readfile($url);
		$data = ob_get_contents();
		ob_end_clean();
		 
		// Examine the results
		return $result;
	}
	elseif ($gateway_name == 'ooredoo') {			
	
		 $language = 'Language';
		 $customerID     = $gateway_custid;
		 $userName       = $gateway_username;
		 $userPassword   = $gateway_password;
		 $originator     = $originator;
		 $smsText	 = $sms_text;
		 $recipientPhone = $phone_num;
		 if ($language == "ar") {
		 	$messageType	 = 'ArabicWithLatinNumbers';
		 } else {
		 	$messageType	 = 'Latin';
		 }
		 $messageType	 = 'ArabicWithLatinNumbers';			 
		 $defDate	 = date('Ymdhms');
		 $blink		 = false;
		 $flash		 = false;
		 $Private        = false;
		 
		 $smsText = str_replace('<pre>', '', $smsText);
		 $smsText = str_replace('</pre>', '', $smsText);
	
		 $fields = array(
		 'customerID' => $customerID,
		 'userName'   => $userName,
		     'userPassword' => $userPassword,
			 'originator'   =>  $originator,
			 'smsText'	    =>  $smsText,
			 'recipientPhone' => $recipientPhone,
			 'messageType'	 => $messageType,
			 'defDate'	  => '',
			 'blink'	  => 'false',
			 'flash'	  => 'false',
			 'Private'    => 'false'
		);
		$postvars = ''; 
		foreach($fields as $key=>$value) {
		    $postvars .= $key.'='.$value.'&';
		  }
		 $postvars = rtrim($postvars, '&');
	
		  $ch = curl_init(); 
		  $url = "https://messaging.ooredoo.qa/bms/soap/Messenger.asmx/HTTP_SendSms?";
		  curl_setopt($ch,CURLOPT_URL,$url);
		  curl_setopt($ch,CURLOPT_POST,count($fields));
		  curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
		  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		  curl_setopt($ch,CURLOPT_TIMEOUT, 200);
		  $response = curl_exec($ch);
		  curl_close ($ch);								 
		  return $response;	
	}
}



?>
