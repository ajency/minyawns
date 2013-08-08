<?php

require '../../../libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../../../wp-includes/wp-db.php';
require '../../../../../../wp-load.php';
global $wpdb;
global $wp_roles;
$app->post('/addjob', function () use ($app) {
print_r(json_decode(file_get_contents('php://input'), true));exit();
    
        });
$app->run();






/*
 * Function to get user role by user id
 */

function mn_get_current_user_role($user_id) {
    $user = new WP_User($user_id);

    $role = "";
    if (!empty($user->roles) && is_array($user->roles)) {
        foreach ($user->roles as $role) {
            return translate_user_role($role);
        }
    }
}

?>
