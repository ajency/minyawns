<?php
/**
 * Setup file for project. Run this file to executer all project initialization tasks
 * Do not write any project code here.
 * Do not include this file in functions.php
 */

require_once( '../../../wp-load.php');


global $wpdb;
$query_widget=("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}userjobs 
				(id 		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			     user_id 	INT,
			     job_id 	INT,
                 status 	varchar(100),
			     rating 	INT )");

$wpdb->query($query_widget);

echo "New {$wpdb->prefix}userjobs table  created successfully";