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
                    $start=$value;
                    update_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_start_time") {
                   // print_r($start);print_r($value);
                    $date=date("j-m-Y",  strtotime($start));
                    $start_date_time=strtotime($date. $value);//print_r($value);
                    update_post_meta($post_id, $key, strtotime($value));
                    update_post_meta($post_id,'job_start_date_time',$start_date_time);
                } elseif ($key == "job_end_date") {
                    $end=$value;
                    update_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_end_time") {
                    $date=date("j-m-Y",  strtotime($end));
                    $end_date_time=strtotime($date. $value);
                    //print_r(date("j-m-Y",  strtotime($start)).$value);
                    update_post_meta($post_id, $key, strtotime($value));
                    update_post_meta($post_id,'job_end_date_time',$end_date_time);
                    
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
                $tables = "$wpdb->posts, $wpdb->postmeta,{$wpdb->prefix}userjobs";
                $my_jobs_filter = "WHERE $wpdb->posts.ID = {$wpdb->prefix}userjobs.job_id AND {$wpdb->prefix}userjobs.job_id = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date'";
            } else {
                $tables = "$wpdb->posts, $wpdb->postmeta";
                $my_jobs_filter = "WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "'";
            }

            $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $tables
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            ORDER BY $wpdb->posts.ID DESC
                            LIMIT " . trim($_GET['offset']) . ",2
                         ";

            $data = array();
            $pageposts = $wpdb->get_results($querystr, OBJECT);

            foreach ($pageposts as $pagepost) {
                $tags = wp_get_post_terms($pagepost->ID, 'job_tags', array("fields" => "names"));
                //print_r(implode(",",$tags));exit();
                $post_meta = get_post_meta($pagepost->ID);
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
                    'job_start_time' => date('H:i', $post_meta['job_start_time'][0]),
                    'job_end_time' => date('H:i', $post_meta['job_end_time'][0]),
                    'job_location' => $post_meta['job_location'][0],
                    'job_details' => $pagepost->post_content,
                    'tags' => $tags,
                    'tags_count' => sizeof($tags),
                    'job_author' => get_the_author_meta('display_name', $pagepost->post_author),
                    'job_author_logo' => get_avatar($pagepost->post_author, '10')
                );
            }
            $total = count($pageposts);
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
                            AND $wpdb->postmeta.meta_value >= '" . strtotime(date('1-m-Y',strtotime('this month'))) . "'";
                //AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "'
            }

            $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $tables
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            ORDER BY $wpdb->posts.ID DESC
                            LIMIT " . trim($_GET['offset']) . ",2
                         ";


            $data = array();
            $data['events'][] = array();
            $attendes=array();
            $emails=array();
            $gmtTimezone = new DateTimeZone('IST');
            $pageposts = $wpdb->get_results($querystr, OBJECT);
$cnt = count($pageposts);
            foreach ($pageposts as $pagepost) {
                $tags = wp_get_post_terms($pagepost->ID, 'job_tags', array("fields" => "names"));
                //print_r(implode(",",$tags));exit();
                $post_meta = get_post_meta($pagepost->ID);
//                $data[] = array(
//                    'post_name' => $pagepost->post_title,
//                    'post_date' => $pagepost->post_date,
//                    'post_title' => $pagepost->post_title,
//                    'post_id' => $pagepost->ID,
//                    'job_start_date' => date('d M Y', $post_meta['job_start_date'][0]),
//                    'job_end_date' => date('d M Y', strtotime($post_meta['job_end_date'][0])),
//                    'job_day' => date('l', $post_meta['job_start_date'][0]),
//                    'job_wages' => $post_meta['job_wages'][0],
//                    'job_progress' => 'available',
//                    'job_start_day' => date('d', $post_meta['job_start_date'][0]),
//                    'job_start_month' => date('F', $post_meta['job_start_date'][0]),
//                    'job_start_year' => date('Y', $post_meta['job_start_date'][0]),
//                    'job_start_meridiem' => date('a', $post_meta['job_start_time'][0]),
//                    'job_end_meridiem' => date('a', $post_meta['job_end_time'][0]),
//                    'job_start_time' => date('H:i', $post_meta['job_start_time'][0]),
//                    'job_end_time' => date('H:i', $post_meta['job_end_time'][0]),
//                    'job_location' => $post_meta['job_location'][0],
//                    'job_details' => $pagepost->post_content,
//                    'tags' => $tags,
//                    'tags_count' => sizeof($tags),
//                    'job_author' => get_the_author_meta('display_name', $pagepost->post_author),
//                    'job_author_logo' => get_avatar($pagepost->post_author, '10')
//                );
         

                $fullday = 0;

                $location = isset($post_meta['job_location'][0]) ? $post_meta['job_location'][0] : '';
                $tags=  implode(",",$tags);
                $wages= isset($post_meta['job_wages'][0]) ? $post_meta['job_wages'][0] :'';
                $details=isset($pagepost->post_content) ? $pagepost->post_content :'';
                $apply=true;
                $logo=get_avatar($pagepost->post_author, '10');
               
               // print_r($post_meta['job_start_date_time'][0]);exit();
                $st = date('d M Y H:i:s', $post_meta['job_start_date_time'][0]);
                $et = date('d M Y H:i:s', $post_meta['job_end_date_time'][0]);

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
                   
                );
            }
            //$app->response()->header("Content-Type", "application/json");
            echo json_encode($data);
        });


$app->run();