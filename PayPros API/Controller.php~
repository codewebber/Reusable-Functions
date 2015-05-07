<?php
App::uses('AppController', 'Controller');

class Controller extends AppController {

  
  public function pay_pros_api() {
    
   $cc_api_url=$this->paypros_cc_api_url;
   $account_token=$this->paypros_account_token;
   $protocol_version=$this->paypros_protocol_version;
   $transaction_condition_code=$this->paypros_transaction_condition_code;
   $industry=$this->paypros_industry;
   
   $order_id="18";
   $cc_number=trim($this->data['billForm']['card_number']);
   $cvv=trim($this->data['billForm']['cvv']);
   $expiry_month=trim($this->data['billForm']['expiration_month']);
   $expire_year=trim($this->data['billForm']['expiration_year']);
   $charge_total="0.00";
   $manage_payer_data="true";
   $bill_address_one=trim($this->data['billForm']['street_address']);
   $bill_postal_code=trim($this->data['billForm']['zipcode']);
   $charge_type="AUTH";
   $transaction_type="CREDIT_CARD";
   
   $auth_query = "account_token=$account_token&"; 
   $auth_query .= "charge_type=$charge_type&"; 
   $auth_query .= "protocol_version=$protocol_version&"; 
   $auth_query .= "transaction_type=$transaction_type&";
   $auth_query .= "order_id=$order_id&"; 
   $auth_query .= "credit_card_number=$cc_number&"; 
   $auth_query .= "credit_card_verification_number=$cvv&"; 
   $auth_query .= "expire_month=$expiry_month&"; 
   $auth_query .= "expire_year=$expire_year&"; 
   $auth_query .= "transaction_condition_code=$transaction_condition_code&"; 
   $auth_query .= "charge_total=$charge_total&"; 
   $auth_query .= "manage_payer_data=$manage_payer_data&"; 
   $auth_query .= "industry=$industry&"; 
   $auth_query .= "bill_address_one=$bill_address_one&"; 
   $auth_query .= "bill_postal_code=$bill_postal_code"; 
   
   $ch = curl_init("$cc_api_url?$auth_query");
   
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
   curl_setopt($ch, CURLOPT_NOPROGRESS, 1); 
   curl_setopt($ch, CURLOPT_VERBOSE, 1); 
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION,0); 
   curl_setopt($ch, CURLOPT_POST, 1); 
   curl_setopt($ch, CURLOPT_POSTFIELDS, $auth_query); 
   curl_setopt($ch, CURLOPT_TIMEOUT, 120); 
   
   $response = curl_exec($ch); 
   curl_close ($ch);
   
   $out1    = ob_get_contents();
   
   $response_pattern='/response_code=[0-9]*/';
   preg_match($response_pattern, $out1,$response_match);
   $response_data=explode("=",$response_match['0']);
   $response_code=$response_data['1'];
   
   if($response_code!=1){
    
    $error_pattern='/response_code_text=[0-9a-zA-Z-:.\W]*/';
    preg_match($error_pattern, $out1,$error_match);
    $error_data=explode("=",$error_match['0']);
    $error_msg=$error_data['1'];
    $this->Session->setFlash(__($error_msg));
    $this->redirect(array('controller'=>'schedulePickups','action' => 'status','failure'));
   }
   
   $payer_pattern = '/payer_identifier=[0-9a-zA-Z-]*/';
   $payer_regex = preg_match($payer_pattern, $out1,$payer_match);
   debug($payer_regex);
   debug($payer_match);
   
   $payer_identifier_data=null;
   $payer_identifier_data=explode("=",$payer_match['0']);
   $payer_identifier_id=$payer_identifier_data['1'];
   
   $span_pattern = '/span=[0-9]*/';
   preg_match($span_pattern, $out1,$span_match);
   $span_data=null;
   $span_data=explode("=",$span_match['0']);
   $span_id=$span_data['1'];
  }


} ?>
