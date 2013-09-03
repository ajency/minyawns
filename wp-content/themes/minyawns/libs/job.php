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
                    $limit = "LIMIT 10";
                    $order_by="ORDER BY $wpdb->posts.ID DESC";
                } else {

                    $tables = "$wpdb->posts,{$wpdb->prefix}userjobs";
                    $my_jobs_filter = "WHERE $wpdb->posts.ID = {$wpdb->prefix}userjobs.job_id AND {$wpdb->prefix}userjobs.user_id='" . get_current_user_id() . "' AND {$wpdb->prefix}userjobs.status='applied' ";
                    $limit = "LIMIT 10";
                    $order_by="ORDER BY $wpdb->posts.ID DESC";



                    $end = end((explode('/', rtrim($_SERVER['REQUEST_URI'], '/'))));

                    if (is_numeric($end)) {

                        $tables = "";
                        $my_jobs_filter = "";
                        $limit = "";
                    }
                }



                $data = array();
                $pageposts = $wpdb->get_results($querystr, OBJECT);
            } else {

                if (get_user_role() == "employer") {

                    $tables = "$wpdb->posts, $wpdb->postmeta";
                    $my_jobs_filter = "WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date' 
                             AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "'";
                    $limit = "LIMIT " . $_GET['offset'] . ",5";
                    $order_by="AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            ORDER BY $wpdb->postmeta.meta_value DESC";
                } else {


                    $tables = "$wpdb->posts, $wpdb->postmeta";
                    $my_jobs_filter = "WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "'";
                    $limit = "LIMIT " . $_GET['offset'] . ",5";
                    $order_by="AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            ORDER BY $wpdb->postmeta.meta_value DESC";
                }
            }

            $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $tables
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            $order_by
                            $limit
                         ";

            $data = array();
            $pageposts = $wpdb->get_results($querystr, OBJECT);

            $total = count(get_total_jobs());

            $no_of_pages = ceil($total / 5);
            
            $has_more_results = 0;
            foreach ($pageposts as $pagepost) {

                $is_job_owner = is_job_owner(get_user_id(), $pagepost->ID);


                $tags = wp_get_post_terms($pagepost->ID, 'job_tags', array("fields" => "names"));
                //print_r(implode(",",$tags));exit();
                $post_meta = get_post_meta($pagepost->ID);


                $min_job = new Minyawn_Job($pagepost->ID);

                $minyawns_have_applied = $min_job->get_applied_by();



                $user_data = array();
                $user_image = array();
                $user_id_applied = array();
                $user_rating_like=array();
                $user_rating_dislike=array();
                foreach ($min_job->minyawns as $min) {
                    $user = array_push($user_data, $min['profile_name']);
                    $user_profileimage = array_push($user_image, get_user_company_logo($min['user_id']));
                    $applied_user_id = array_push($user_id_applied, $min['user_id']);



                    $sql = $wpdb->prepare("SELECT {$wpdb->prefix}userjobs.user_id,{$wpdb->prefix}userjobs.job_id, SUM( if( rating =1, 1, 0 ) ) AS positive, SUM( if( rating = -1, 1, 0 ) ) AS negative
                              FROM {$wpdb->prefix}userjobs
                              WHERE {$wpdb->prefix}userjobs.user_id = %d AND {$wpdb->prefix}userjobs.job_id
                              GROUP BY {$wpdb->prefix}userjobs.user_id", $min['user_id'], $pagepost->ID);

                    $minyawns_rating = $wpdb->get_results($sql);

                    foreach ($minyawns_rating as $rating) {
                        $user_rating = array_push($user_rating_like, $rating->positive);
                        $user_dislike =array_push($user_rating_dislike,$rating->negative);
                        //$user['dislike'] = $rating->negative;

                        if ($user['like'] != "0" || $user['dislike'] != "0")
                            $user['is_job_rated'] = 1;
                        else
                            $user['is_job_rated'] = 0;
                            
                    }
                   
                }

                $applied = $min_job->check_minyawn_job_status($pagepost->ID);


                if ((int) ($min_job->required_minyawns) + 2 <= count($min_job->minyawns))
                    $applied = 2;

                if ($total <= $_GET['offset'] + 5) {
                    $show_load = 1;
                } else {
                    $show_load = 0;
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
                    'job_author_id' => get_the_author_meta('ID', $pagepost->post_author),
                    'job_author_logo' => get_user_company_logo($pagepost->post_author),
                    'can_apply_job' => $applied,
                    'user_job_status' => is_null($min_job->is_hired) ? $min_job->is_hired : 'can_apply',
                    'job_start_date_time' => $post_meta['job_start_date'][0],
                    'job_end_time_check' => $post_meta['job_start_date_time'][0],
                    'job_end_date_time_check' => $post_meta['job_end_date_time'][0],
                    'job_start_date_time_check' => $post_meta['job_start_date_time'][0],
                    'todays_date_time' => current_time('timestamp'),
                    'post_slug' => wp_unique_post_slug($pagepost->post_name, $pagepost->ID, 'published', 'job', ''),
                    'users_applied' => $user_data,
                    'minyawns_have_applied' => $minyawns_have_applied,
                    'load_more' => $show_load,
                    'user_profile_image' => $user_image,
                    'user_rating_like'=>$user_rating_like,
                    'user_rating_dislike'=>$user_rating_dislike,
                    'default_user_avatar' => get_avatar($pagepost->ID),
                    'is_job_owner' => $is_job_owner,
                    'applied_user_id' => $user_id_applied
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
                $min_job = new Minyawn_Job($pagepost->ID);
                $applied = $min_job->check_minyawn_job_status($pagepost->ID);

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
                    $pagepost->ID,
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
                    $role,
                    $applied,
                );
            }
            //$app->response()->header("Content-Type", "application/json");
            echo json_encode($data);
        });

