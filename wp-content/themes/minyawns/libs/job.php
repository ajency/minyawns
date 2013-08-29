<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';


/** Update the profile data */
$app->post('/addjob', function() use ($app) {

            $requestBody = $app->request()->getBody();  // <- getBody() of http request
            $json_a = json_decode($requestBody, true);

            $postid = ($json_a['id']) > 0 ? $json_a['id'] : '';

            $post = array(
                'ID' => $postid,
                'post_author' => get_current_user_id(), //The user ID number of the author.
                'post_date' => date("Y-m-d H:i:s"), //The time post was made.
                'post_date_gmt' => date("Y-m-d H:i:s"), //The time post was made, in GMT.
                'post_status' => 'publish',
                'post_title' => $json_a['job_task'],
                'post_type' => 'job',
                'post_content' => $json_a['job_details']
            );

            $post_id = wp_insert_post($post);



            foreach ($json_a as $key => $value) {

                if ($key == 'job_tags') {
                    $tags = explode(",", $value);

                    if (isset($postid))
                        wp_delete_object_term_relationships($postid, 'job_tags');

                    for ($i = 0; $i < count($tags); $i++) {
                        wp_set_post_terms($post_id, $tags[$i], 'job_tags', true);
                    }
                } elseif ($key == "job_start_date") {
                    $start = $value;
                    update_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_start_time") {
                    // print_r($start);print_r($value);
                    $date = date("j-m-Y", strtotime($start));
                    $start_date_time = strtotime($date . $value); //print_r($value);
                    update_post_meta($post_id, $key, strtotime($value));
                    update_post_meta($post_id, 'job_start_date_time', $start_date_time);
                } elseif ($key == "job_end_date") {
                    $end = $value;
                    update_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_end_time") {
                    $date = date("j-m-Y", strtotime($end));
                    $end_date_time = strtotime($date . $value);
                    //print_r(date("j-m-Y",  strtotime($start)).$value);
                    update_post_meta($post_id, $key, strtotime($value));
                    update_post_meta($post_id, 'job_end_date_time', $end_date_time);
                } elseif ($key !== 'job_details') {
                    update_post_meta($post_id, $key, $value);
                }
            }


            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('success' => 1));
        });



