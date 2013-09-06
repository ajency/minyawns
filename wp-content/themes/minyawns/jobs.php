<?php
/**
  Template Name: Jobs

 */
get_header();
global $minyawn_job;
?>

<!-- Row Div -->
<script type="text/template" id="browse-jobs-table">

    <div style="clear:both;">	</div>
    <div class="accordion-group">
    <div id="last-job-id" last-job="<%= post_id %>" value="<%= post_id %>"></div>
    <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<%= post_id %>">
    <div class="span12 data-title available">
    <div class="job-logo header-sub"> <div class="logo "><%= job_author_logo %></div></div>
    <div class="job-date header-sub">
    <span class="service-total-demand" data-count="0"><%= job_start_day %></span>
    <div>
    <%= job_start_month %><b class="service-client-demand" data-count="0"><%= job_start_year %></b>
    </div>
    <div class="demand"><%= job_day %></div>
    </div>
    <div class="job-time header-sub duration_mob">
    <div class="row-fluid">
    <div class="span5 mob-botm">
    <span data-count="0" class="total-exchange-count"><%= job_start_time %></span>
    <div>
    <%= job_start_meridiem %>
    </div>
    </div>
    <div class="span2">
    <b class="time-bold">to</b>
    </div>
    <div class="span5">
    <span data-count="0" class="total-exchange-count"><%= job_end_time %></span>
    <div>
    <%= job_end_meridiem %>
    </div>
    </div>
    </div>
    </div>

    <div class="job-wage header-sub">
    <ins><span class="amount">$ <%= job_wages %></span></ins>
    </div>

    <div class="job-progress header-sub">

    <%  if(can_apply_job == 0 && todays_date_time < job_end_date_time_check) %>
    <span class="label-available">Available</span>

    <%  else if(can_apply_job == 2) %>
    <span class="label-available">Requirement complete</span>

    <% else if (todays_date_time > job_end_date_time_check){%>
    <span class="label-unavailable">This job is complete</span>

    <% }else if (can_apply_job == 3){%>
    <span class="label-hired">You are hired for this job.</span>
    <% }else if (can_apply_job == 1) {%>
    <span class="label-available">You have applied for this job.</span>

    <% }
    %> 


    </div>

    <div class="job-action header-sub">

    <div class="arrow-down">
    </div>

    </div>
    </div>
    </a>
    </div>

    <div id="collapse<%= post_id %>" class="accordion-body collapse ">
    <div class="accordion-inner">
    <div class="row-fluid header-title">
    <div class="span12">
    <h3><a href=<?php echo site_url() ?>/job/<%= post_slug %> target="_blank" > <%= post_title %> <span class="view-link"><i class="icon-search"></i> View</span></a> </h3>
    </div>
    </div>
    <div class="row-fluid job-data">
    <div class="span9 inner-data">
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Requested by :</b></div><div class="span9"> <a href="<?php echo site_url() ?>/profile/<%= job_author_id%>" target="_blank" class="request_link"><%= job_author %></a>  </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Location :</b></div><div class="span9"><%= job_location %> </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Details :</b></div><div class="span9"><%= job_details.substring(0, 140) %> </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Tags :</b></div><div class="span9"> <% for(i=0;i<tags_count;i++){ %> <span class="label"><%= tags[i] %></span><%}%> </div>
    </div>
    </div>
    <div class="span3">
    <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-left.png">
    <div class="div-box-block">
    <span class='load_ajax1' style="display:none"></span>
    <?php if (get_user_role() === 'minyawn'): ?> 
       <% if(todays_date_time > job_end_date_time_check)%>
       <a href="#" class="required">This job is complete!</a>
       <% else if(can_apply_job == 3) %>
        <a href="#" class="required">You are hired!</a>
        <% else if(can_apply_job == 1)%>
        <a href="#" id="unapply-job" class="btn btn-medium btn-block btn-danger red-btn" data-action="unapply" data-job-id="<%= post_id %>">Unapply</a>
        <% else if(can_apply_job == 0 ) %>
        <a href="#" id="apply-job-browse" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>">Apply</a>

        <% else if(can_apply_job == 2 ) %>
        <a href="#" class="required">Requirement Complete</a>



        <?php
    else:
        ?>

        <% if(is_job_owner == 1){%>
        <%  if(can_apply_job == 2 || todays_date_time > job_end_time_check) %>
        <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>">Select Your Minions</a>

        <% else if (todays_date_time < job_end_time_check && can_apply_job == 0){%>
        <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>">Select Your Minions</a>
        <% }else if(can_apply_job ==3 || todays_date_time > job_end_time_check ){ %>
        <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-large btn-block btn-inverse  btn-rate" data-action="apply" data-job-id="<%= post_id %>">Rate Your Minions</a>
        <% }
        }else{ 
        %> 
        <span style=" display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;">Please Log-in as a Minion to apply to this job.</span>
        <% } %>

    <?php
    endif;
    ?>

    </div>

    </div>
    </div>



    </div>

    <!-- Row Div -->


