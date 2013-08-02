<?php

require '../../../libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../../../wp-includes/wp-db.php';
require '../../../../../../wp-load.php';
global $wpdb;
global $wp_roles;
$app->get('/users', function () use ($app) {

            global $wpdb;
            if ($_GET['action'] == "fetch") {
                
                $user_data=get_userdata($_GET['user_id']);  // fetch user data
                $user_meta=  get_user_meta($_GET['user_id']); // fetch user meta
                $user_data=array(
                  'email'=>$user_data->user_email,
                    
                );
                
                $user_meta=array(
                    'college'=>$user_meta['college'][0],
                    'first_name'=>$user_meta['first_name'][0],
                    'last_name'=>$user_meta['last_name'][0],
                    'major'=>$user_meta['major'][0],
                    'url'=>$user_meta['url'][0]
                    
                );
                $data=  array_merge($user_data,$user_meta); //merge the two to send via json array
               
                
            } else {
                foreach ($_GET as $key => $values) {

                    update_user_meta($_GET['current_user'], $key,trim(strip_tags($values)));
                }
                $data=array();/*blank since the above condition is called when MY profile loads*/
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $data, 'status' => "success"));
        });

$app->run();



