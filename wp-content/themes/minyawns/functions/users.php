<?php
 
function get_miny_current_user(){


    global $user_ID,  $wp_roles ;

    $miny_current_user = array();
    $user_info = wp_get_current_user(); 

 
      if($user_info->data->user_id!=NULL){

        
        $miny_current_user['id'] = $user_ID;

        $miny_current_user['user_login'] = $user_info->data->user_login;

        $miny_current_user['user_email'] = $user_info->data->user_email;

        $miny_current_user['display_name'] = $user_info->data->display_name; 

        $miny_current_user['role'] =  key($user_info->caps) ;

        $miny_current_user['display_role'] = $wp_roles->role_names[key($user_info->caps)] ;

        $all_caps = array();

        foreach($user_info->allcaps as $key=>$capability){

            $all_caps[] = $key;

        }
         $miny_current_user['all_caps'] =$all_caps ;
    }else{

         $miny_current_user['id'] = 0;

         $miny_current_user['user_login'] = '';

        $miny_current_user['user_email'] = '';

        $miny_current_user['display_name'] = ''; 

        $miny_current_user['role'] =  '' ;

        $miny_current_user['display_role'] = '' ;

        $miny_current_user['all_caps'] = array() ;

    }

    return  $miny_current_user ;
}