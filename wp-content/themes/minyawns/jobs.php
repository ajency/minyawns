<?php
/**
Template Name: Jobs

 */
get_header(); 

global $post;  


get_template_part(  'templates/'.$post->post_name.'/container'  );  
 
get_footer();
?>

