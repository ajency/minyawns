<?php

require '../../../libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../../../wp-includes/wp-db.php';
require '../../../../../../wp-load.php';
global $wpdb;
global $wp_roles;
$app->get('/roles', function () use ($app) {

            global $wpdb;

            if (isset($_GET['role']))/* if add new role */ {
                $role_clone = 'subscriber';
                $role = $_GET['role'];
                $role_name = ucfirst($_GET['role']);
                $additional_capabilities = array();
                phoenix_add_role($role_clone, $role, $role_name, $additional_capabilities);
                $userRoles[] = array('role_name' => $role_name);
            } else {
                $userRoles = array();
                $role_name = get_roles();

                foreach ($role_name as $role) {
                    $userRoles[] = array(
                        'role_name' => $role,
                    );
                }
            }
            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $userRoles, 'total' => count($userRoles)));
        });


$app->get('/capb-group/:group_id', function($group_id) use ($app) {
            global $wpdb;
            // $group_id = 1;

            $qry = "SELECT * FROM ".$wpdb->prefix."phoenix_capabilities where group_id=" . $group_id . "";
            $events = $wpdb->get_results($qry, ARRAY_A);



            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $events, 'total' => count($events)));
        });



$app->get('/check-capb-group', function() use ($app) {
            global $wpdb;
            // $group_id = 1;

            $qry = "SELECT * FROM ".$wpdb->prefix."phoenix_capabilities where group_id=" . $_GET['group'] . "";
            $events = $wpdb->get_results($qry, OBJECT);

            foreach ($events as $capabilities) {
                $role = get_role(strtolower($_GET['rolename']));

                if ($role->has_cap($capabilities->capability)) {
                    $capability[] = array(
                        'capability' => $capabilities->capability,
                        'checked' => 'true'
                    );
                } else {
                    $capability[] = array(
                        'capability' => $capabilities->capability,
                        'checked' => 'false'
                    );
                }
// print_r($capabilities->capability);
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $capability, 'total' => count($capability)));
        });


$app->get('/capb-operations', function() use ($app) {
            global $wpdb;
            // $group_id = 1;
            if ($_GET['action'] == "add") {
                $role = get_role(strtolower($_GET['rolename']));
                $role->add_cap($_GET['capb_name']);
            } else {
                $role = get_role(strtolower($_GET['rolename']));
                $role->remove_cap($_GET['capb_name']);
            }

            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $role, 'total' => count($role)));
        });



//global $wp_roles;
//$capabilities = array();
//$cap = array();
//$roles = $wp_roles->roles;
//foreach ($roles as $admin_roles) {
//    if ($admin_roles['name'] == 'Administrator') {
//
//        $caps = array_keys($admin_roles['capabilities']);
//    }
//}
//foreach ($caps as $caps_keys) {
//    $cap[] = array(
//        'all_roles' => $caps_keys
//    );
//}
$app->run();



