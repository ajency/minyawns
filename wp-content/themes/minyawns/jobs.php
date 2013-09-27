<?php
/**
  Template Name: Jobs

 */
get_header();
global $minyawn_job;
require 'templates/_jobs.php';
$args = array(
	'type'                     => 'job',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'exclude'                  => '',
	'include'                  => '',
	'number'                   => '',
	'taxonomy'                 => 'category',
	'pad_counts'               => false 

);
$all_categories = get_categories(array('hide_empty' => 0 ) );
?>

<!-- Row Div -->

<style>
    .category_label{
        margin-right: 5px !important; 
        margin-top: -2px !important;
    }
    .category_name{
        display: inline-block !important;
        margin-right: 5px !important;
        padding-top: 8px !important;
    }
    
    </style>


<div class="container">
  
<input type="hidden" name="categoryids[]" id="category_id"/>
    <ul class="nav nav-tabs nav-append-content jobs_menu">
        <li <?php if(isset($_GET['cat_id'])){ ?>class="active" <?php } ?> ><a  href="#tab1" id="browse">Browse Jobs</a></li>
        <li <?php if(!isset($_GET['cat_id'])){ ?>class="active" <?php } ?> id="my_jobs"><a href="#tab2">My Jobs</a></li>

    </ul>  
    <input type="hidden" id="tab_identifier" />
    <div class="tab-content">
        <div class="tab-pane jobs_table <?php if(isset($_GET['cat_id'])){ ?> active <?php } ?>" id="tab1">
            <div class="breadcrumb-text">
                <p>
                    <a href="#">My Job</a>
                    <a href="#" id="browse-jobs">Browse Jobs</a>
                    <a href="#" id="calendar-jobs" style="display:none">Calendar Jobs</a>                
                </p>
            </div>
            <?php if(isset($_GET['cat_id'])){?> <span class="label" onclick="remove_cat()">test category</span> <?php }?>
            <button class="btn btn-primary float-right" id="show-calendar" style="margin-right:20px;"><i class="icon-calendar calender"></i> Show calendar</button>
            <button class="btn btn-primary float-right" id="hide-calendar" style="margin-right:20px;display:none"><i class="icon-calendar calender"></i> Hide calendar</button>

            <div class="clear"></div><br>
            <span class='load-ajax-browse' style="display:block"></span> 
            <div id="browse-jobs-table" class="table-border browse-jobs-table">

                <!-- Row Div header -->
                <div class="row-fluid ">
                    <div class="span12 header-title">
                        <div class="job-logo header-sub"> Logo</div>
                        <div class="job-date header-sub"> Job Date</div>
                        <div class="job-time header-sub">Duration</div>
                        <div class="job-wage header-sub">Applicants</div> 
                        <div class="job-progress header-sub">Progress</div>
                        <div class="job-action header-sub">Wages</div>

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
        <div class="tab-pane jobs_table  <?php if(!isset($_GET['cat_id'])){ ?> active <?php } ?>" id="tab2">
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
                                    <label class="control-label" for="inputtask">Total Price Per Minyawn</label>

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
                                    <label class="control-label" for="inputtask">Job Category</label>
                                    <div class="controls ">
                                        <?php
                                        foreach ($all_categories as $category) {
                                            ?>
                                            <input class="category_label" type="checkbox" value="<?php echo $category->cat_ID ?>" name="category-<?php echo $category->cat_ID ?>" id="category"/><span class="category_name"><?php echo $category->name ?></span>
                                            <?php
                                        }
                                        ?>
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
                    <span class='load_ajax1_myjobs' style="display:none"></span>
                    <div id="list-my-jobs">
                        <div class="row-fluid ">
                            <div class="span12 header-title">
                                <div class="job-logo header-sub"> Logo</div>
                                <div class="job-date header-sub"> Job Date</div>
                                <div class="job-time header-sub">Duration</div>
                                <div class="job-wage header-sub">Applicants</div> 
                                <div class="job-progress header-sub">Progress</div>
                                <div class="job-action header-sub">Wages</div>

                            </div>
                        </div>

                        <div class="row-fluid " id="accordion24" >

                        </div>

                        <button class="btn load_more" id="load-more-my-jobs"> <div><span class='load_ajax' style="display:block"></span> <b>Load more</b></div></button>

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

