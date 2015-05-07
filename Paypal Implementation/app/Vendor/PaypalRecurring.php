<?php
//app/Vendor/PaypalRecurring.php
//AUTHOR 	: siddharth jain
//DATE 		: 9 JUNE 2014
//COMPANY 	: Carmatec
//EMAIL 	: 
//WEBSITE	:

class PaypalRecurring
{	

	function setExpressCheckout()
	{	
		$environment					=	$this->environment;
		$API_UserName					=	$this->API_UserName;
		$API_Password					=	$this->API_Password;
		$API_Signature					=	$this->API_Signature;
		$API_Endpoint					=	$this->API_Endpoint;
		$paymentAmount					=	$this->paymentAmount;
		$taxamount						=	$this->taxamount;
		$currencyID						=	$this->currencyID;
		$paymentType					=	$this->paymentType;
		$returnURL						=	$this->returnURL;
		$cancelURL						=	$this->cancelURL;
		$startDate						=	$this->startDate;
		$L_BILLINGTYPE0					=	$this->L_BILLINGTYPE0;
		$L_BILLINGAGREEMENTDESCRIPTION0	=	$this->L_BILLINGAGREEMENTDESCRIPTION0;
		
		/* $L_PAYMENTREQUEST_0_NAME0		=	$this->L_PAYMENTREQUEST_0_NAME0;	
		$L_PAYMENTREQUEST_0_AMT0		=	$this->L_PAYMENTREQUEST_0_AMT0;			
		$L_PAYMENTREQUEST_0_DESC0		=	$this->L_PAYMENTREQUEST_0_DESC0;				
		$PAYMENTREQUEST_0_ITEMAMT		=	$this->PAYMENTREQUEST_0_ITEMAMT;			
		$PAYMENTREQUEST_0_TAXAMT		=	$this->PAYMENTREQUEST_0_TAXAMT;		
		$PAYMENTREQUEST_0_AMT			=	$this->PAYMENTREQUEST_0_AMT;				
		$PAYMENTREQUEST_0_CURRENCYCODE	=	$this->PAYMENTREQUEST_0_CURRENCYCODE;	*/

		
		// Add request-specific fields to the request string.
		$nvpStr = "&AMT=$paymentAmount&RETURNURL=$returnURL&CANCELURL=$cancelURL&CURRENCYCODE=$currencyID&L_BILLINGTYPE0=$L_BILLINGTYPE0&L_BILLINGAGREEMENTDESCRIPTION0=$L_BILLINGAGREEMENTDESCRIPTION0";
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = $this->fn_setExpressCheckout('SetExpressCheckout', $nvpStr);
		
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
			// Redirect to paypal.com.
			$token = urldecode($httpParsedResponseAr["TOKEN"]);
			$payPalURL = "https://www.paypal.com/webscr&cmd=_express-checkout&token=$token";
			if("sandbox" === $environment || "beta-sandbox" === $environment) {
				$payPalURL = "https://www.$environment.paypal.com/webscr&cmd=_express-checkout&token=$token";
			}
			header("Location: $payPalURL");
			exit;
		} else  {
			//exit('SetExpressCheckout failed: ' . print_r($httpParsedResponseAr, true));
			return $httpParsedResponseAr;
		}	
	}	
	
	function getExpressCheckout()
	{
		$environment		=	$this->environment;
		$API_UserName		=	$this->API_UserName;
		$API_Password		=	$this->API_Password;
		$API_Signature		=	$this->API_Signature;
		$API_Endpoint		=	$this->API_Endpoint;
		$paymentAmount		=	$this->paymentAmount;
		$currencyID			=	$this->currencyID;
		$paymentType		=	$this->paymentType;
		$returnURL			=	$this->returnURL;
		$cancelURL			=	$this->cancelURL;
		$startDate			=	$this->startDate;
		
		// Obtain the token from PayPal.
		if(!array_key_exists('token', $_REQUEST)) {
			exit('Token is not received.');
		}
		
		// Set request-specific fields.
		$token = urlencode(htmlspecialchars($_REQUEST['token']));
		
		// Add request-specific fields to the request string.
		$nvpStr = "&TOKEN=$token";
		
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = $this->fn_getExpressCheckout('GetExpressCheckoutDetails', $nvpStr);
		return $httpParsedResponseAr;
		
	}	
	
	function doExpressCheckout($payerID,$token)
	{
		$environment		=	$this->environment;
		$API_UserName		=	$this->API_UserName;
		$API_Password		=	$this->API_Password;
		$API_Signature		=	$this->API_Signature;
		$API_Endpoint		=	$this->API_Endpoint;
		$paymentAmount		=	$this->paymentAmount;
		$currencyID			=	$this->currencyID;
		$paymentType		=	$this->paymentType;
		$returnURL			=	$this->returnURL;
		$cancelURL			=	$this->cancelURL;
		
		// Add request-specific fields to the request string.
		$nvpStr = "&TOKEN=$token&PAYERID=$payerID&PAYMENTACTION=$paymentType&AMT=$paymentAmount&CURRENCYCODE=$currencyID";
		
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = $this->fn_doExpressCheckout('DoExpressCheckoutPayment', $nvpStr);
		
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
		
		$this->createRecurringPaymentsProfile($token);		
		
			exit('Express Checkout Payment Completed Successfully: '.print_r($httpParsedResponseAr, true));
		} else  {
			exit('DoExpressCheckoutPayment failed: ' . print_r($httpParsedResponseAr, true));
		}
	}
	
	function createRecurringPaymentsProfile($token)
	{
		$environment		=	$this->environment;
		$API_UserName		=	$this->API_UserName;
		$API_Password		=	$this->API_Password;
		$API_Signature		=	$this->API_Signature;
		$API_Endpoint		=	$this->API_Endpoint;
		$paymentAmount		=	$this->paymentAmount;
		$currencyID			=	$this->currencyID;
		$paymentType		=	$this->paymentType;
		$returnURL			=	$this->returnURL;
		$cancelURL			=	$this->cancelURL;
		$startDate			=	$this->startDate;
		$billingPeriod		=	$this->billingPeriod;
		$billingFreq		=	$this->billingFreq;	
		$taxamount			=	$this->taxamount;	
        $maxfailedpayment	=	$this->maxfailedpayments;
	    $autobillamount		=	$this->autobillamount;
	    $failedinitamountaction   = $this->failedinitamountaction;
	    $initamount			      =	$this->initamount;
		$L_BILLINGTYPE0					=	$this->L_BILLINGTYPE0;
		$L_BILLINGAGREEMENTDESCRIPTION0	=	$this->L_BILLINGAGREEMENTDESCRIPTION0;	
		
		//$token = $_REQUEST['token'];		
		
		$nvpStr="&TOKEN=$token&AMT=$paymentAmount&CURRENCYCODE=$currencyID&PROFILESTARTDATE=$startDate&TAXAMT=$taxamount&INITAMT=$initamount&AUTOBILLOUTAMT=$autobillamount";				 
		$nvpStr .= "&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFreq&DESC=$L_BILLINGAGREEMENTDESCRIPTION0&FAILEDINITAMTACTION=$failedinitamountaction";

		$httpParsedResponseAr = $this->fn_createRecurringPaymentsProfile('CreateRecurringPaymentsProfile', $nvpStr);
		//print_r($httpParsedResponseAr); exit;
		return $httpParsedResponseAr;
		
	}	
	
	function fn_createRecurringPaymentsProfile($methodName_, $nvpStr_)
	{
		$environment		=	$this->environment;
		$API_UserName		=	$this->API_UserName;
		$API_Password		=	$this->API_Password;
		$API_Signature		=	$this->API_Signature;
		$API_Endpoint		=	$this->API_Endpoint;
		$paymentAmount		=	$this->paymentAmount;
		$currencyID			=	$this->currencyID;
		$paymentType		=	$this->paymentType;
		$returnURL			=	$this->returnURL;
		$cancelURL			=	$this->cancelURL;
		$startDate			=	$this->startDate;
		$version 			=	$this->version;
		
			// setting the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
			// turning off the server and peer verification(TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
		
			// NVPRequest for submitting to server
			$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
		
			// setting the nvpreq as POST FIELD to curl
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		
			// getting response from server
			$httpResponse = curl_exec($ch);
		
			if(!$httpResponse) {
				exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
			}
		
			// Extract the RefundTransaction response details
			$httpResponseAr = explode("&", $httpResponse);
		
			$httpParsedResponseAr = array();
			foreach ($httpResponseAr as $i => $value) {
				$tmpAr = explode("=", $value);
				if(sizeof($tmpAr) > 1) {
					$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
				}
			}
		
			if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
				exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
			}			
			
			return $httpParsedResponseAr;
	}	
	
	function fn_setExpressCheckout($methodName_, $nvpStr_) {
	
		$environment		=	$this->environment;
		$API_UserName		=	$this->API_UserName;
		$API_Password		=	$this->API_Password;
		$API_Signature		=	$this->API_Signature;
		$API_Endpoint		=	$this->API_Endpoint;
		$paymentAmount		=	$this->paymentAmount;
		$currencyID			=	$this->currencyID;
		$paymentType		=	$this->paymentType;
		$returnURL			=	$this->returnURL;
		$cancelURL			=	$this->cancelURL;
		$startDate			=	$this->startDate;
		$version 			=	$this->version;
		
			if("sandbox" === $environment || "beta-sandbox" === $environment) {
				$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
			}
		
			// Set the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
			// Turn off the server and peer verification (TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
		
			// Set the API operation, version, and API signature in the request.
			$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
		
			// Set the request as a POST FIELD for curl.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		
			// Get response from the server.
			$httpResponse = curl_exec($ch);
		
			if(!$httpResponse) {
				exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
			}
		
			// Extract the response details.
			$httpResponseAr = explode("&", $httpResponse);
		
			$httpParsedResponseAr = array();
			foreach ($httpResponseAr as $i => $value) {
				$tmpAr = explode("=", $value);
				if(sizeof($tmpAr) > 1) {
					$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
				}
			}
		
			if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
				exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
			}
		
			return $httpParsedResponseAr;
	}
	
	function fn_getExpressCheckout($methodName_, $nvpStr_)
	{
		$environment		=	$this->environment;
		$API_UserName		=	$this->API_UserName;
		$API_Password		=	$this->API_Password;
		$API_Signature		=	$this->API_Signature;
		$API_Endpoint		=	$this->API_Endpoint;
		$paymentAmount		=	$this->paymentAmount;
		$currencyID			=	$this->currencyID;
		$paymentType		=	$this->paymentType;
		$returnURL			=	$this->returnURL;
		$cancelURL			=	$this->cancelURL;
		$startDate			=	$this->startDate;
		$version 			=	$this->version;
		
			if("sandbox" === $environment || "beta-sandbox" === $environment) {
				$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
			}
		
			// Set the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
			// Turn off the server and peer verification (TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
		
			// Set the API operation, version, and API signature in the request.
			$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
		
			// Set the request as a POST FIELD for curl.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		
			// Get response from the server.
			$httpResponse = curl_exec($ch);
		
			if(!$httpResponse) {
				exit('$methodName_ failed: '.curl_error($ch).'('.curl_errno($ch).')');
			}
		
			// Extract the response details.
			$httpResponseAr = explode("&", $httpResponse);
		
			$httpParsedResponseAr = array();
			foreach ($httpResponseAr as $i => $value) {
				$tmpAr = explode("=", $value);
				if(sizeof($tmpAr) > 1) {
					$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
				}
			}
		
			if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
				exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
			}
		
			return $httpParsedResponseAr;		
	}	
	
	function fn_doExpressCheckout($methodName_, $nvpStr_)
	{
		$environment		=	$this->environment;
		$API_UserName		=	$this->API_UserName;
		$API_Password		=	$this->API_Password;
		$API_Signature		=	$this->API_Signature;
		$API_Endpoint		=	$this->API_Endpoint;
		$paymentAmount		=	$this->paymentAmount;
		$currencyID			=	$this->currencyID;
		$paymentType		=	$this->paymentType;
		$returnURL			=	$this->returnURL;
		$cancelURL			=	$this->cancelURL;
		$startDate			=	$this->startDate;
		$version 			=	$this->version;
		
		
			if("sandbox" === $environment || "beta-sandbox" === $environment) {
				$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
			}			
		
			// setting the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
			// Set the curl parameters.
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
		
			// Set the API operation, version, and API signature in the request.
			$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
		
			// Set the request as a POST FIELD for curl.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		
			// Get response from the server.
			$httpResponse = curl_exec($ch);
		
			if(!$httpResponse) {
				exit('$methodName_ failed: '.curl_error($ch).'('.curl_errno($ch).')');
			}
		
			// Extract the response details.
			$httpResponseAr = explode("&", $httpResponse);
		
			$httpParsedResponseAr = array();
			foreach ($httpResponseAr as $i => $value) {
				$tmpAr = explode("=", $value);
				if(sizeof($tmpAr) > 1) {
					$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
				}
			}
		
			if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
				exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
			}
		
			return $httpParsedResponseAr;
	}

}

?>
