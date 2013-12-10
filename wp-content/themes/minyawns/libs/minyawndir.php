<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';


$app->get('/allminyawns', function() use ($app) {

            global $wpdb;
            $filter_key = $_GET['filter'];


            $verified = $_GET['verified'];

            $hired_before = $_GET['minions_hired'];

            $applied_before = $_GET['minions_applied'];

            $args = array();

            if (strlen($filter_key) > 0 || strlen($verified) > 0 || strlen($hired_before) > 0 || strlen($applied_before) > 0) {

                $args_total['role'] = 'minyawn';

                $total = count(get_users($args_total));
                $args['offset'] = $_GET['offset'];
                $args['order'] = 'ASC';
                $args['number'] = '10';


                $usersData = get_users($args);
                $total = count($usersData);

                $where = '';
                if (strlen($filter_key) > 0) {//IF SEARCH FILTER IS APPLIED
                    $where = "AND({$wpdb->prefix}usermeta.meta_key = 'user_skills' AND {$wpdb->prefix}usermeta.meta_value LIKE '" . $filter_key . ",%' OR {$wpdb->prefix}usermeta.meta_value LIKE '" . $filter_key . "%' OR  {$wpdb->prefix}usermeta.meta_value LIKE '%," . $filter_key . ",%'  OR {$wpdb->prefix}usermeta.meta_value LIKE '%," . $filter_key . "' OR {$wpdb->prefix}usermeta.meta_key = 'major' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'college' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'first_name' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'last_name' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%')";
                }

                if (strlen($verified) > 0) {//IF VERIFIED FILTER IS APPLIED
                    if ($verified === 'Y') {
                        $where = "AND({$wpdb->prefix}usermeta.meta_key = 'user_skills' AND {$wpdb->prefix}usermeta.meta_value LIKE '" . $filter_key . ",%' OR {$wpdb->prefix}usermeta.meta_value LIKE '" . $filter_key . "%' OR  {$wpdb->prefix}usermeta.meta_value LIKE '%," . $filter_key . ",%'  OR {$wpdb->prefix}usermeta.meta_value LIKE '%," . $filter_key . "' OR {$wpdb->prefix}usermeta.meta_key = 'major' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'college' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'first_name' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'last_name' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%') AND ({$wpdb->prefix}usermeta.meta_key = 'user_verified' AND {$wpdb->prefix}usermeta.meta_value LIKE '" . $verified . "')";
                    } else {

                        all_results();
                    }
                }

//                if(strlen($applied_before) >0)
//                {
//                    
//                 $where = "{$wpdb->prefix}users.ID={$wpdb->prefix}users.user_id AND {$wpdb->prefix}userjobs='status' AND({$wpdb->prefix}usermeta.meta_key = 'user_skills' AND {$wpdb->prefix}usermeta.meta_value LIKE '" . $filter_key . ",%' OR {$wpdb->prefix}usermeta.meta_value LIKE '" . $filter_key . "%' OR  {$wpdb->prefix}usermeta.meta_value LIKE '%," . $filter_key . ",%'  OR {$wpdb->prefix}usermeta.meta_value LIKE '%," . $filter_key . "' OR {$wpdb->prefix}usermeta.meta_key = 'major' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'college' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'first_name' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%' OR {$wpdb->prefix}usermeta.meta_key = 'last_name' AND {$wpdb->prefix}usermeta.meta_value like '" . $filter_key . "%') AND ({$wpdb->prefix}usermeta.meta_key = 'user_verified' AND {$wpdb->prefix}usermeta.meta_value LIKE '" . $verified . "')";   
//                }

                $querystr = "SELECT * FROM {$wpdb->prefix}users, {$wpdb->prefix}usermeta WHERE {$wpdb->prefix}users.ID = {$wpdb->prefix}usermeta.user_id  " . $where . " LIMIT 5 OFFSET " . $_GET['offset'] . "";

                $usersData = $wpdb->get_results($querystr, OBJECT);

                $total = count($usersData);
            } else {//ON PAGE LOAD
                $args = array(
                    'role' => 'minyawn'
                );

                $total = count(get_users($args));

                $args = array('offset' => $_GET['offset'],
                    'order' => 'ASC',
                    'number' => '10',
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

function all_results() {

    $args = array(
        'role' => 'minyawn'
    );

    $total = count(get_users($args));

    $args = array('offset' => $_GET['offset'],
        'order' => 'ASC',
        'number' => '10',
        'role' => 'minyawn',
    );

    $usersData = get_users($args);


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
}
