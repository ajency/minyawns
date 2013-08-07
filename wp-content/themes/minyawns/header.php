<!doctype html>  

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php wp_title('|', true, 'right'); ?></title>


        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- media-queries.js (fallback) -->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>			
        <![endif]-->

        <!-- html5.js -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap-responsive.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/flat-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/data_grids_main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ajaxload.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/tagmanager-master/bootstrap-tagmanager.css">
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">

        <!-- wordpress head functions -->
        <?php //wp_head(); ?>


        <?php
        $current_user = wp_get_current_user();
        $current_user_details = get_user_meta($current_user->ID);
        if (is_array($current_user_details['user_skills'])) {
            $skills = implode(",", $current_user_details['user_skills']);
        }

        $user_role = mn_get_current_user_role($current_user->ID);

        function mn_get_current_user_role($user_id) {
            $user = new WP_User($user_id);

            $role = "";
            if (!empty($user->roles) && is_array($user->roles)) {
                foreach ($user->roles as $role) {
                    return translate_user_role($role);
                }
            }
        }
        
        if($user_role == "employer" || $user_role == "author")
        {
            $avatarText="Avatar";
        }else
        {
            $avatarText ="Logo";
        }
        ?>
        <script> var ajaxurl = '<?php echo admin_url('admin-ajax.php', 'relative'); ?>'
            var siteurl = '<?php echo site_url(); ?>'
            var logouturl = '<?php echo wp_logout_url(home_url()); ?>'
            var userName = '<?php echo $current_user_details['first_name'][0] ?>'

        </script>

        <!-- end of wordpress head -->
        <script type="text/template" id="user-profile">


            <div class="span8">
            <h4> <%= first_name %>  <a href="#edit" id="edit-profile" class="edit"><i class="icon-edit"></i> Edit</a></h4> 
            <div class="row-fluid profile-list">
            <div class="span2">
            College :
            </div>
            <div class="span10">
            <%= college %>
            </div>
            <div class="span2">
            Major :
            </div>
            <div class="span10">
            <%= major %>
            </div>
            <div class="span2">
            Social Page :
            </div>
            <div class="span10">
            -<a href="<%= url %>"> LinkedIn </a> - <a href="#">Behance </a>
            </div>
            <div class="span2">
            Skills :
            </div>
            <div class="span10">
            <% for(var i=0;i<user_skills.length;i++){%>
            <span class="label label-small"><%= user_skills[i] %></span>
            <% } %>


            </div>
            </div>

            </div>

        </script>
        <script type="text/template" id="user-profile-two">


            <div class="span8">
            <h4> <%= industry %>  <a href="#edit" id="edit-profile" class="edit"><i class="icon-edit"></i> Edit</a></h4> 
            <div class="row-fluid profile-list">
            <div class="span2">
            Location :
            </div>
            <div class="span10">
            <%= location %>
            </div>
            <div class="span2">
            Body :
            </div>
            <div class="span10">
            <%= body %>
            </div>
            <div class="span2">
            Company Website :
            </div>
            <div class="span10">
            -<a href="<%= company_website %>"><%= company_website %>  </a> - <a href="#">Behance </a>
            </div>
            </div>

        </script>

        <script type="text/template" id="user-avatar">
            <div class="span2">
            <% if(avatar_check.length == 0){ %>
            <a href="#chang" class="change-avtar">
            <img <?php echo get_avatar($current_user->ID, 300) ?>
            <span>Change <?php echo $avatarText; ?></span>
            <% }else { %>
            <img <?php echo get_avatar($current_user->ID, 300) ?>

            <% } %>      


            </a>
            </div>
        </script>
        <script type="text/template" id="avatar-dialog">

            <div id="Adduser"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4><i class="fui-document platform"></i>Upload your picture here</h4>
            </div>

            <div class="modal-body " style="height:auto;">
            <div class="content" id="content_1" >
            <form class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
            <label class="control-label" for="in-name">Upload your picture here</label>
            <div class="controls">
            <input id="fileupload" name="file" type="file" />
            <input type="hidden" name="user_id" value="<?php echo $current_user->ID; ?>"/>           
            </div>
            </div>
            </form>
            <div id="loader_team" style="display:none" class="modal_ajax_gif_team"><!-- Place at bottom of page --></div>
            </div>
            <div id="error_text" style="display:none;font-family:arial;font-size:10px;color:red;">*Please enter a team name</div>
            <div id="error_text_two" style="display:none;font-family:arial;font-size:10px;color:red;">*Team Exists</div>
            </div>
            <div class="modal-footer">
            <button id="close" class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button  id="save_poup" class="btn btn-primary" aria-hidden="true">Save changes</input>

            </div>
            </div>

        </script>
        <script type="text/template" id="user-votes">
            <div class="span2">
            <br>
            <div class="like_btn"><br><br>
            <a href="#fakelink" style="float:left;" >
            <i class="icon-thumbs-up"></i><br>
            <b class="like">100</b>
            </a> 
            <a href="#fakelink" >
            <i class="icon-thumbs-down"></i><br>
            <b class="dislike">120</b>
            </a> 
            </div>
            <!-- Mobile View Like Button -->

            <div class="mobile_like_btn">
            <a href="#fakelink" >
            <i class="icon-thumbs-up"></i>
            <b class="like">100</b>
            </a> 
            <a href="#fakelink" class="red" >
            <i class="icon-thumbs-down"></i>
            <b class="dislike">120</b>
            </a> 
            </div>
            </div>
        </script>
        <script type="text/template" id="edit-profile">

            <form class="form-horizontal frm-edit" id="edit-user-profile">
            <input type="hidden" id="user_role" value="<%= user_role %>"></input>
            <div class="control-group">
            <label class="control-label" for="inputFirst">First Name</label>
            <div class="controls">
            <input type="text" id="inputFirst" placeholder="" class="input" value="<%= first_name %>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputlast">Last Name</label>
            <div class="controls">
            <input type="text" id="inputlast" placeholder="" class="input" value="<%= last_name %>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputemail">Email</label>
            <div class="controls">
            <input type="text" id="inputemail" placeholder="" class="input" disabled="true" value="<%= email %>"></input>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inptcollege">College</label>
            <div class="controls">
            <input type="text" id="inputcollege" placeholder="" class="input" value="<%= college %>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputmajor">Major</label>
            <div class="controls">
            <input type="text" id="inputmajor" placeholder="" class="input" value="<%= major %>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputskill">Skill</label>
            <div class="controls">

            <input type="text" name="tags" placeholder="Tags" class="tm-input"/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputbody">Body</label>
            <div class="controls">
            <textarea type="text" id="inputbody" placeholder="" maxlength="40" class="input" ></textarea>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="LinkedIn">LinkedIn profile public url</label>
            <div class="controls">
            <input type="text" style="width:147px" id="LinkedIn" name="linkedIn"  placeholder="" class="input" value="<%= url %>">
            </div>
            </div>
            <hr>
            <a  href="#upd" class="btn btn-large btn-block btn-inverse span2" id="update-profile-button" >Update Info</a>
            <div class="clear"></div>
            </form>

        </script>	

        <script type="text/template" id="edit-profile-two">

            <form class="form-horizontal frm-edit" id="edit-user-profile">
            <input type="hidden" id="user_role" value="<%= user_role %>"></input>
            <div class="control-group">
            <label class="control-label" for="inputFirst">Industry</label>
            <div class="controls">
            <input type="text" id="inputFirst" placeholder="" class="input" value="<%= industry %>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputlast">Location</label>
            <div class="controls">
            <input type="text" id="inputlast" placeholder="" class="input" value="<%= location %>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputemail">Body</label>
            <div class="controls">
            <input type="text" id="inputbody" placeholder="" class="input"  value="<%= body %>"></input>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inptcollege">Company Website</label>
            <div class="controls">
            <input type="text" id="LinkedIn" name="linkedIn" placeholder="" class="input" value="<%= company_website %>">
            </div>
            </div>
            <a  href="#upd" class="btn btn-large btn-block btn-inverse span2" id="update-profile-button" >Update Info</a>
            <div class="clear"></div>
            </form>

        </script>	







        <script type="text/template" id="history-row">
            <tr class="data_even ">

            <td data-title="Logo" class="data_cell awm_service_title" >
            <img src="<?php echo get_template_directory_uri(); ?>/images/walmart-logo.png"/>
            </td>
            <td data-title="Session Date" class="data_cell awm_service_demand">
            <span class="service-total-demand" data-count="0">30</span>
            <div>
            May<b  class="service-client-demand" data-count="0">2013</b>
            </div>
            <div class="demand"> Monday</div>
            </td>
            <td data-title="Duration" class="data_cell awm_service_supply duration_mob">
            <div class="row-fluid">
            <div class="span5">
            <span data-count="0" class="total-exchange-count">11:00</span>
            <div>
            pm
            </div>
            </div>
            <div class="span2">
            <b class="time-bold">to</b>
            </div>
            <div class="span5">
            <span data-count="0" class="total-exchange-count">2:00</span>
            <div>
            pm
            </div>
            </div>
            </div>
            </td>
            <td data-title="Wages"  class="data_cell awm_service_discount">
            <ins><span class="amount">$1000</span></ins>
            </td>
            <td data-title="Ratings "  class="data_cell awm_service_action rating">

            <span class="ratings"> +1</span>
            </td>
            </tr>
        </script>
        <script type="text/template" id="user-history-table">
            <div id="my-history" class="row-fluid"> <div class="span12">
            <section id="no-more-tables">
            <table class="qlabs_grid_container tablesorter jobs_table">		
            <thead>
            <tr class="header_row">
            <td colspan="7" class="header_cell">
            <div class="row-fluid">
            <div class="span12">
            <h3 class="page-title"> My History</h3> <!-- header label -->
            Applied, pending and completed job history
            </div>
            </div>
            </td>
            </tr>
            <tr class="subheader_row">
            <th class="subheader_cell awm_exchange_service_tlt service_tlt headerSortDown">Logo</th>
            <th class="subheader_cell awm_exchange_service_demand headerSortDown">Session Date</th>
            <th class="subheader_cell awm_exchange_service_supply headerSortDown">Duration</th>
            <th class="subheader_cell awm_exchange_service_discount headerSortDown">Wages</th>
            <th class="subheader_cell awm_exchange_services_action">Ratings</th>
            </tr>
            </thead>
            <tbody class="data_container">
            <tr class="data_even">
            <!-- table 1-->
            <td colspan="7">
            <table class="ins_table">

            </table>
            </td>
            </tr>

            </tbody>
            </table>




            </section>
            <br>
            </div>
            </div>
        </script>
    </head>

    <body class="home-page">
        <input type="hidden" value="<?php echo $_SESSION['email'] ?>" id="loggedinemail"/>
        <input type="hidden" id="user_id" value="<?php echo $current_user->ID; ?>"></input>

        <input id="current_user" type="hidden" value="<?php echo $current_user->ID; ?>"></input>
        <div class=" pbl mtn top-menu">
            <div class="bottom-menu  bottom-menu-inverse top-menu">
                <div class="container">
                    <div class="row">
                        <div class="span2 brand">
                            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/> </a>
                        </div>
                        <div class="span6">

                        </div>
                        <?php
                        $current_user = wp_get_current_user();
                        $current_user_details = get_user_meta($current_user->ID);


                        if (is_user_logged_in() == TRUE) {
                            ?>
                            <div class="span2 notify">
                                <div id="logged-in">
                                    <a id="user-popdown" href="javascript:void(0);" >
                                        <img <?php echo get_avatar($current_user->ID, 150); ?> <b class="caret"></b>
                                    </a>
                                </div>
                            </div>
                            <div class="span1">
                                <a href="#" class="help_icon"><i class="icon-question-sign"></i></a>
                            </div>
                        <?php } else {
                            ?>

                            <div class="span2 upper-link">
                                <a href="#myModal"  data-toggle="modal">Sign Up </a> &nbsp; &nbsp; 	<a href="#mylogin"  data-toggle="modal">Login </a>

                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div> <!-- /bottom-menu-inverse -->

        </div>

        <!-- Banner Layout --->
        


