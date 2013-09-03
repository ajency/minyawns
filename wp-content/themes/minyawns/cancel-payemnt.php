
<?php

/*
 * Template Name: Cancel Payment
 */

get_header(); 


if(isset($_GET['mntx']))
{
	$minyawns_tx = $_GET['mntx'];
	$jobid = $_GET['jb'];
	
	
	
	global $wpdb;
	$paypal_tx  = $wpdb->get_results("SELECT meta_value as paypal_payment FROM {$wpdb->prefix}postmeta WHERE meta_key ='paypal_payment' and post_id ='".$jobid."' AND meta_value like '%".$minyawns_tx."%'  ");
		
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
				$new_paypal_payment['status'] = "canceled" ;
				break;
			case 'minyawns_selected'				:
				$new_paypal_payment['minyawns_selected'] = $payment_tx ;
				break;
		}//end switch($key_pp)
	
	}//end foreach($paypal_payment as $key_pp => $payment_tx)
	
	
	
	//update postmeta for the job with transaction id
	$new_updated_paypal_payment =   serialize($new_paypal_payment);
	$wpdb->get_results("update {$wpdb->prefix}postmeta  set meta_value = '".$new_updated_paypal_payment."' WHERE post_id = ".$jobid." and meta_key ='paypal_payment'  AND    meta_value like '%".$minyawns_tx."%'");
	
	
	
	
	$split_user = explode(",", $new_paypal_payment['minyawns_selected']);
	for ($i = 0; $i < sizeof($split_user); $i++)
	{
	 
	// for ($j = 0; $j < sizeof($split_status); $j++) {
	
	$wpdb->get_results("
	UPDATE {$wpdb->prefix}userjobs
	SET status = 'applied'
	WHERE user_id = '" . $split_user[$i] . "'
	AND job_id = '" . $jobid . "'
	"
	);
	}
	
	
	
	
	
	
	
	
	$job_data = get_post($jobid);
		
		
	$employer_id = $job_data->post_author;
	$employer_data = get_userdata($employer_id);

	
		
	$subject = "Minyawns - Paypal payment is cancelled for '".$job_data->post_title."'";
	$message.="Hi,<br/><br/>
				
							Paypal Payment is cancelled for  the job '".$job_data->post_title."'.
							<br/><b>Amount:</b>". $_GET['amnt']."
							<br/><b>Start date:</b>". date('d M Y',   get_post_meta($jobid,'job_start_date',true))."
							<br/><b>Start Time:</b>". date('g:i a',  get_post_meta($jobid,'job_start_time',true))."
							<br/><b>End Date:</b>". date('d M Y',  get_post_meta($jobid,'job_end_date',true))."
							<br/><b>end Time:</b>". date('g:i a',  get_post_meta($jobid,'job_end_time',true))."
							<br/><b>Location:</b>". get_post_meta($jobid,'job_location',true)."
							<br/><b>Wages:</b>".get_post_meta($jobid,'job_wages',true)."
							<br/><b>details:</b>".$job_data->post_content."
							<br/><br/><br/>
							";
		
	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
	wp_mail($employer_data->user_email, $subject, email_header() . $message . email_signature(), $headers);
		
	
	
	
	
	
	
}

?>
<div class="container">
	<div id="main-content" class="main-content bg-white main-page">
	<div id="primary" class="content-area paypal-success">
		<div id="content" class="site-content" role="main">
		<i class="icon-remove-sign red"></i>
<h2>Paypal Payment Cancelled !</h2>
<span>Please click below to browse jobs and hire minyawns for the jobs<br>
</span>
		<hr>
<a href="<?php echo site_url()?>/jobs/" class="btn green-btn" style="display: block;"> Jobs</a>		

		</div><!-- #content -->
	</div><!-- #primary -->
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>