$app->get('/fetchjobs/', function() use ($app) {

            //var_dump(strtotime(date("d-m-Y H:i:s","23 August, 2013 11:28:30")));exit();

            global $post, $wpdb;
            $prefix = $wpdb->prefix;
// AND $wpdb->postmeta.meta_key = 'job_start_date' 
            //AND $wpdb->postmeta.meta_value <= '" . current_time('timestamp') . "' 



            $current_user_id = get_current_user_id();
            if (isset($_GET['my_jobs'])) {

                if (get_user_role() == "employer") {

                    $tables = "$wpdb->posts";
                    $my_jobs_filter = "WHERE $wpdb->posts.post_author='" . get_current_user_id() . "' ";
                     $limit="LIMIT 10";
                } else {

                    $tables = "$wpdb->posts,{$wpdb->prefix}userjobs";
                    $my_jobs_filter = "WHERE $wpdb->posts.ID = {$wpdb->prefix}userjobs.job_id AND {$wpdb->prefix}userjobs.user_id='" . get_current_user_id() . "' AND {$wpdb->prefix}userjobs.status='applied' ";
                     $limit="LIMIT 10";
                }



                $data = array();
                $pageposts = $wpdb->get_results($querystr, OBJECT);
            } else {

                if (get_user_role() == "employer") {

                    $tables = "$wpdb->posts, $wpdb->postmeta";
                    $my_jobs_filter = "WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "' AND $wpdb->posts.post_author='" . get_current_user_id() . "'";
                     $limit="LIMIT " . $_GET['offset'] . ",2";
                } else {

                    $tables = "$wpdb->posts, $wpdb->postmeta";
                    $my_jobs_filter = "WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "'";
                    $limit="LIMIT " . $_GET['offset'] . ",2";
                }
            }

            $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $tables
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            ORDER BY $wpdb->posts.ID DESC
                            $limit
                         ";

            $data = array();
            $pageposts = $wpdb->get_results($querystr, OBJECT);

            $total = count(get_total_jobs());
            
            $no_of_pages=ceil($total/2);
            $has_more_results=0;
            foreach ($pageposts as $pagepost) {
                $tags = wp_get_post_terms($pagepost->ID, 'job_tags', array("fields" => "names"));
                //print_r(implode(",",$tags));exit();
                $post_meta = get_post_meta($pagepost->ID);


                $min_job = new Minyawn_Job($pagepost->ID);

                $minyawns_have_applied = $min_job->get_applied_by();
                $user_data = array();
                $user_image=array();
                foreach ($min_job->minyawns as $min) {
                    $user = array_push($user_data, $min['profile_name']);
                    $user_profileimage=array_push($user_image,get_user_company_logo($min['user_id']));
                   
                }

                $applied = $min_job->check_minyawn_job_status($pagepost->ID);
                

        if ((int) ($min_job->required_minyawns)+2 <= count($min_job->minyawns))
            $applied = 2;

                if($total <= $_GET['offset']+2){ 
                    $show_load=1;
                }
                else{
                    $show_load=0;
                }
                 $has_more_results++;
                  $data[] = array(
                    'post_name' => $pagepost->post_title,
                    'post_date' => $pagepost->post_date,
                    'post_title' => $pagepost->post_title,
                    'post_id' => $pagepost->ID,
                    'job_start_date' => date('d M Y', $post_meta['job_start_date'][0]),
                    'job_end_date' => date('d M Y', strtotime($post_meta['job_end_date'][0])),
                    'job_day' => date('l', $post_meta['job_start_date'][0]),
                    'job_wages' => $post_meta['job_wages'][0],
                    'job_progress' => 'available',
                    'job_start_day' => date('d', $post_meta['job_start_date'][0]),
                    'job_start_month' => date('F', $post_meta['job_start_date'][0]),
                    'job_start_year' => date('Y', $post_meta['job_start_date'][0]),
                    'job_start_meridiem' => date('a', $post_meta['job_start_time'][0]),
                    'job_end_meridiem' => date('a', $post_meta['job_end_time'][0]),
                    'job_start_time' => date('g:i', $post_meta['job_start_time'][0]),
                    'job_end_time' => date('g:i', $post_meta['job_end_time'][0]),
                    'job_location' => $post_meta['job_location'][0],
                    'job_details' => $pagepost->post_content,
                    'tags' => $tags,
                    'tags_count' => sizeof($tags),
                    'job_author' => get_the_author_meta('display_name', $pagepost->post_author),
                    'job_author_logo' => get_user_company_logo($pagepost->post_author),
                    'can_apply_job' => $applied,
                    'user_job_status' => is_null($min_job->is_hired) ? $min_job->is_hired : 'can_apply',
                    'job_end_time_check' => $post_meta['job_end_date_time'][0],
                    'todays_date_time' => current_time('timestamp'),
                    'post_slug' => wp_unique_post_slug($pagepost->post_name, $pagepost->ID, 'published', 'job', ''),
                    'users_applied' => $user_data,
                    'minyawns_have_applied' => $minyawns_have_applied,
                    'load_more'=>$show_load,
                     'user_profile_image'=>$user_image,
                      'default_user_avatar'=>get_avatar($pagepost->ID)
                        );
            }

           
            $app->response()->header("Content-Type", "application/json");
            echo json_encode($data);
        });