$app->post('/confirm', function() use ($app) {

            global $wpdb;
            $split_user = explode("-", $_POST['status']);
            for ($i = 0; $i < sizeof($split_user); $i++) 
            {

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
                
                
                
                
                ////to do
                $job_metadata = get_post_meta($_POST['job_id']);  
                $job_data = get_post($_POST['job_id']);
                $t=print_r($job_metadata,true);
                
				//get minyawn email id
                $minyawns_data = get_userdata($split_status[0]);
               
                //Send mail to minyawns
                $minyawns_subject ="Minyawns - You have been hired for ".get_the_title($_POST['job_id']);
                $minyawns_message = "Hi,<br/><br/>
                		Congratulations, You have been hired for the job '".get_the_title($_POST['job_id'])."'<br/><br/>
                		<h6>Job:".get_the_title($_POST['job_id'])."</h6>
                				
                		<br/><b>Start date:</b>". date('d M Y',  $job_metadata->job_start_date)."
                		<br/><b>Start Time:</b>". date('g:i',  $job_metadata->job_start_time)."
                		<br/><b>End Date:</b>". date('d M Y',  $job_metadata->job_end_date)."
					    <br/><b>end Time:</b>". date('g:i',  $job_metadata->job_end_time)."
                				
                		<br/><b>Location:</b>". $job_metadata->job_location."	
						<br/><b>Wages:</b>". $job_metadata->job_wages."	
                		<br/><b>details:</b>".$job_data->post_content."
                				
                		<br/><br/>
                		
                		";
                
                
                
                
                
                
                
                
                
             /*  'job_start_date' => date('d M Y', $post_meta['job_start_date'][0]),
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
                
                */
                
                add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
                $headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
                wp_mail($minyawns_data->user_email,  $minyawns_subject, email_header() . $minyawns_message . email_signature(), $headers);
                
                
                // }
            }
            
            
            
            
            

            /* aded on 1sep2013 */









            $salt_job = wp_generate_password(20); // 20 character "random" string
            $key_job = sha1($salt . $_POST['job_id'] . uniqid(time(), true));
 
            $paypal_payment = array('minyawn_txn_id'=>$key_job,'paypal_txn_id'=>'','status'=>'','minyawns_selected'=>$split_user);
            add_post_meta($_POST['job_id'], 'paypal_payment' , $paypal_payment);
            
            
 
            //get user
            $users__ = explode(",", $_POST['user_id']);
            //end get user

            /*
              if (isset($_POST['jobwages'])) {
              $single_wages = $_POST['jobwages'];
              }





              $cnt_users = 0;
              foreach ($users__ as $user___) {
              if ($user___ != "") {

              //check if the user is already hired. if already hired do not add wages for the selected user
              /* $querystr = "
              SELECT count(*) as user_hired from ".$wpdb->prefix."userjobs
              where job_id = ".$_POST['job_id']." and user_id = $user___";

              $users_already_hired = $wpdb->get_results($querystr, OBJECT);
              foreach($users_already_hired as $hired_user_check)
              if($hired_user_check->user_hired <=0) * /
              $cnt_users++;
              }

              $html.=$querystr . '' . $users_already_hired['user_hired'];

              }
              $total_wages = $cnt_users * $single_wages;

             */
            $total_wages = trim($_POST['jobwages']);
            $returnUrl = $_POST['returnUrl'];
            $cancelUrl = $_POST['cancelUrl'];



            $html.='<form class="paypal" action="' . site_url() . '/paypal-payments/" method="post" id="paypal_form" target="_blank">
				<input type="hidden" name="cmd" value="_xclick" />
			    <input type="hidden" name="no_note" value="1" />
            	<input type="hidden" name="custom" value="' . $key_job . '" />
			    <input type="hidden" name="lc" value="UK" />
			   
			    <input type="hidden" name="amount" value="' . $total_wages . '" />
			    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
 
			    <input type="hidden" name="first_name" value="Customer  First Name"  />
			    <input type="hidden" name="last_name" value="Customer  Last Name"  />			    
			    <input type="hidden" name="item_number" value="' . $_POST['job_id'] . '" / >
			    <input type="hidden" name="item_name" value="' . get_the_title($_POST['job_id']) . '" / >			   
 
			    
			   
           	<input type="submit" id="submitBtn" value=" " style="margin:auto; width:140px; height:47px; border:none; display:block;background-image:url(\'https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif\');" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif">
           	</form>
           	';








            echo json_encode(array('user_ids' => $_POST['user_id'], 'content' => $html, 'inc' => $inc));





            /* end added on 1sep2013 */
        });


