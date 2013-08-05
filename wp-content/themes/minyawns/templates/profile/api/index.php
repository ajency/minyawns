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
                
                /* user meta except skills*/
                $user_data=get_userdata($_GET['user_id']);  // fetch user data
                $user_meta=  get_user_meta($_GET['user_id']); // fetch user meta
                $user_skills=get_user_meta(trim($_GET['user_id']),'user_skills',FALSE);  /* user meta skils*/
                
                $user_data=array(
                  'email'=>$user_data->user_email,
                    
                );
                
                $user_meta=array(
                    'college'=>$user_meta['college'][0],
                    'first_name'=>$user_meta['first_name'][0],
                    'last_name'=>$user_meta['last_name'][0],
                    'major'=>$user_meta['major'][0],
                    'url'=>$user_meta['url'][0],
                    'user_skills'=>$user_skills
                    
                );
                $data=  array_merge($user_data,$user_meta); //merge the two to send via json array
               
                
               
                
            } else {
                foreach ($_GET as $key => $values) {

                    if($key == "user_skills")
                    {
                        delete_user_meta($_GET['current_user'],'user_skills');
                        $skill_values=split(',',$values);
                      for($val=0;$val<  sizeof($skill_values);$val++)
                      {
                         
                       add_user_meta($_GET['current_user'],'user_skills',trim($skill_values[$val]));  
                      }
                      }else{
                    update_user_meta($_GET['current_user'], $key,trim($values));
                    }
                    
                    
                    
                }
                $data=array();/*blank since the above condition is called when MY profile loads*/
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $data, 'status' => "success"));
        });
$app->get('/logout', function () use ($app) {

    
            wp_logout();
      wp_redirect( home_url() );
});

$app->run();?>
