<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'PaypalRecurring');
App::import('Vendor', 'IpnListener');
App::import('Vendor', 'PaypalRecurringPaymentProfile');
class UsersController extends AppController {

/************  Recurring Payments with Express Checkout processing flow(app/Controller/Controller.php *********/

       //Calls SetExpressCheckout, setting up one or more billing agreements in the request.
       //Returns a token, which identifies the transaction, to the merchant.
       //Redirects buyer's browser to: https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout &token=<token returned bySetExpressCheckout>
       function paidCheckout () {		
		
		/* PAYPAL API  DETAILS */
		$API_UserName 	= $this->API_UserName;
		$API_Password 	= $this->API_Password;
		$API_Signature  = $this->API_Signature;
		$API_Endpoint 	= $this->API_Endpoint;
	        $version        = $this->version;
		
		/*SET SUCCESS AND FAIL URL*/
		$host 	   =  $_SERVER['SERVER_NAME'];		    
		$root      =  $this->webroot; 
		$returnURL = "http://$host$root".'controller/reviewOrder';
		$cancelURL = "http://$host$root".'controller/signupFailure';
		
		/* SET VALUES */	
		$environment 	= $this->environment;		
		$L_BILLINGTYPE0 = 'RecurringPayments';		
		
		if ($this->request->is('post')) {
			
	                $obj	= new PaypalRecurring;		
			
			/* PAYPAL API  DETAILS */
			$obj->API_UserName 	= urlencode($API_UserName);
			$obj->API_Password 	= urlencode($API_Password);
			$obj->API_Signature = urlencode($API_Signature);
			$obj->API_Endpoint 	= $API_Endpoint;
			$obj->version 		= urlencode($version);
			
			/*SET SUCCESS AND FAIL URL*/
			$obj->returnURL = urlencode($returnURL);
			$obj->cancelURL = urlencode($cancelURL);
			
			$obj->environment 						=  $environment;	
			$obj->paymentType 						=  urlencode($paymentType);	
			$obj->L_BILLINGTYPE0 					=  $L_BILLINGTYPE0;		
			$obj->L_BILLINGAGREEMENTDESCRIPTION0	=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);	
			$obj->paymentAmount						=  urlencode($subscription_cost); //Amt
			$obj->taxamount							=  urlencode($service_tax);	
			$obj->currencyID						=  urlencode($currency_code);	
			$obj->L_PAYMENTREQUEST_0_NAME0			=  urlencode($subscription_name);
			$obj->L_PAYMENTREQUEST_0_AMT0			=  urlencode($subscription_cost);
			$obj->L_PAYMENTREQUEST_0_DESC0			=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);	
			$obj->PAYMENTREQUEST_0_ITEMAMT			=  urlencode($subscription_cost);
			$obj->PAYMENTREQUEST_0_TAXAMT			=  urlencode($service_tax);
			$obj->PAYMENTREQUEST_0_AMT				=  urlencode($bill_amount); // grand total
			$obj->PAYMENTREQUEST_0_CURRENCYCODE		=  urlencode($currency_code);
							
			$task = "setExpressCheckout"; //set initial task as Express Checkout			
			$httpParsedResponseAr = $obj->setExpressCheckout();
			$methodError = 'SetExpressCheckout';			
			$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
			$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
			$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
			$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
			
