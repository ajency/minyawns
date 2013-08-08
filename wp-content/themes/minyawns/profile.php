
<?php
/**
Template Name: Profile Page
 */
get_header(); 

global $post;  

get_template_part(  'templates/'.$post->post_name.'/container'  );  
 
get_footer();