$app->post('/fetchjobscalendar/', function() use ($app) {
            global $post, $wpdb;
            $prefix = $wpdb->prefix;
// AND $wpdb->postmeta.meta_key = 'job_start_date' 
            //AND $wpdb->postmeta.meta_value <= '" . current_time('timestamp') . "' 

            $current_user_id = get_current_user_id();
            if (isset($_GET['my_jobs'])) {
                $tables = "$wpdb->posts, $wpdb->postmeta,{$wpdb->prefix}userjobs";
                $my_jobs_filter = "WHERE $wpdb->posts.post_author = $current_user_id  AND $wpdb->posts.ID = {$wpdb->prefix}userjobs.job_id AND {$wpdb->prefix}userjobs.job_id = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date'";
            } else {
                $tables = "$wpdb->posts, $wpdb->postmeta";
                $my_jobs_filter = "WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            AND $wpdb->postmeta.meta_value >= '" . strtotime(date('1-m-Y', strtotime('this month'))) . "'";
                //AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "'
            }

            $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $tables
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            ORDER BY $wpdb->posts.ID DESC
                            
                         ";


            $data = array();
            $data['events'][] = array();
            $attendes = array();
            $emails = array();
            $gmtTimezone = new DateTimeZone('IST');
            $pageposts = $wpdb->get_results($querystr, OBJECT);
            $cnt = count($pageposts);
            foreach ($pageposts as $pagepost) {
                $tags = wp_get_post_terms($pagepost->ID, 'job_tags', array("fields" => "names"));
                //print_r(implode(",",$tags));exit();
                $post_meta = get_post_meta($pagepost->ID);

                $fullday = 0;

                $location = isset($post_meta['job_location'][0]) ? $post_meta['job_location'][0] : '';
                $tags = implode(",", $tags);
                $wages = isset($post_meta['job_wages'][0]) ? $post_meta['job_wages'][0] : '';
                $details = isset($pagepost->post_content) ? $pagepost->post_content : '';
                $apply = true;
                $logo = get_avatar($pagepost->post_author, '10');

                // print_r($post_meta['job_start_date_time'][0]);exit();
                $st = date('d M Y H:i:s', $post_meta['job_start_date_time'][0]);
                $et = date('d M Y H:i:s', $post_meta['job_end_date_time'][0]);
                //$et='';
                $role = get_user_role($current_user_id);
                $data['events'][] = array(
                    rand(10000, 99999),
                    $pagepost->post_name,
                    $st,
                    $et,
                    $fullday,
                    0, //more than one day event
                    0, //Recurring event
                    rand(-1, 13),
                    0, //editable,
                    $location, //location
                    $tags, //attends
                    $details,
                    $wages,
                    $apply,
                    $logo,
                    $role
                );
            }
            //$app->response()->header("Content-Type", "application/json");
            echo json_encode($data);
        });

