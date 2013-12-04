<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';


$app->get('/allminyawns', function() use ($app) {

            global $wpdb;
            $filter_key = $_GET['filter'];

            $args = array();

            if (strlen($filter_key) > 0) {
                $args = array(
                    'meta_query' =>
                    array(
                        'relation' => 'OR',
                        array(
                            'key' => 'college',
                            'value' => $filter_key,
                            'compare' => "like",
                        //'type' => 'string'
                        ),
                        array(
                            'key' => 'major',
                            'value' => $filter_key,
                            'compare' => "like",
                        //'type' => 'string'
                        ),
                        array(
                            'key' => 'user_skills',
                            'value' => $filter_key,
                            'compare' => "like"
                        //'type' => 'string'
                        ),
//                        array(
//                            'key' => 'first_name',
//                            'value' => $filter_key,
//                            'compare' => "like"
//                            //'type' => 'string'
//                        ),
//                        array(
//                            'key' => 'last_name',
//                            'value' => $filter_key,
//                            'compare' => "like"
//                            //'type' => 'string'
//                        )
                    ),
                        //'role'=>'minyawn'
                );

                $args_total['role'] = 'minyawn';

                $total = count(get_users($args_total));
                $args['offset'] = $_GET['offset'];
                $args['order'] = 'ASC';
                $args['number'] = '5';


                $usersData = get_users($args);
                $total = count($usersData);


                $querystr = "SELECT * FROM {$wpdb->prefix}users, {$wpdb->prefix}usermeta WHERE {$wpdb->prefix}users.ID = {$wpdb->prefix}usermeta.user_id AND ({$wpdb->prefix}usermeta.meta_key = 'user_skills' AND {$wpdb->prefix}usermeta.meta_value LIKE '".$filter_key.",%' OR {$wpdb->prefix}usermeta.meta_value LIKE '".$filter_key."%' OR  {$wpdb->prefix}usermeta.meta_value LIKE '%,".$filter_key.",%'  OR {$wpdb->prefix}usermeta.meta_value LIKE '%,".$filter_key."' OR {$wpdb->prefix}usermeta.meta_key = 'major' AND {$wpdb->prefix}usermeta.meta_value like '".$filter_key."%' OR {$wpdb->prefix}usermeta.meta_key = 'college' AND {$wpdb->prefix}usermeta.meta_value like '".$filter_key."%' OR {$wpdb->prefix}usermeta.meta_key = 'first_name' AND {$wpdb->prefix}usermeta.meta_value like '".$filter_key."%' OR {$wpdb->prefix}usermeta.meta_key = 'last_name' AND {$wpdb->prefix}usermeta.meta_value like '".$filter_key."%') LIMIT 5 OFFSET ".$_GET['offset']."";
              
                $usersData = $wpdb->get_results($querystr, OBJECT);
                 
               $total=count($usersData);
               
            } else {

                $args = array(
                    'role' => 'minyawn'
                );

                $total = count(get_users($args));

                $args = array('offset' => $_GET['offset'],
                    'order' => 'ASC',
                    'number' => '5',
                    'role' => 'minyawn',
                );

                $usersData = get_users($args);

                
            }



            if (count($usersData) > 0) {
                foreach ($usersData as $userData) {

                    $data[] = get_minyawn_profile($userData, $total);
                }
            } else {

                $data = array(
                    'error' => '404'
                );
            }
            $app->response()->header("Content-Type", "application/json");
            echo json_encode($data);
        });


$app->get('filterAllminyawns', function() use($app) {
            
        });

$app->run();
