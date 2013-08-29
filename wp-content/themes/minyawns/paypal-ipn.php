<?php

/**
 * Template Name: Paypal IPN
 */

/*
 PAYPAL IPN SCRIPT

*/


//echo "test";
 
mail("parag@ajency.in", "IPN test01---minyawns", "test01".'<br/><br/>response data :-'.$response_data , "From: parag@ajency.in" );
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



//$url = 'https://www.sandbox.paypal.com/webscr';
//$url = $paypal_adr;
//$url = "https://www.paypal.com/cgi-bin/webscr";
$url = 'https://www.paypal.com/webscr';
$curl_result=$curl_err='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
curl_setopt($ch, CURLOPT_HEADER , 0);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$curl_result = @curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

$response_data = var_dump($curl_result);

$req = str_replace("&", "\n", $req);
if ($curl_result== "VERIFIED") 
{
	 
	$mail_data = "\n\nPaypal Verified OK";
	
	$payment_status = trim($_POST['payment_status']);	
	$txn_id = trim($_POST['txn_id']);
	$receiver_email = trim($_POST['receiver_email']);
	$currency_type = trim($_POST['mc_currency']);
	$tax = trim($_POST['tax']);
	$shipping = trim($_POST['shipping']);
	$item_name = trim($_POST['item_name']);
	$item_number = trim($_POST['item_number']);
	$receiver_id = trim($_POST['receiver_id']);
	$payer_email = trim($_POST['payer_email']);
	
	$amount = trim($_POST['mc_fee']);
	//$mc_gross = $_POST['mc_gross'];
	$mc_gross1	 = trim($_POST['mc_gross1']);
	
	//$total_amount = $amount + $tax;
	$total_amount = trim($_POST['mc_gross']);
	
	/*if(($payment_status=="Completed") && ($item_name="Seven Day Fitness Trial")   && ($total_amount!="")  && ( ($receiver_id=="WHB48PZ23L4PN") || ($receiver_id=="wesley_virgin@yahoo.com") ))
	{
 		//if($currency_type=="USD")
			
		global $wpdb;				
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
		}
				
					
				
			 
		 
	}*/
	
	
 	foreach($_POST as $key => $value)
	{
		$mail_data.=$key." = ". $value."<br/>";
	}
	mail("parag_redkar@rediffmail.com", "IPN test2---minywans", "$mail_data".'<br/><br/>response data :-'.$response_data , "From: parag@ajency.in" ); 
}
else
{
	$req .= "\n\nData NOT verified from Paypal!";
	
	
	$payment_status = trim($_POST['payment_status']);
	$txn_id = trim($_POST['txn_id']);
	$receiver_email = trim($_POST['receiver_email']);
	$currency_type = trim($_POST['mc_currency']);
	$tax = trim($_POST['tax']);
	$shipping = trim($_POST['shipping']);
	$item_name = trim($_POST['item_name']);
	$item_number = trim($_POST['item_number']);
	$receiver_id = trim($_POST['receiver_id']);
	$payer_email = trim($_POST['payer_email']);
	
	$amount = trim($_POST['mc_fee']);
	//$mc_gross = $_POST['mc_gross'];
	$mc_gross1	 = trim($_POST['mc_gross1']);
	
	//$total_amount = $amount + $tax;
	$total_amount = trim($_POST['mc_gross']);
	
	$SUBJECT = 'FAILED Ver---minyawns';
	$BODY    = 'SECURITY CHECK FAILED TO VERIFY---minyawns';
	$BODY .= print_r($_POST, true);
	//$BODY .= "Expected $_EXPECTED but found $_RESULTS instead";
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	wp_mail('parag_redkar@rediffmail.com', $SUBJECT,  $BODY.'<br/><br/>response data :-'.$response_data );
	
	 //mail("parag@ajency.in", "__IPN test4.3", "$req", "From: parag@ajency.in" );
	exit();
}