$app->post('/user-vote', function() use ($app) {
            global $wpdb;
            $wpdb->get_results(
                    "
	UPDATE {$wpdb->prefix}userjobs 
	SET rating = '" . trim($_POST['rating']) . "'
	WHERE user_id = '" . $_POST['user_id'] . "' 
		AND job_id = '" . $_POST['job_id'] . "'
	"
            );

        /* to calculate total ratings*/
           $sql = $wpdb->prepare("SELECT {$wpdb->prefix}userjobs.user_id,{$wpdb->prefix}userjobs.job_id, SUM( if( rating =1, 1, 0 ) ) AS positive, SUM( if( rating = -1, 1, 0 ) ) AS negative
                              FROM {$wpdb->prefix}userjobs
                              WHERE {$wpdb->prefix}userjobs.user_id = %d AND {$wpdb->prefix}userjobs.job_id
                              GROUP BY {$wpdb->prefix}userjobs.user_id", $_POST['user_id'], $_POST['job_id']);

                    $minyawns_rating = $wpdb->get_row($sql);

                   
                        $user_rating = $rating->positive;
                        $user_dislike =$rating->negative;
                        //$user['dislike'] = $rating->negative;

                       if($_POST['action'] == "vote_up")
                           $like_count=$user_rating;
                       
                       else 
                           $like_count=$user_dislike;
                           
                       
                            
                    
        
        
        

            echo json_encode(array('action' => $_POST['action'], 'rating' => $like_count, 'user_id' => $_POST['user_id']));
        });





$app->run();