</script>

<script type="text/templates" id="no-result">
    <div class="alert alert-info myjobs no-job ">
    <b style="text-align: center">No Jobs Available ! </b>&nbsp;
    There doesn't seem to be anything here.
    </div>
</script>
<script type="text/templates" id="my-jobs">
    <div id="job-list<%= post_id %>" class="row-fluid list-jobs my-jobs-1"  style="background: #C7C9C5;">
    <div class="span12 jobs-details">
    <div class="span2 img-logo"><a href="<?php echo site_url() ?>/profile/<%= job_author_id%>" target="_blank"> <%= job_author_logo %></a></div>
    <div class="span3 minyawns-select"><span><%= minyawns_have_applied %></span>
    <div>Minions Have Applied</div> 
    </div>
    <% if(todays_date_time > job_end_time_check){%>
    <div class="span3 jobs-date"> 
    <div class="job-complete"> Job Completed</div>
    </div>
    <%}else{ %>
    <div class="span3 jobs-date"> 
    <div class="posteddate"> Posted Date : <span><%= post_date %></span></div>
    <div class="jobsdate"> Job Date : <span><%= job_start_date %></span></div>
    </div>
    <% }%>
    <div class="span3 job-duration duration_mob">
    <div class="row-fluid">
    <div class="span5 mob-botm">
    <span data-count="0" class="total-exchange-count"><%= job_start_time %></span>
    <div>
    <%=job_start_meridiem %>
    </div>
    </div>
    <div class="span2">
    <b class="time-bold">to</b>
    </div>
    <div class="span5">
    <span data-count="0" class="total-exchange-count"><%=job_end_time %></span>
    <div>
    <%= job_end_meridiem %>
    </div>
    </div>
    </div>
    </div>
    <div class="span1 wages">
    $<%= job_wages %> 
    </div>
    </div>
    <div class="span12 expand">
    <div class="row-fluid header-title">
    <div class="span12">
    <h3><a href=<?php echo site_url() ?>/job/<%= post_slug %> target="_blank" > <%= post_title %> <span class="view-link"><i class="icon-search"></i> View</span></a> </h3>
    </div>
    </div>
    <br>
    <div class="span9 details"> 

    <div class="row-fluid">
    <div class="span4 "> <div class="employer-image2"><%= job_author_logo %></div></div>
    <div class="span8"><%= job_details %></div>
    </div><br>
    <div class="row-fluid minyawansgrid">
    <% for(i=0;i<users_applied.length;i++){ %>
    <a href="<?php echo site_url() ?>/profile/<%= applied_user_id[i]%>" target="_blank"><div class="span6"><%= user_profile_image[i] %><b><%= users_applied[i]%></b></a>

    <a id="vote-up" href="#fakelink" employer-vote="1" job-id="<%= post_id %>">
    <i class="icon-thumbs-up"></i> <%= user_rating_like[i] %>
    </a> 
    <a id="vote-down" href="#fakelink"  class="icon-thumbs" employer-vote="-1" job-id="<%= post_id %>">
    <i class="icon-thumbs-down"></i> <%= user_rating_dislike[i] %>
    </a>

    </div>
    <% }  %>
    </div>
    <img src="<?php echo get_template_directory_uri(); ?>/images/left-arrow.png" class="arrow-left"/>
    </div>


    <?php if (get_user_role() == "minyawn") { ?>
        <div class="span3">
        <div class="div-box-block">
        <span class='load_ajax1' style="display:none"></span>
        <% if(can_apply_job == 3){%>
        <a href="#" class="required">You are hired!</a>
        <% }else if( todays_date_time < job_end_time_check){%>
        <a href="#" id="unapply-job" class="btn btn-medium btn-block btn-danger red-btn" data-action="unapply" data-job-id="<%= post_id %>">Unapply</a>
        <% } %>
        </div>
        </div>
    <?php } else { ?>

        <div class="span3">
        <div class="div-box-block">
        <span class='load_ajax1' style="display:none"></span>
        <% if (todays_date_time < job_end_time_check && is_job_owner == 1){%>
        <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>" style="width:70%;">Select Your Minions</a>
        <% }else if(can_apply_job ==3 || todays_date_time > job_end_time_check ){ %>
        <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-large btn-block btn-inverse  btn-rate" data-action="apply" data-job-id="<%= post_id %>">Rate Your Minions</a>
        <% } %>
        </div>
        </div>
        </div>
    <?php } ?>

    </div>
    </div>

