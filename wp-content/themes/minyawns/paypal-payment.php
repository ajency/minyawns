<?php

/*
 * Template Name: Paypal Payment
 */


global $minyawn_job;
global $wpdb;


$return_url = 'http://www.minyawns.ajency.in/success-payment/';
$cancel_url = 'http://www.minyawns.ajency.in/cancel-payment/'."?mntx=".$_POST['custom']."&jb=".$_POST['amount']."&amnt=".$_POST['amount'];
$notify_url = 'http://www.minyawns.ajency.in/paypal-payments/';
$paypal_email = 'parag0246@yahoo.co.in';


// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){

	// Firstly Append paypal account to querystring
	 
	$querystring .= "?business=".urlencode($paypal_email)."&";	
	
	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}
	
	 
	 
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."& ";
	$querystring .= "notify_url=".urlencode($notify_url)."& ";
	$querystring .= "currency_code=USD";
	
	
	// Redirect to paypal IPN
	//echo "location:https://www.sandbox.paypal.com/cgi-bin/webscr".$querystring;
	header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	exit();

}
else
{
	
			if( (isset($_POST["txn_id"])) && (isset($_POST["custom"])) )
			{	
				update_paypal_payment($_POST["txn_id"],$_POST["custom"],'',$_POST['item_number']);
				
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
				
				if(($data['payment_status']=="Completed") )
				{
					  
					update_paypal_payment($data['txn_id'],$data['custom'] ,$data['payment_status'],$data['item_number']);
					  	 
					/*add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
					wp_mail('paragredkar@gmail.com', "verified",  $req.'curl result'.$curl_result );*/
					
					
					
					
					
					
					
					$job_data = get_post($data['item_humber']);
					
					
					
					
					
					$receiver_subject = "Minyawns - Payment successfull for ".$data['item_name']." job";
					$receiver_message.="Hi,<br/><br/>
							item num ".$data['item_number']."
							Payment for '".$data['item_name']."' successfully transferred .
							<br/><b>Transaction ID  :</b> ".$data['txn_id']."
							<br/><b>Job    			:</b> ".$data['item_name']."
							<br/><b>Total Amount 			:</b> ".$data['total_amount']."
							<br/><b>Start date:</b>". date('d M Y',   get_post_meta($data['item_humber'],'job_start_date',true))."
							<br/><b>Start Time:</b>". date('g:i a',  get_post_meta($data['item_humber'],'job_start_time',true))."
							<br/><b>End Date:</b>". date('d M Y',  get_post_meta($data['item_humber'],'job_end_date',true))."
							<br/><b>end Time:</b>". date('g:i a',  get_post_meta($data['item_humber'],'job_end_time',true))."							 
							<br/><b>Location:</b>". get_post_meta($data['item_humber'],'job_location',true)."
							<br/><b>Wages:</b>".get_post_meta($data['item_humber'],'job_wages',true)."
							<br/><b>details:</b>".$job_data->post_content."		
									
									
							<br/><br/><br/>
							";
					
					
					
					
					
					add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
					$headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
					wp_mail($data['receiver_email'], $receiver_subject, email_header() . $receiver_message . email_signature(), $headers);
					
					$sender_subject = "Minyawns - Payment successfull for ".$data['item_name']." job";
					$sender_message.="Hi,<br/><br/>
				
							Your Payment for '".$data['item_name']."' successfully Completed .
							<br/><b>Transaction ID :</b> ".$data['txn_id']."
							<br/><b>Total Amount 			:</b> ".$data['total_amount']."
							<br/><b>Job    		   :</b> ".$data['item_name']."
							<br/><b>Start date:</b>". date('d M Y',   get_post_meta($data['item_humber'],'job_start_date',true))."
							<br/><b>Start Time:</b>". date('g:i a',  get_post_meta($data['item_humber'],'job_start_time',true))."
							<br/><b>End Date:</b>". date('d M Y',  get_post_meta($data['item_humber'],'job_end_date',true))."
							<br/><b>end Time:</b>". date('g:i a',  get_post_meta($data['item_humber'],'job_end_time',true))."							 
							<br/><b>Location:</b>". get_post_meta($data['item_humber'],'job_location',true)."
							<br/><b>Wages:</b>".get_post_meta($data['item_humber'],'job_wages',true)."
							<br/><b>details:</b>".$job_data->post_content."		
					
							<br/><br/><br/>
							";
						
					add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
					$headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
					wp_mail($data['payer_email'], $sender_subject, email_header() . $sender_message . email_signature(), $headers);
					
							
				}
				
		
			}
			else if($curl_result=="Failed")
			{
				 
				
				update_paypal_payment($data['txn_id'],$data['custom'] ,$data['payment_status'],$data['item_number']);
				
				
				
				
				$receiver_subject = "Minyawns - Payment Failed for ".$data['item_name']." job";
				$receiver_message.="Hi,<br/><br/>
				
							Payment failed for '".$data['item_name']."'.
							<br/><b>Transaction ID  :</b> ".$data['txn_id']."
							<br/><b>Total Amount 			:</b> ".$data['total_amount']."	
							<br/><b>Job    			:</b> ".$data['item_name']."							
							<br/><b>Start date:</b>". date('d M Y',   get_post_meta($data['item_humber'],'job_start_date',true))."
							<br/><b>Start Time:</b>". date('g:i a',  get_post_meta($data['item_humber'],'job_start_time',true))."
							<br/><b>End Date:</b>". date('d M Y',  get_post_meta($data['item_humber'],'job_end_date',true))."
							<br/><b>end Time:</b>". date('g:i a',  get_post_meta($data['item_humber'],'job_end_time',true))."							 
							<br/><b>Location:</b>". get_post_meta($data['item_humber'],'job_location',true)."
							<br/><b>Wages:</b>".get_post_meta($data['item_humber'],'job_wages',true)."
							<br/><b>details:</b>".$job_data->post_content."		
					
							<br/><br/><br/>
							";
					
				add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
				$headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
				wp_mail($data['receiver_email'], $subject, email_header() . $receiver_message . email_signature(), $headers);
					
					
				$sender_subject = "Minyawns - Payment Failed for ".$data['item_name']." job";
				$sender_message.="Hi,<br/><br/>
				
							Your Payment failed for '".$data['item_name']."'.
							<br/><b>Transaction ID  	:</b> ".$data['txn_id']."
							<br/><b>Job    				:</b> ".$data['item_name']."
							<br/><b>Amount 				:</b> ".$data['total_amount']."
			
							<br/><br/><br/>
							";
				
				add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
				$headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
				wp_mail($data['payer_email'], $sender_subject, email_header() . $sender_message . email_signature(), $headers);
					
				exit();
			}




	
	
}


get_header();
 

?>
 

<div class="container">
    
</div>


 
<?php
get_footer();