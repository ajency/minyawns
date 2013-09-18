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
                    $end = $value;
                    update_post_meta($post_id, $key, strtotime($value));
                    update_post_meta($post_id, 'job_end_date', strtotime($value));
                } elseif ($key == "job_start_time") {
                    // print_r($start);print_r($value);
                    $start_time = explode(" ", $value);
                    $date = date("j-m-Y", strtotime($start));
                    $start_date_time = strtotime($date . $start_time[0]); //print_r($value);
                    update_post_meta($post_id, $key, strtotime($value));
                    update_post_meta($post_id, 'job_start_date_time', $start_date_time);
                } elseif ($key == "job_end_date") {
                    $end = $start;
                    update_post_meta($post_id, $key, strtotime($end));
                } elseif ($key == "job_end_time") {
                    $date = date("j-m-Y", strtotime($end));
                    $job_end_time = explode(" ", $value);
                    $end_date_time = strtotime($date . $job_end_time[0]);
                    //print_r(date("j-m-Y",  strtotime($start)).$value);
                    update_post_meta($post_id, $key, strtotime($value));

                    update_post_meta($post_id, 'job_end_date_time', $end_date_time);
                } elseif ($key !== 'job_details') {
                    update_post_meta($post_id, $key, $value);
                }
            }


            //  $app->response()->header("Content-Type", "application/json");
            /// echo json_encode(array('success' => 1));
        });



