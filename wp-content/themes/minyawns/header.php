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
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">

        <!-- wordpress head functions -->
        <?php wp_head(); ?>
       
        <script> var ajaxurl = '<?php echo admin_url('admin-ajax.php', 'relative'); ?>' 
            var siteurl = '<?php echo site_url();?>'
        
        </script>
 <?php $current_user = wp_get_current_user();
                        $current_user_details=get_user_meta($current_user->ID);?>

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
            <%= url %> -<a href="#"> LinkedIn </a> - <a href="#">Behance </a>
            </div>
            <div class="span2">
            Skills :
            </div>
            <div class="span10">
            <span class="label label-small">Social media account management</span>
            <span class="label label-small">Marketing </span>
            <span class="label label-small">Writing Publishing online</span>
            <span class="label label-small">Blogging</span>
            <span class="label label-small">Data-entry</span>


            </div>
            </div>

            </div>

        </script>

        <script type="text/template" id="user-avatar">
            <div class="span2">
            <a href="#" class="change-avtar">
            <img <?php  echo  get_avatar($current_user->ID,300)?>
            <span>Change Avatar</span>
            </a>
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
            
            <div class="control-group">
            <label class="control-label" for="inputFirst">First Name</label>
            <div class="controls">
            <input type="text" id="inputFirst" placeholder="" class="input" value="<?php echo $current_user_details['first_name'][0] ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputlast">Last Name</label>
            <div class="controls">
            <input type="text" id="inputlast" placeholder="" class="input" value="<?php echo $current_user_details['last_name'][0] ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputemail">Email</label>
            <div class="controls">
            <input type="text" id="inputemail" placeholder="" class="input" disabled="true" value="<?php echo $current_user->user_email; ?>"></input>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inptcollege">College</label>
            <div class="controls">
            <input type="text" id="inputcollege" placeholder="" class="input" value="<?php echo $current_user_details['college'][0] ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputmajor">Major</label>
            <div class="controls">
            <input type="text" id="inputmajor" placeholder="" class="input" value="<?php echo $current_user_details['major'][0] ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputskill">Skill</label>
            <div class="controls">
            <input name="tagsinput" class="tagsinput " value="School,Teacher,Colleague"  style="width:60%;"/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputbody">Body</label>
            <div class="controls">
            <textarea type="text" id="inputbody" placeholder="" maxlength="40" class="input" ><?php echo $current_user_details['body'][0] ?></textarea>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="LinkedIn">LinkedIn profile public url</label>
            <div class="controls">
            <input type="text" id="LinkedIn" placeholder="" class="input" value="<?php echo $current_user_details['url'][0] ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="LinkedIn">Upload a photo</label>
            <div class="controls">
            <div class="form-group">
            <label for="exampleInputFile">You can upload a JPG, GIF or PNG file ( File size limit is 4MB )</label>
            <input type="file" id="exampleInputFile">

            </div>
            </div>
            </div>
            <hr>
            <a href="#update" class="btn btn-large btn-block btn-inverse span2" id="update-profile-button" >Update Info</a>
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
 <div id="loader2" class="modal_ajax_large_dashboard" ><!-- Place at bottom of page --></div>
                               
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

    <body class="page_bg">
         <input type="hidden" value="<?php echo $_SESSION['email'] ?>" id="loggedinemail"/>
         <input id="current_user" type="hidden" value="<?php echo $current_user->ID; ?>"></input>
        <div class=" pbl mtn">
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
                        $current_user_details=get_user_meta($current_user->ID);
                       
                               
                        if(is_user_logged_in() == TRUE){ ?>
                       <div class="span2 notify">
                            <div id="logged-in">
                                <a id="user-popdown" href="javascript:void(0);" >
                                    <img <?php echo get_avatar($current_user->ID,150);?> <b class="caret"></b>
                                </a>
                            </div>
                        </div>
                        <div class="span1">
                            <a href="#" class="help_icon"><i class="icon-question-sign"></i></a>
                        </div>
                       <?php  }else
                        { ?>
                        
 <div class="span2">
                            <a href="#profile" >Profle</a> &nbsp; &nbsp; 	
                        </div>

                        <div class="span2">
                            <a href="#myModal"  data-toggle="modal">Sign Up </a> &nbsp; &nbsp; 	<a href="#mylogin"  data-toggle="modal">Login </a>

                        </div>

                       <?php  } ?>
                    </div>
                </div>
            </div> <!-- /bottom-menu-inverse -->

        </div>
        <script type="text/javascript" data-main="<?php echo get_template_directory_uri(); ?>/js/app.js" src="<?php echo get_template_directory_uri(); ?>/js/require.js"></script>