$app->post('/confirm', function() use ($app) {

            global $wpdb;
            $split_user = explode("-", $_POST['status']);
            for ($i = 0; $i < sizeof($split_user); $i++) {

                $split_status = explode(",", $split_user[$i]);
                // for ($j = 0; $j < sizeof($split_status); $j++) {

                $wpdb->get_results(
                        "
	UPDATE {$wpdb->prefix}userjobs 
	SET status = '" . $split_status[1] . "'
	WHERE user_id = '" . $split_status[0] . "' 
		AND job_id = '" . $_POST['job_id'] . "'
	"
                );
                // }
            }

            /*aded on 28aug2013*/
            
            
            $inc = 0;
            if(require_once('../adaptive_paypal/samples/PPBootStrap.php'))
            	$inc = 1;
            require_once('../adaptive_paypal/samples/Common/Constants.php');
            define("DEFAULT_SELECT", "- Select -");
             
            
            
            //get user
            $users__ = explode(",", $_POST['user_id']);
            //end get user
            
            
            if(isset($_POST['jobwages']))
            {
            	$single_wages = $_POST['jobwages'];
            }
             
            
             
            
            $cnt_users = 0 ;
            foreach($users__ as $user___)
            {  	if($user___!="")
            	{
            
            	//check if the user is already hired. if already hired do not add wages for the selected user
            	/*$querystr = "
            		SELECT count(*) as user_hired from ".$wpdb->prefix."userjobs
            		 where job_id = ".$_POST['job_id']." and user_id = $user___";
            	            
            	$users_already_hired = $wpdb->get_results($querystr, OBJECT);
				foreach($users_already_hired as $hired_user_check)
					if($hired_user_check->user_hired <=0)*/
            			$cnt_users++;
            
            
           		 }
           		 
           		 $html.=$querystr.''.$users_already_hired['user_hired'];
            }
            $total_wages = $cnt_users * $single_wages;
            //  echo "total wages ".$total_wages;
            // echo "<br/> single ".$_REQUEST['hdn_jobwages'];
            
            if($cnt_users>0)
            {
            	$receiver = array();
            	$receiver = new Receiver();
            	$receiver->email = 'parag@ajency.in';
            	$receiver->amount = $total_wages;
            	$receiverList = new ReceiverList($receiver);
            }
            $payRequest = new PayRequest(new RequestEnvelope("en_US"), $_POST['actionType'], $_POST['cancelUrl'], $_POST['currencyCode'], $receiverList, $_POST['returnUrl']);
            $payRequest->ipnNotificationUrl ='http://www.minyawns.ajency.in/paypal-ipn/';
            
            
            /* $html.="action :".$_POST['actionType'];
             $html.="cancelurl :".$_POST['cancelUrl'];
            $html.="currencycode :".$_POST['currencyCode'];
            $html.="returnurl :".$_POST['returnUrl'];
            $html.="wages :".$_POST['jobwages'];
            */
            
            /*
             * 	 ## Creating service wrapper object
            Creating service wrapper object to make API call and loading
            Configuration::getAcctAndConfig() returns array that contains credential and config parameters
            */
            $service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
            try {
            	/* wrap API method calls on the service object with a try catch */
            	$response = $service->Pay($payRequest);
            } catch(Exception $ex) {
            	require_once '../adaptive_paypal/samples/Common/Error.php';
            	exit;
            }
            /* Make the call to PayPal to get the Pay token
             If the API call succeded, then redirect the buyer to PayPal
            to begin to authorize payment.  If an error occured, show the
            resulting errors */
            
            
            
            
            
            
            $ack = strtoupper($response->responseEnvelope->ack);
            if($ack != "SUCCESS") {
            	$html.="<b>Error </b>";
            	$html.="<pre>";
            	$html.="</pre>";
            } else
            {
            	$payKey = $response->payKey;
            	
            	$paypal_payment = array('pay_key'=>$payKey,'status'=>'');
            	update_post_meta($_POST['job_id'], 'paypal_payment', $paypal_payment);
            	
            	$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
            
            	 
            	 
            
            	$html.='<script src="https://www.paypalobjects.com/js/external/dg.js" type="text/javascript"></script>';
            	$html.='<form action="https://www.sandbox.paypal.com/webapps/adaptivepayment/flow/pay" target="PPDGFrame" class="standard">';
            	$html.= "<table>
            	<tr>
            	<td colspan='2' >Minyawns</td>
            	</tr>
            	 
            	<tr>
            	<td >Pay Key</td>
            	<td>$payKey</td>
            	</tr>
            	<tr>
            	<td >Amount</td>
            	<td>$total_wages</td>
            	</tr>
            	";
            
            	$html.= "</table>";
            	 
            	$html.='<input type="image" id="submitBtn" value="Pay with PayPal" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif">';
	            $html.='<input id="type" type="hidden" name="expType" value="light">';
	            $html.='<input id="paykey" type="hidden" name="paykey" value="'.$payKey.'">';
	            $html.='</form>';
            	            		 
            	            $html.='<script type="text/javascript" charset="utf-8">var embeddedPPFlow = new PAYPAL.apps.DGFlow({trigger: \'submitBtn\'});
</script>';
            }
       
            echo json_encode(array('user_ids'=>$_POST['user_id'],'content'=>$html,'inc'=>$inc));
            
            
            
            
            
            /*end added on 29aug2013 */
            
            
            
        });



$app->run();