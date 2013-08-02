<?php
/**
 * Template Name: Homepage
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ajency
 * @subpackage Better_Rentals
 */
get_header();
?>

<div id="myModal" class="modal signup hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri(); ?>/images/pattern-bg.png)">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png"/></button>
        <h4 id="myModalLabel">Sign Up to <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/> </h4>

    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span6"> 
                <h6 class="align-center" style=" margin-bottom: 0px; ">
                    Create an Account</h6>
                <p class="align-center">Fill out the required information Below</p>
                <div class="control-group ">
                    <input type="text" value="" placeholder="Email Address" class="span3">
                </div>
                <div class="control-group ">
                    <input type="text" value="" placeholder="Password" class="span3">
                </div>
                <div class="control-group span6 " style=" margin-left: 0px; ">
                    <input type="text" value="" placeholder="First Name" class="span3">
                </div>
                <div class="control-group span6 ">
                    <input type="text" value="" placeholder="Last Name" class="span3">
                </div>
                <div class="clear"></div>
                <a href="#fakelink" class="btn btn-large btn-block btn-inverse" >Sign Up</a>
            </div>

            <div class="span6">
                <h6 class="align-center" style=" margin-bottom: 0px; ">
                    Sign Up Using Facebook</h6>
                <p class="align-center">Get using minyawns, faster !</p><br><br>

                <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/fbConnect_button.png" class="center-image"/></a>
                <br><br>
                <p class="align-center">Already a Minyawn?<a href="#"><b> Sign in here</b></a></p>
            </div>

        </div>
    </div>

</div>

<div id="mylogin" class="modal signup  hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:url(<?php echo get_template_directory_uri(); ?>/images/pattern-bg.png)">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="images/delete.png"/></button>
        <h4 id="myModalLabel">Login to <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/> </h4>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span6"> 

                <div class="control-group ">
                    <input type="text" value="" placeholder="Email Address" class="span3">
                </div>
                <div class="control-group ">
                    <input type="text" value="" placeholder="Password" class="span3">
                </div>
                <div class="row-fluid">
                    <div class="span4"><a href="#fakelink" class="btn btn-large btn-block btn-inverse " >Login</a></div>
                    <div class="span8"><a href="#"  style=" line-height: 42px; color: #12B13E;font-weight:bold; ">Forget your password ?</a></div>
                </div> 
            </div>
            <div class="span6">
                <h6 class="align-center" style=" margin-bottom: 0px; ">
                    Login Using Facebook</h6>
                <p class="align-center">Get using minyawns, faster !</p><br>

                <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/fbConnect_button.png" class="center-image"/></a>


            </div>

        </div>
    </div>

</div>






<?php get_footer(); ?>