</script>
<div class="container">

    <ul class="nav nav-tabs nav-append-content jobs_menu">
        <li ><a href="#tab1" id="browse">Browse Jobs</a></li>
        <li class="active" id="my_jobs"><a href="#tab2">My Jobs</a></li>
    </ul>  

    <div class="tab-content">
        <div class="tab-pane jobs_table " id="tab1">
            <div class="breadcrumb-text">
                <p>
                    <a href="#">My Job</a>
                    <a href="#" id="browse-jobs">Browse Jobs</a>
                    <a href="#" id="calendar-jobs" style="display:none">Calendar Jobs</a>                
                </p>
            </div>
            <button class="btn btn-primary float-right" id="show-calendar" style="margin-right:20px;"><i class="icon-calendar calender"></i> Show calendar</button>
            <button class="btn btn-primary float-right" id="hide-calendar" style="margin-right:20px;display:none"><i class="icon-calendar calender"></i> Hide calendar</button>

            <div class="clear"></div><br>
            <span class='load-ajax-browse' style="display:block"></span> 
            <div id="browse-jobs-table" class="table-border browse-jobs-table">
                <!--   <div class="row-fluid header_cell">
                                    <div class="span7">
                                             <i class="icon-calendar"></i><h3 class="page-title"> Month</h3>  header label 
                                             JUN 2013
                                         </div>
 
                     <div class="span12">
                      <select name="small" class="select-block select-role">
                             <option value="0" selected="true">Upcoming</option>
                                                         <option value="1">Today</option>
                                                         <option value="2">Tommorow</option>
                                                         <option value="3">This Week</option>
                                                         <option value="4">This Month</option>
                         </select>
 
                     </div>
                                     <div class="span3">
                                             <div class="control-group small ctrl-grp">
                                                 <div class="input-append">
                                                     <input class="span2" id="appendedInputButton-04" type="text" placeholder="Search">
                                                     <button class="btn btn-small" type="button"><span class="fui-search"></span></button>
                                                 </div>
                                             </div>
                                         </div>
                 </div>-->
                <!-- Row Div header -->
                <div class="row-fluid ">
                    <div class="span12 header-title">
                        <div class="job-logo header-sub"> Logo</div>
                        <div class="job-date header-sub"> Job Date</div>
                        <div class="job-time header-sub">Duration</div>
                        <div class="job-wage header-sub">Wages</div>
                        <div class="job-progress header-sub">Progress</div>
                        <div class="job-action header-sub">Action</div>
                    </div>
                </div>

                <div class="row-fluid " id="accordion2" >

                </div>

                <button class="btn load_more" id="load-more"> <div><span class='load_ajax' style="display:block"></span> <b>Load more</b></div></button>
            </div>
            <br>
            <div style=" display:none; " id="calendar">

                <div id="calhead" style="padding-left:1px;padding-right:1px;">          
                    <div class="cHead"><div class="ftitle"></div>
                        <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>
                        <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
                    </div>          

                    <div id="caltoolbar" class="ctoolbar">
                        <!--                        <div id="faddbtn" class="fbutton">
                                                    <div><span title='Click to Create New Event' class="addcal">
                        
                                                            New Event                
                                                        </span></div>
                                                </div>-->
                        <div class="btnseparator"></div>
                        <!--                        <div id="showtodaybtn" class="fbutton">
                                                    <div><span title='Click to back to today ' class="showtoday">
                                                            Today</span></div>
                                                </div>-->
                        <div class="btnseparator"></div>

                        <!--                        <div id="showdaybtn" class="fbutton ">
                                                    <div><span title='Day' class="showdayview">Day</span></div>
                                                </div>-->
                        <div  id="showweekbtn" class="fbutton ">
                            <div><span title='Week' class="showweekview">Week</span></div>
                        </div>
                        <div  id="showmonthbtn" class="fbutton fcurrent ">
                            <div><span title='Month' class="showmonthview">Month</span></div>

                        </div>
                        <div class="btnseparator"></div>
                        <div  id="showreflashbtn" class="fbutton">
                            <div><span title='Refresh view' class="showdayflash">Refresh</span></div>
                        </div>
                        <div class="btnseparator"></div>
                        <div id="sfprevbtn" title="Prev"  class="fbutton">
                            <span class="fprev"></span>

                        </div>
                        <div id="sfnextbtn" title="Next" class="fbutton">
                            <span class="fnext"></span>
                        </div>
                        <div class="fshowdatep fbutton">
                            <div>
                                <input type="hidden" name="txtshow" id="hdtxtshow" />
                                <span id="txtdatetimeshow">Loading</span>

                            </div>
                        </div>

                        <div class="clear"></div>
                    </div>
                </div>
                <div >

                    <div class="t1 chromeColor">
                        &nbsp;</div>
                    <div class="t2 chromeColor">
                        &nbsp;</div>
                    <div id="dvCalMain" class="calmain printborder">
                        <div id="gridcontainer" style="overflow-y: visible;">
                        </div>
                    </div>
                    <div class="t2 chromeColor">

                        &nbsp;</div>
                    <div class="t1 chromeColor">
                        &nbsp;
                    </div>   
                </div>

            </div>
        </div>
        <!-- /tabs -->
        <div class="tab-pane active" id="tab2">
            <div class="breadcrumb-text">
                <p>
                    <a href="#">My Jobs</a>
                    Job List
                </p>
            </div>
            <div id="jobs-list">
                <div class="tab-pane" id="tab2">
                    <?php
                    if (get_user_role() === "employer") {
                        ?>
                        <div class="dialog dialog-success">
                            <button class="btn btn-primary btn-wide mll" id="add-job-button">
                                <i class="fui-mail"></i>
                                Add Jobs
                            </button>
                        </div>
                    <?php } ?>

                    <div id="add-job-form" style="display:none;">

                        <?php
                        if (check_access() === true) {
                            ?>
                            <div class="alert alert-success alert-box " id="job-success" style="display:none;">  <button data-dismiss="alert" class="close" type="button">×</button>You have successfully add a job.</div>
                            <!--                        <div id="success_msg" style="background-color:greenyellow;display:none;">Job added</div>-->
                            <div id="ajax-load" class="modal_ajax_large" style="display:none"></div>
                            <form id="job-form" class="form-horizontal">
                                <input type="hidden" value="" id="user_skills"></input>
                                <input type="hidden" value="" name="id"></input>
                                <div class="control-group small">
                                    <label class="control-label" for="inputtask">Tasks</label>
                                    <div class="controls ">
                                       <!-- <input type="text" id="job_task" name="job_task" value="" placeholder="" class="span3">-->
                                        <textarea class="span6" name="job_task" rows="10" id="job_task" maxlength="100" cols="4" placeholder="" style="height:70px;"></textarea>
                                    </div>
                                </div>
                                <div class="control-group small float-left ">
                                    <label class="control-label" for="inputtask">Start</label>
                                    <div class="controls">
                                        <div class="input-prepend input-datepicker">
                                            <button type="button" class="btn"><span class="fui-calendar"></span></button>
                                            <input type="text" class="span1" readonly name="job_start_date" value="" id="job_start_date">
                                        </div>

                                    </div>
                                </div>
                                <div class="input-append bootstrap-timepicker controls" style=" margin-left: 10px; ">
                                    <input id="job_start_time" type="text" class="timepicker-default input-small" name="job_start_time" >
                                    <span class="add-on">
                                        <i class="icon-time"></i>
                                    </span>
                                </div>
                                <div class="clear"></div>
                                <div class="control-group small float-left" >
                                    <label class="control-label" for="inputtask">End</label>
                                    <div class="controls">
                                        <div class="input-prepend input-datepicker">
                                            <button type="button" class="btn"><span class="fui-calendar"></span></button>
                                            <input type="text"  name="job_end_date" class="span1 hasDatepicker" value="" disabled id="job_end_date" style="width: 100px;">
                                        </div>
                                    </div>

                                </div>
                                <div class="input-append bootstrap-timepicker controls" style=" margin-left: 10px; ">
                                    <input id="job_end_time" type="text" class="timepicker-default input-small" name="job_end_time">
                                    <span class="add-on">
                                        <i class="icon-time"></i>
                                    </span>
                                </div>
                                <div class="clear"></div>
                                <div class="control-group small">
                                    <label class="control-label" for="inputtask">Minyawns Required</label>
                                    <div class="controls ">
                                        <input type="text" name="job_required_minyawns" id="job_required_minyawns" placeholder="" value="1" class="spinner">
                                    </div>
                                </div>


                                <div class="control-group small">
                                    <label class="control-label" for="inputtask">Price Per Minyawn</label>

                                    <div class="controls small">
                                        <div class="input-prepend">
                                            <span class="add-on"><i class="icon-dollar"></i></span>
                                            <input class="span2" id="job_wages" type="text" name="job_wages" >
                                        </div>
                                    </div>


                                </div>
                                <div class="control-group small">
                                    <label class="control-label" for="inputtask">Location</label>
                                    <div class="controls ">
                                        <input type="text" name="job_location" id="job_location" value="" placeholder="" class="span8">
                                    </div>
                                </div>

                                <div class="control-group small">
                                    <label class="control-label" for="inputtask">Tags</label>
                                    <div class="controls ">
                                        <input  name="job_tags" id="job_tags" value="" placeholder="Tags here" class="tm-input tagsinput">
                                    </div>
                                </div>
                                <div class="control-group small">
                                    <label class="control-label" for="inputtask">Details</label>
                                    <div class="controls ">
                                        <textarea class="span6" name="job_details" rows="10" id="job_details" cols="4" placeholder="" style="height:70px;"></textarea>
                                    </div>
                                </div>
                                <hr>
                                <a id="add-job" href="#" class="btn btn-large btn-block btn-inverse span2 float-right" >Submit</a>
                                <div class="clear"></div>
                            </form>
                        <?php } ?>                   

                    </div>
                    <span class='load_ajax1_myjobs' style="display:block"></span>
                    <div id="list-my-jobs">


                    </div>
                </div>



            </div>
        </div>

    </div>
</div>
</div>

<?php
get_footer();
?>

