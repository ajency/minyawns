<?php
/**
  Template Name: Minyawn Directory
 */

require 'templates/_minyawnsdir.php';
get_header();
?>
     <div class="container">
         <div id="main-content" class="main-content bg-white all-minyawns">
            <div class="breadcrumb-text">
               <p id="bread-crumbs-id">
                  <a href="http://www.minyawns.ajency.in/jobs/" class="view loaded">View all Minions</a>
               </p>
            </div>
              <div>
                   <?php if(strlen($_GET['filter'])>0){?>
               <span onclick="remove_filter()" class="label"><?php echo $_GET['filter'] ?><button data-dismiss="alert" class="close" type="button" style=" margin-left: 10px;margin-top: -19px;">×</button></span>
              <?php } ?>  
            </div>
            <div class="row-fluid profile-wrapper">
               <div class="row-fluild">
                  <div class="span3">
                     <div class="alert alert-success alert-sidebar">
                        <h3>Skills / Major </h3>
                        <hr>
                        <form  method="GET" accept-charset="utf-8">
<!--                           <select name="select3[]" id="select3" multiple="multiple" class=" hidden">
                              <option value="sleep" selected="selected" id="opt_EwU91S1atqiGQn8EbiIHAG4JulxfDChW" class="selected">sleep</option>
                           </select>-->
                           
                           <ul class="holder" style="width: 600px;">
<!--                              <li class="bit-box" rel="sleep" id="pt_EwU91S1atqiGQn8EbiIHAG4JulxfDChW">sleep<a class="closebutton" href="#"></a></li>-->
                              <li class="bit-input" id="select3_annoninput"><input placeholder="Enter Major or Skills" name="filter" type="text" class="maininput" size="0" autocomplete="off"></li>
                           </ul>
                           <div class="facebook-auto" style="width: 600px;">
                              <ul id="select3_feed" style="width: 600px; display: none;"></ul>
                              <div class="default">Start to type...<a href="" class="select_all_items">select</a></div>
                           </div>
                        </form>
                     </div>
                     <div class="alert alert-success alert-sidebar">
                        <h3> Number of Jobs Completed </h3>
                        <hr>
                        <div id="slider3" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-segment" style="margin-left: 5.2631578947368425%;"></div>
                           <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 50%;"></div>
                           <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 50%;"></a>
                        </div>
                        <span class="ui-slider-value first">Atleast 3 job done</span>
                        <br>
                     </div>
					    <div class="alert alert-success alert-sidebar">
                        <label class="checkbox" for="checkbox1">
                        <span class="icons"><span class="first-icon fui-checkbox-unchecked"></span><span class="second-icon fui-checkbox-checked"></span></span>
                        <input type="checkbox" value="" id="checkbox1" data-toggle="checkbox">
                       Minions who have applied to your jobs before
                        </label>
                     </div>
                     <div class="alert alert-success alert-sidebar">
                        <label  class="checkbox" for="checkbox-verified">
                        <span class="icons"><span class="first-icon fui-checkbox-unchecked"></span><span class="second-icon fui-checkbox-checked"></span></span>
                        <input type="checkbox" value="" id="checkbox-verified" >
                        Verified profiles only
                        </label>
                     </div>
                  </div>
               </div>
               
               <div class="span9">
<!--			   <div id="theFixed" class="alert alert-info alert-job-allminion" style="position:fixed;top:160px;"> 
			   <h6>Invite Minions for following job</h6>
			   <h5>
			   <a href="#" target="_blank" style="color:#8ED030;">The template has been conceived with a proper balance
                                                UI &amp; UX in order to offer an excellent  </a>
                           </h5>
				</div>-->
<!--			  <div id="more" class="peplist more">Send Invites by selecting Minions below </div>-->
             
                   <div class="row-fluid minyawns-grid1">
                     <ul class="thumbnails minyawnslist" style="left: 100px;">
                      
                       <span class="load_ajaxsingle_job_minions" style="display: none;"></span>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>