			// store in session for later use
			$this->Session->write('errorCode',$errorCode);			
			$this->Session->write('errorSmallMsg',$errorSmallMsg);
			$this->Session->write('errorLongMsg',$errorLongMsg);	
			$this->Session->write('serverCode',$serverCode);			
			$this->redirect(array('controller'=>'controller','action' => 'action/'.$methodError));
			
		}
	}


       //Calls GetExpressCheckoutDetails to get buyer information
       public function reviewOrder () {
		
		/* PAYPAL API  DETAILS */
		$API_UserName 	= $this->API_UserName;
	        $API_Password 	= $this->API_Password;
		$API_Signature  = $this->API_Signature;
		$API_Endpoint 	= $this->API_Endpoint;
		$version		= $this->version;	
		
		/* SET VALUES */
		 $environment 	 = $this->environment;		
		 $L_BILLINGTYPE0 = 'RecurringPayments';
		
		$obj	=	new PaypalRecurring;		
		
		/* PAYPAL API  DETAILS */
		$obj->API_UserName 	= urlencode($API_UserName);
		$obj->API_Password 	= urlencode($API_Password);
		$obj->API_Signature = urlencode($API_Signature);
		$obj->API_Endpoint 	= $API_Endpoint;
		$obj->version 		= urlencode($version);				
		$obj->environment 	=  $environment;		
			
		$task = "getExpressCheckout"; //set initial task as Express Checkout			
		$httpParsedResponseAr = $obj->getExpressCheckout();
		
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {			
			$this->set(compact('httpParsedResponseAr'));
		} else  {			
			$methodError = 'GetExpressCheckoutDetails';			
			$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
			$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
			$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
			$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
			
			// store in session for later use
			$this->Session->write('errorCode',$errorCode);			
			$this->Session->write('errorSmallMsg',$errorSmallMsg);
			$this->Session->write('errorLongMsg',$errorLongMsg);	
			$this->Session->write('serverCode',$serverCode);			
			$this->redirect(array('controller'=>'controller','action' => 'action/'.$methodError));
			
		}		
	}

        function makePayment () {		
		
		/* PAYPAL API  DETAILS */
		$API_UserName 	= $this->API_UserName;
		$API_Password 	= $this->API_Password;
		$API_Signature  = $this->API_Signature;
		$API_Endpoint 	= $this->API_Endpoint;
		$version        = $this->version;
				
		/* SET VALUES */
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';
		
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriber');
		$this->loadModel('SbsSubscriberSetting');	
		$this->loadModel('CpnSetting');
		$this->loadModel('SbsEmailTemplateDetail');	
		$this->loadModel('SbsEmailTemplate');
						
		if ($this->request->is('post')) {
			
			
			$obj	=	new PaypalRecurring;
			
			/* PAYPAL API  DETAILS */
			$obj->API_UserName 	= urlencode($API_UserName);
			$obj->API_Password 	= urlencode($API_Password);
			$obj->API_Signature = urlencode($API_Signature);
			$obj->API_Endpoint 	= $API_Endpoint;
			$obj->version 		= urlencode($version);			
			
			// Set request-specific fields.
			$obj->startDate 	= urlencode($profilestartdate);
			$obj->billingPeriod = urlencode($billing_period);				
			$obj->billingFreq 	= urlencode($billing_frequency);						
			$obj->paymentAmount = urlencode($subscription_cost);
			$obj->currencyID 	= urlencode($currency_code);			
			$obj->taxamount		= urlencode($service_tax);	
		    $obj->maxfailedpayments 	   = 2;  
		    $obj->autobillamount    	   = 'AddToNextBilling';	  
			$obj->initamount			   = $initial_amount;
			$obj->failedinitamountaction   = 'CancelOnFailure';   //FAILEDINITAMTACTION
			$obj->environment 						=  $environment;	
			$obj->paymentType 						=  urlencode($paymentType);	
			$obj->L_BILLINGTYPE0 					=  $L_BILLINGTYPE0;		
			$obj->L_BILLINGAGREEMENTDESCRIPTION0	=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0); 
			// creating recurring profile
			$httpParsedResponseAr = $obj->createRecurringPaymentsProfile($token);
			
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {		
			
				$profile_id  	=  urldecode($httpParsedResponseAr["PROFILEID"]);
				$profile_status =  urldecode($httpParsedResponseAr["PROFILESTATUS"]);
				
				switch ($profile_status) {
					case 'ActiveProfile':
						$profile_status = 'Active';	
						break;
					case 'PendingProfile':
						$profile_status = 'Pending';
						break;
					case 'CancelledProfile':
						$profile_status = 'Cancelled';
						break;	
					case 'SuspendedProfile':
						$profile_status = 'Suspended';
						break;	
					case 'ExpiredProfile':
						$profile_status = 'Expired';
						                            break;												
				}
				
			if($success){
                 	   $this->redirect(array('controller'=>'controller','action' => 'action'));
		        
                       }else  {
				// signupFailure
				$methodError 	= 'createRecurringPaymentsProfile';
				$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
				$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
				$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
				$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
				
				// store in session for later use
				$this->Session->write('errorCode',$errorCode);			
				$this->Session->write('errorSmallMsg',$errorSmallMsg);
				$this->Session->write('errorLongMsg',$errorLongMsg);	
				$this->Session->write('serverCode',$serverCode);			
				$this->redirect(array('controller'=>'controller','action' => 'action/'.$methodError));
			}
		 }
	}

}

?>
