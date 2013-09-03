
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
	
	
}

?>
<div class="container">
	<div id="main-content" class="main-content bg-white main-page">
	<div id="primary" class="content-area paypal-success">
		<div id="content" class="site-content" role="main">
		<i class="icon-remove-sign red"></i>
<h2>Paypal Payment Cancelled !</h2>
<span>Are you sure you want to cancel Paypal Payment ?<br>
Click the button below to confirm that you still wish to cancel</span>
		<hr>
<a href="#" class="btn green-btn" style="display: block;"> Cancel</a>		

		</div><!-- #content -->
	</div><!-- #primary -->
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>