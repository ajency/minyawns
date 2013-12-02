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
                            'compare' => "like",
                        //'type' => 'string'
                        )
                    ),
                );


                $total = count(get_users($args));


                $args['offset'] = $_GET['offset'];
                $args['order'] = 'ASC';
                $args['number'] = '5';


                $usersData = get_users($args);
            } else {

                $args = array(
                    'offset' => $_GET['offset'],
                    'order' => 'ASC',
                    'number' => '5'
                );

                $total = count(get_users());
                $usersData = get_users($args);
            }



            if (count($usersData) > 0) {
                foreach ($usersData as $userData) {

                    $user_meta = get_user_meta($userData->ID);

                    $minyawns_rating = get_user_rating_data($userData->ID, '');
                    foreach ($minyawns_rating as $rating) {
                        $user_rating = $rating->positive;
                        $user_dislike = $rating->negative;
                    }

                    $user_profile_pic = isset($user_meta['avatar_attachment']) ? trim($user_meta['avatar_attachment'][0]) : false;


                    if ($user_profile_pic !== false) {
                        $user_pic_img_src = "<img alt='' src=" . wp_get_attachment_image($user_profile_pic, get_user_role()) . "class='avatar avatar-96 photo' height='96' width='96'></img>";
                    } else {
                        $user_pic_img_src = get_avatar($userData->ID);
                    }

                    $data[] = array(
                        'user_id' => $userData->ID,
                        'user_email' => isset($userData->user_email) ? $userData->user_email : '',
                        'user_url' => isset($userData->user_url) ? $userData->user_url : '',
                        'description' => isset($user_meta['description'][0]) ? $user_meta['description'][0] : '',
                        'skills' => isset($user_meta['user_skills'][0]) ? $user_meta['user_skills'][0] : '',
                        'major' => isset($user_meta['major'][0]) ? $user_meta['major'][0] : '',
                        'college' => isset($user_meta['college'][0]) ? $user_meta['college'][0] : '',
                        'linkedin' => isset($user_meta['linkedin'][0]) ? $user_meta['linkedin'][0] : '',
                        'rating_positive' => isset($user_rating) ? $user_rating : 0,
                        'rating_negative' => isset($user_dislike) ? $user_dislike : 0,
                        'user_avatar' => $user_pic_img_src,
                        'total' => $total,
                        'minion_name' => $user_meta['first_name'][0] . $user_meta['last_name'][0]
                    );
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
