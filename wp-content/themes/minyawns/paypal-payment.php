<?php

/*
 * Template Name: Paypal Payment
 */


global $minyawn_job;
global $wpdb;
//$item_number = $_POST['item_number'];
/*$paypal_email = $_POST['payer_email'];
$item_amount = $_POST['total_amount'];
$return_url = $_POST['returnUrl'];
$cancel_url = $_POST['cancelUrl'];
$notify_url = $_POST['notify_url'];*/

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){

	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";	
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	//$querystring .= "item_number=".urlencode($item_name)."&";
	//$querystring .= "amount=".urlencode($item_amount)."&";
	
	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}
	
	// Append paypal return addresses
	/*$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	*/
	// Append querystring with custom field
	//$querystring .= "&custom=".USERID;
	
	// Redirect to paypal IPN
	//echo "location:https://www.sandbox.paypal.com/cgi-bin/webscr".$querystring;
	header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	exit();

}
else
{
	
	
	
	
	
	
	
	
	function update_paypal_payment($transaction_id,$minyawns_tx_id,$status,$jobid)
	{
		$paypal_tx  = $wpdb->get_results("SELECT meta_value as paypal_payment FROM {$wpdb->prefix}postmeta WHERE meta_key ='paypal_payment' and post_id ='".$jobid."' AND meta_value like '%".$_POST["txn_id"]."%' and  meta_value like '%".$_POST["custom"]."%'");
		foreach($paypal_tx as $res)
		{
			$paypal_payment = unserialize($res->paypal_payment);
		}
		
		$new_paypal_payment = array();
		foreach($paypal_payment as $key_pp => $payment_tx)
		{
			switch($key_pp)
			{
				case 'minyawn_txn_id':
					$new_paypal_payment['minyawn_txn_id'] = $payment_tx ;
					break;
				case 'paypal_txn_id':
					$new_paypal_payment['paypal_txn_id'] = $transaction_id ;
					break;
				case 'status'				:
					$new_paypal_payment['paypal_txn_id'] = $status ;
					break;
			}//end switch($key_pp)
				
		}//end foreach($paypal_payment as $key_pp => $payment_tx)
		
		//update postmeta for the job with transaction id
		$new_paypal_payment_serialized = serialize($new_paypal_payment);
		
		$wpdb->get_results("update {$wpdb->prefix}postmeta  set paypal_payment = ".$new_paypal_payment_serialized." WHERE post_id = ".$jobid." and meta_key ='paypal_payment'  AND    meta_value like '%".$minyawns_tx_id."%'");
		
		
		
	}
	
	
			if( (isset($_POST["txn_id"])) && (isset($_POST["custom"])) )
			{	
				//update_paypal_payment($_POST["txn_id"],$_POST["custom"],$_POST["status"],$_POST["item_id"]);
				
				$SUBJECT = 'transaction check';
				$BODY    = 'Checking for transaction';
				$BODY .= print_r($_POST, true);				 
				add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
				wp_mail('paragredkar@gmail.com', $SUBJECT,  $BODY );
				
				
				
				
			}//end 	if( (isset($_POST["txn_id"])) && (isset($_POST["custom"])) )	
	
	
			// STEP 1: read POST data
			
			// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
			// Instead, read raw POST data from the input stream.
			$raw_post_data = file_get_contents('php://input');
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			
			foreach ($raw_post_array as $keyval) 
			{
				$keyval = explode ('=', $keyval);
				if (count($keyval) == 2)
					$myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
			
			
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) 
			{
				$get_magic_quotes_exists = true;
			}
			
			
			foreach ($myPost as $key => $value) 
			{
				if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) 
				{
					$value = urlencode(stripslashes($value));
				}
				else
				{
					$value = urlencode($value);
				}
				$req .= "&$key=$value";
			}
			
			
			
			$url = 'https://www.sandbox.paypal.com/webscr';
			//$url = $paypal_adr;
			//$url = "https://www.paypal.com/cgi-bin/webscr";
			//$url = 'https://www.paypal.com/webscr';
			$curl_result=$curl_err='';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req),'Host: www.sandbox.paypal.com'));
			curl_setopt($ch, CURLOPT_HEADER , 0);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$curl_result = @curl_exec($ch);
			$curl_err = curl_error($ch);
			curl_close($ch);
			
			$req = str_replace("&", "\n", $req);
			if ($curl_result== "VERIFIED") 
			{
				 
				$mail_data = "\n\nPaypal Verified OK";
				
				
				
				$data['receiver_id']			= $_POST['receiver_id'];
				$data['shipping']			= $_POST['shipping'];				
				$data['item_name']			= $_POST['item_name'];
				$data['item_number'] 		= $_POST['item_number'];
				$data['payment_status'] 	= $_POST['payment_status'];
				$data['payment_amount'] 	= $_POST['mc_gross'];
				$data['payment_currency']	= $_POST['mc_currency'];
				$data['txn_id']				= $_POST['txn_id'];
				$data['receiver_email'] 	= $_POST['receiver_email'];
				$data['payer_email'] 		= $_POST['payer_email'];
				$data['custom'] 			= $_POST['custom'];
	
	
				
				$data['mc_fee'] = trim($_POST['mc_fee']);
				//$mc_gross = $_POST['mc_gross'];
				$data['mc_gross1']	 = trim($_POST['mc_gross1']);
				
				//$total_amount = $amount + $tax;
				$data['total_amount'] = trim($_POST['mc_gross']);
				
				if(($payment_status=="Completed")      )
				{
					//if($currency_type=="USD")
						
					/*global $wpdb;				
					$new_user_table = $wpdb->base_prefix.'new_users';				
					// $is_registered = $wpdb->get_var("SELECT transaction_id FROM $new_user_table WHERE  transaction_type ='payment' and  email_id ='".$payer_email."' ");
					$is_registered = $wpdb->get_row($wpdb->prepare("SELECT transaction_id FROM $new_user_table WHERE  transaction_type ='payment' and  email_id ='".$payer_email."' and transaction_id ='".$txn_id."'  "));
					if(!$is_registered)
					{
						wv_update_new_user_table($payer_email, $txn_id ,'payment', $total_amount);
						
						$SUBJECT = 'Paypal Verified';
						$BODY    = 'Paypal verification for ipn is successfull';
						$BODY .= print_r($_POST, true);
						//$BODY .= "SELECT transaction_id FROM $new_user_table WHERE  transaction_type ='payment' and  email_id ='".$payer_email."' and transaction_id ='".$txn_id."'  ";
						//$BODY .= "Expected $_EXPECTED but found $_RESULTS instead";
						add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
						wp_mail('parag@ajency.in', $SUBJECT,  $BODY);					
						//mail("parag@ajency.in", "_IPN test4.3", "$req".$BODY, "From: parag@ajency.in" );
					}*/
					
					
					
					
							
					
					
					/*		// Used for debugging
							//@mail("you@youremail.com", "PAYPAL DEBUGGING", "Verified Response<br />data = <pre>".print_r($post, true)."</pre>");
									
							// Validate payment (Check unique txnid & correct price)
							$valid_txnid = check_txnid($data['txn_id']);
							$valid_price = check_price($data['payment_amount'], $data['item_number']);
							// PAYMENT VALIDATED & VERIFIED!
							if($valid_txnid && $valid_price)
							{				
								$orderid = updatePayments($data);		
								if($orderid)
								{					
									// Payment has been made & successfully inserted into the Database								
								}
								else
								{								
									// Error inserting into DB
									// E-mail admin or alert user
								}
							}//end if($valid_txnid && $valid_price)
							else
							{					
								// Payment made but data has been changed
								// E-mail admin or alert user
							}	
					
					*/
					/* #########################################################					
					if( (isset($_POST["txn_id"])) && (isset($_POST["custom"])) )
					{
						update_paypal_payment($_POST["txn_id"],$_POST["custom"],$_POST["status"],$_POST["item_id"]);
							
					}//end 	if( (isset($_POST["txn_id"])) && (isset($_POST["custom"])) )
					*/

					$ipn_data = print_r($data,true);
					add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
					wp_mail('paragredkar@gmail.com', $SUBJECT,  $ipn_data );
					
					
							
				}
				
		
			}
			else
			{
				$req .= "\n\nData NOT verified from Paypal!";
				
				$SUBJECT = 'FAILED Ver';
				$BODY    = 'SECURITY CHECK FAILED TO VERIFY';
				$BODY .= print_r($_POST, true);
				//$BODY .= "Expected $_EXPECTED but found $_RESULTS instead";
				//add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
				add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
				wp_mail('paragredkar@gmail.com', $SUBJECT,  $BODY );
				
				 //mail("parag@ajency.in", "__IPN test4.3", "$req", "From: parag@ajency.in" );
				exit();
			}




	
	
}


get_header();






?>
 

<div class="container">
    
</div>


 
<?php
get_footer();