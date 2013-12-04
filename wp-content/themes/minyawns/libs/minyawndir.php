<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';


$app->get('/allminyawns', function() use ($app) {

            $filter_key = $_GET['filter'];

            $args = array();

            if (strlen($filter_key) > 0) {
                $args = array(
                    'meta_query' =>
                    array(
                        'relation' => 'OR',
                        array(
                            'key' => 'description',
                            'value' => $filter_key,
                            'compare' => "like",
                        //'type' => 'string'
                        ),
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


                $total = count(get_users($args));
                $args['offset'] = $_GET['offset'];
                $args['order'] = 'ASC';
                $args['number'] = '5';


                $usersData =get_users($args);
//               print_r($filter_key); print_r($usersData);exit();
                
            } else {

                $args = array(
                    'offset' => $_GET['offset'],
                    'order' => 'ASC',
                    'number' => '5',
                    'role'=>'minyawn'
                );

                $total = count(get_users($args));
                
                $args=array( 'offset' => $_GET['offset'],
                    'order' => 'ASC',
                    'number' => '5',
                    'role'=>'minyawn',
                    'total'=>$total);
               
                $usersData = get_users($args);
            }



            if (count($usersData) > 0) {
                foreach ($usersData as $userData) {
                 
                    $data[]=get_minyawn_profile($userData,$total);
                    
               
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