$app->get('/fetchjobs/', function() use ($app) {

            global $post, $wpdb;
            $prefix = $wpdb->prefix;


            $current_user_id = get_current_user_id();

            $tables = "$wpdb->posts, $wpdb->postmeta";
            $my_jobs_filter = "WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "'";
            $limit = "LIMIT " . $_GET['offset'] . ",5";
            $order_by = "AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            ORDER BY $wpdb->postmeta.meta_value ASC";


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

            $total = get_total_jobs();

            $no_of_pages = ceil($total / 5);

            $has_more_results = 0;

            foreach ($pageposts as $pagepost) {

                $owner_id = is_job_owner(get_user_id(), $pagepost->ID); /* returns the job owner id if set else 0 */

                $tags = wp_get_post_terms($pagepost->ID, 'job_tags', array("fields" => "names"));

                $post_meta = get_post_meta($pagepost->ID);

                $min_job = new Minyawn_Job($pagepost->ID);

                //$minyawns_have_applied = $min_job->get_applied_by();
                $user_data = array();

                $user_image = array();

                $user_job_status = array();

                $user_id_applied = array();

                $user_rating_like = array();

                $user_rating_dislike = array();

                $default_applied_user_avatar = array();

                foreach ($min_job->minyawns as $min) {

                    $user = array_push($user_data, $min['profile_name']);

                    $user_profileimage = array_push($user_image, get_user_company_logo($min['user_id']));

                    $applied_user_id = array_push($user_id_applied, $min['user_id']);

                    $status = array_push($user_job_status, $min['user_job_status']);



                    $minyawns_rating = get_user_rating_data($min['user_id'], $pagepost->ID);

                    foreach ($minyawns_rating as $rating) {
                        $user_rating = array_push($user_rating_like, $rating->positive);
                        $user_dislike = array_push($user_rating_dislike, $rating->negative);
                        //$user['dislike'] = $rating->negative;

                        if ($user['like'] != "0" || $user['dislike'] != "0")
                            $user['is_job_rated'] = 1;
                        else
                            $user['is_job_rated'] = 0;
                    }
                }


                $job_status = $min_job->check_minyawn_job_status($pagepost->ID, $min['user_id']);


                $total = get_total_jobs();

                if ($total <= $_GET['offset'] + 5)
                    $show_load = 1;
                else
                    $show_load = 0;

                if (get_user_company_logo($pagepost->post_author) == false)
                    $logo = get_avatar($pagepost->post_author, 168);
                else
                    $logo = get_user_company_logo($pagepost->post_author);


                /*
                 *  1 ->running
                 *  2->locked ,if one applicant also hired then locked
                 */
                $data[] = array(
                    'post_name' => $pagepost->post_title,
                    'post_date' => date('d M Y', strtotime($pagepost->post_date)),
                    'post_title' => $pagepost->post_title,
                    'post_id' => $pagepost->ID,
                    'job_start_date' => date('d M Y', $post_meta['job_start_date'][0]),
                    'job_end_date' => date('d M Y', strtotime($post_meta['job_end_date'][0])),
                    'job_day' => date('l', $post_meta['job_start_date'][0]),
                    'job_wages' => $post_meta['job_wages'][0],
                    //'job_progress' => 'available',
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
                    //'tags_count' => sizeof($tags),
                    'job_author' => get_the_author_meta('first_name', $pagepost->post_author) . ' ' . get_the_author_meta('last_name', $pagepost->post_author),
                    'job_author_id' => get_the_author_meta('ID', $pagepost->post_author),
                    'job_author_logo' => $logo,
                    'job_status' => $job_status,
                    'user_to_job_status' => $user_job_status,
                    //'user_job_status' => is_null($min_job->is_hired) ? $min_job->is_hired : 'can_apply',
                    'job_start_date_time' => $post_meta['job_start_date'][0],
                    'job_end_time_check' => $post_meta['job_start_date_time'][0],
                    'job_end_date_time_check' => $post_meta['job_end_date_time'][0],
                    'job_start_date_time_check' => $post_meta['job_start_date_time'][0],
                    'todays_date_time' => current_time('timestamp'),
                    'post_slug' => wp_unique_post_slug($pagepost->post_name, $pagepost->ID, 'published', 'job', ''),
                    'users_applied' => $user_data,
                    'load_more' => $show_load,
                    'user_profile_image' => $user_image,
                    'user_rating_like' => $user_rating_like,
                    'user_rating_dislike' => $user_rating_dislike,
                    'default_user_avatar' => get_avatar($pagepost->ID),
                    'job_owner_id' => $owner_id,
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
            $paypal_minyawns_hired = "";
            $split_user = explode("-", $_POST['status']);
            for ($i = 0; $i < sizeof($split_user); $i++) {
                $split_status = explode(",", $split_user[$i]);
                // for ($j = 0; $j < sizeof($split_status); $j++) {

                /* $wpdb->get_results(
                  "
                  UPDATE {$wpdb->prefix}userjobs
                  SET status = '" . $split_status[1] . "'
                  WHERE user_id = '" . $split_status[0] . "'
                  AND job_id = '" . $_POST['job_id'] . "'
                  "
                  ); */
                if ($split_status[0] != "") {
                    if ($i > 0)
                        $paypal_minyawns_hired.= ",";

                    $paypal_minyawns_hired.=$split_status[0];
                }
                // }
            }


            /* aded on 1sep2013 */
            $salt_job = wp_generate_password(20); // 20 character "random" string
            $key_job = sha1($salt . $_POST['job_id'] . uniqid(time(), true));

            $paypal_payment = array('minyawn_txn_id' => $key_job, 'paypal_txn_id' => '', 'status' => '', 'minyawns_selected' => $paypal_minyawns_hired);
            add_post_meta($_POST['job_id'], 'paypal_payment', $paypal_payment);

            $total_wages = trim($_POST['jobwages']);
            $returnUrl = $_POST['returnUrl'];
            $cancelUrl = $_POST['cancelUrl'];
            $html.='<form class="paypal" action="' . site_url() . '/paypal-payments/" method="post" id="paypal_form" target="_self">
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
	WHERE user_id = '" . trim($_POST['user_id']) . "' 
		AND job_id = '" . trim($_POST['job_id']) . "' AND status = 'hired'
	"
            );

            /* to calculate total ratings */
            $sql = $wpdb->prepare("SELECT {$wpdb->prefix}userjobs.user_id,{$wpdb->prefix}userjobs.job_id, SUM( if( rating =1, 1, 0 ) ) AS positive, SUM( if( rating = -1, 1, 0 ) ) AS negative
                              FROM {$wpdb->prefix}userjobs
                              WHERE {$wpdb->prefix}userjobs.user_id = %d AND {$wpdb->prefix}userjobs.job_id
                              GROUP BY {$wpdb->prefix}userjobs.user_id", $_POST['user_id'], $_POST['job_id']);

            $minyawns_rating = $wpdb->get_row($sql);


            $user_rating = $minyawns_rating->positive;
            $user_dislike = $minyawns_rating->negative;
            //$user['dislike'] = $rating->negative;
            //get  emplyer details
            $emp_data = get_userdata($_POST['emp_id']);
            $emp_name = ucfirst($emp_data->display_name);


            //get minyawns details
            $min_data = get_userdata($_POST['user_id']);
            $min_name = ucfirst($min_data->display_name);
            $min_email = $min_data->user_email;




            if ($_POST['action'] == "vote-up") {
                $like_count = $user_rating;
//            	$mail_subject =  "Minyawns - You have received a Thumbs Up. ";
//            	$mail_message ="Hi <a href='".site_url()."/profile/".$_POST['user_id']."'>".$min_name."</a>,<br/><br/> 
//            			Congratulations, <br/><br/>
//
//            			You have received Thumbs Up from <a href='".site_url()."/profile/".$_POST['emp_id']."'>".$emp_name."</a><br/>
//            			Great Job! Keep it up.		<br/><br/>
//            			To visit Minyawns site, <a href='".site_url()."/'>Click here</a>. <br/><br/<br/>
//            			
//            			";
            } else {
                $like_count = $user_dislike;
//                $mail_subject =  "Minyawns - You have received Thumbs Down. ";                 
//            	$mail_message ="Hi <a href='".site_url()."/profile/".$_POST['user_id']."'>".$min_name."</a>,<br/><br/>            			
//            			You have received Thumbs Down from  <a href='".site_url()."/profile/".$_POST['emp_id']."'>".$emp_name."</a><br/>
//            			Put little more efforts to receive Thumbs Up.<br/><br/>
//            			To visit Minyawns site, <a href='".site_url()."/'>Click here</a>. <br/><br/<br/>          			
//            			
//            			";
            }



            //send mail to minyawn for vote-up & vote down
//            add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
//            $headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
//            wp_mail($min_email, $mail_subject, email_header() . $mail_message . email_signature(), $headers);





            echo json_encode(array('action' => $_POST['action'], 'rating' => $like_count, 'user_id' => $_POST['user_id']));
        });

$app->get('/jobminions/', function() use ($app) {
            global $post, $wpdb;
            global $minyawn_job;

            $minion_ids = explode(',', $_GET['minion_id']);
            if (strlen(($_GET['minion_id'])) > 0) {
                for ($i = 0; $i < sizeof($minion_ids); $i++) {
                    $all_meta_for_user = get_user_meta($minion_ids[$i]);
                    $all_meta_for_user = array_map(function( $a ) {
                                return $a[0];
                            }, get_user_meta($minion_ids[$i]));


                    $minyawns_rating = get_user_rating_data($minion_ids[$i], $_GET['job_id']);
                    foreach ($minyawns_rating as $rating) {
                        $user_rating = $rating->positive;
                        $user_dislike = $rating->negative;
                    }


                    $user['image'] = wp_get_attachment_thumb_url($all_meta_for_user['avatar_attachment']);
                    if (!isset($user['image']))
                        $user['image'] = get_avatar($all_meta_for_user['user_email']);

//                    if ($key == 'facebook_uid')
//                        $fb_uid = $value;
//               
//
//                //set image
//                if ($fb_uid !== false)
//                    $user['image'] = 'https://graph.facebook.com/' . $fb_uid . '/picture?width=200&height=200';
//                elseif (!isset($user['image']))
//                    $user['image'] =get_avatar($all_meta_for_user['user_email'], 168);;



                    $data[] = array(
                        'user_id' => $minion_ids[$i],
                        'name' => $all_meta_for_user['first_name'] . $all_meta_for_user['last_name'],
                        'college' => isset($all_meta_for_user['college']) ? $all_meta_for_user['college'] : '',
                        'major' => isset($all_meta_for_user['major']) ? $all_meta_for_user['major'] : '',
                        'user_skills' => isset($all_meta_for_user['user_skills']) ? $all_meta_for_user['user_skills'] : '',
                        'linkedin' => isset($all_meta_for_user['linkedin']) ? $all_meta_for_user['linked_in'] : '',
                        'user_email' => isset($all_meta_for_user['nickname']) ? $all_meta_for_user['nickname'] : '', /* nick name temp fix */
                        'rating_positive' => $user_rating,
                        'rating_negative' => $user_dislike,
                        'user_image' => $user['image']
                    );
                }
            }
            else
                $data = array();


            $app->response()->header("Content-Type", "application/json");
            echo json_encode($data);
        });





$app->run();



