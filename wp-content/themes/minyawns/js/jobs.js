jQuery(document).ready(function($) {

    var first = getUrlVars()["cat_id"];

    if (typeof(first) !== 'undefined')
    {

        load_browse_jobs('', '', first);
    } else {
        /* function on page load*/

        fetch_my_jobs(logged_in_user_id);//moved to jobs.js

    }


});
function load_browse_jobs(id, _action, category_ids) {
   
    //jQuery("#browse-jobs-table").append("<button id='load-more' class='btn load_more'> <div><span style='display: none;' class='load_ajax'></span> <b>Load more</b></div></button>");
    jQuery("#tab_identifier").val('0');
    jQuery(".load_ajax").css('display', 'block');
    jQuery("#calendar-jobs").hide(); /*bread crumbs*/
    jQuery("#calendar").hide();

    jQuery(".load_more").show();
    jQuery(".load-ajax-browse").hide();

    var Fetchjobs = Backbone.Collection.extend({
        model: Job,
        url: function() {

            return SITEURL + '/wp-content/themes/minyawns/libs/job.php/fetchjobs'
        }
    });
    if (category_ids === undefined) {
        var category_ids = 0;
    }


    // var category_ids=(category_ids)> 0 ? 1:0;
    var first = getUrlVars()["cat_id"];



    if (category_ids.length > 0)
        var filter = category_ids;
    else
        var filter = 0;


//  if(filter === 1)
//    var catids=$("#category_id").val();
//
    window.fetchj = new Fetchjobs;
    // if(!isNaN(id))
    window.fetchj.set({single_job: '1'});
    var _data = {
        'offset': 0,
    };

    if (!isNaN(id) && filter === 0)
        _data.single_job = id;

    if (typeof(first) !== 'undefined' || category_ids !== 0)
        _data.filter = category_ids;





    window.fetchj.fetch({
        data: _data,
        reset: true,
        success: function(collection, response) {
            console.log(_action);
            if (collection.length === 0) {
                jQuery("#accordion2").empty();
                var template = _.template(jQuery("#no-result").html());
                jQuery("#accordion2").append(template);
                jQuery("#load-more").hide();
            } else {

                var template = _.template(jQuery("#jobs-table").html());
                var samplejobs = _.template(jQuery("#sample-jobs-template").html());
                _.each(collection.models, function(model) {
                    var job_stat = job_status_e(model);
                    var job_collapse_button_var = job_collapse_b(model);
                    var minyawns_grid = job_minyawns_grid(model);
                    if (model.toJSON().post_id === id) { /*for single job page*/

                        if (_action === 'single_json')
                        {

                            if (model.toJSON().load_more === 1)
                                jQuery("#load-more").hide();

                            var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var, minyawns_grid: minyawns_grid});
                            jQuery("#job-accordion-" + id).replaceWith(html);


//                            jQuery("#job-accordion-" + id).flip({
//                                direction: 'bt',
//                                content: html
//                            })
                        } else if (_action === 'single_json_my_jobs') /*load single jobs tab*/
                        {

                            jQuery("#no-result").hide();
                            jQuery("#load-more-my-jobs").hide();
                            if (model.toJSON().load_more === 1) {
                                jQuery("#load-more").hide();

                            }


                            //jQuery(".jobs_menu").find("li").removeClass("active");
                            //    jQuery(".jobs_menu").append("<li class='active' id='my_jobsm'><a href='#tab2'>'" + model.toJSON().load_more + "'</a></li>");
                            var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var, minyawns_grid: minyawns_grid});
                            jQuery("#accordion24").prepend(html);



                            var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var, minyawns_grid: minyawns_grid});
                            jQuery("#accordion24").append(html);

                            var sample = samplejobs({result: model.toJSON()});
                            jQuery(".reuse-job").append(sample);


                        } else {
                         
                            jQuery(".job-view-list").empty();
                            jQuery("#hidden_minion_id").val(model.toJSON().applied_user_id);
                            jQuery("#job_id").val(id);

                            var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var, minyawns_grid: minyawns_grid});
                            jQuery(".job-view-list").animate({
                                left: parseInt(jQuery(".job-view-list").css('left'), 100) === 0 ?
                                        -jQuery(".job-view-list").outerWidth() :
                                        0
                            }, "slow").append(html);
                            jQuery(".details").find(".minyawansgrid").hide();
                            jQuery("#select-minyawn").removeAttr('href');
                            jQuery("#select-minyawn").live("click", function() {
                                jQuery("html, body").animate({scrollTop: jQuery(document).height()}, 1000);
                            });
                            jQuery(".load_ajaxsingle_job").hide();
                            jQuery("#collapse" + model.toJSON().post_id + "").addClass("in");
                            load_job_minions(model);
                            jQuery(".load_ajaxsingle_job_minions").hide();

                        }

                    } else {

                        if (model.toJSON().load_more === 1)
                            // jQuery(".load_more").hide();

                            var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var, minyawns_grid: minyawns_grid});
                        jQuery("#accordion2").append(html);

                    }
                });
                jQuery(".load_ajax").hide();
            }



        },
        error: function(err) {
            console.log(err);
        }

    });

}




function fetch_my_jobs(id)
{

    if (window.location.href.indexOf("cat_id") > 0)
        window.location = window.location.href.split('?')[0];

    // window.location.href = window.location.href.split('?')[0];
    //jQuery("#browse-jobs-table").find("button").remove();
    jQuery("#tab_identifier").val('1');
    jQuery("#accordion2").empty();
//  jQuery("#list-my-jobs").empty();
    //jQuery(".browse-jobs-table").empty();
    jQuery("#load-more-my-jobs").show();
    var Fetchjobs = Backbone.Collection.extend({
        model: Job,
        unique: true,
        url: SITEURL + '/wp-content/themes/minyawns/libs/job.php/fetchjobs'
    });
    window.fetchj = new Fetchjobs;
    window.fetchj.fetch({
        data: {
            'my_jobs': 1,
            'offset': 0

        },
        success: function(collection, response) {
            //jQuery(".load_ajax1_myjobs").hide();
            if (collection.length === 0) {
                var template = _.template(jQuery("#no-result").html());

                jQuery("#load-more-my-jobs,.load_more_profile").hide();
                jQuery(".previous-jobs").hide();
                jQuery("#accordion24").html(jQuery("#no-result").html());
            } else {
                // jQuery("#load-more-my-jobs").hide();
                jQuery(".no-result").hide()
                jQuery("#accordion24").empty();
                var template = _.template(jQuery("#jobs-table").html());
                var samplejobs = _.template(jQuery("#sample-jobs-template").html());
                var minyawns_grid;
                _.each(collection.models, function(model) {
//                    alert(id);
//                     alert(model.toJSON().applied_user_id);
                    if (model.toJSON().job_owner_id === id || model.toJSON().applied_user_id.indexOf(id) >= 0)/* to show my jobs*/
                    {
                        var template = _.template(jQuery("#jobs-table").html());
                        // alert(model.toJSON().load_more);
                        //  console.log(model.toJSON().applied_user_id);
                        var job_stat = job_status_e(model);
                        var job_collapse_button_var = job_collapse_b(model);
                        //console.log(model);
                        var minyawns_grid = job_minyawns_grid(model);
                        // console.log(minyawns_grid);

                        if (model.toJSON().load_more === 1)
                            jQuery("#load-more-my-jobs,.load_more_profile").hide();

                        var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var, minyawns_grid: minyawns_grid});
                    
                        jQuery("#accordion24").append(html);

                        //if (model.toJSON().load_more === 1) {
                        var sample = samplejobs({result: model.toJSON()});
                        jQuery(".reuse-job").append(sample);
                        // }



                    } else
                    {
                        jQuery(".load_more").hide();
                        var template = _.template(jQuery("#no-result").html());
                        jQuery("#accordion24").html(jQuery("#no-result").html());

                    }
                });
                jQuery(".load_ajax").hide();
                //}

            }

        },
        error: function(err) {
//console.log(err);
        }

    });


}

var Job = Backbone.Model.extend({
    url: function() {
        return SITEURL + '/wp-content/themes/minyawns/libs/job.php/addjob';
    },
    validate: function(attr) {


        var errors = [];
        if (attr.job_start_date !== '' && attr.job_end_Date !== '') {
            if (Date.parse(attr.job_start_date) > Date.parse(attr.job_end_date))
            {
                errors.push({field: 'job_end_date', msg: 'End date cannot be less than start date.'});
            }
        }
        if (attr.job_start_date == '')
        {
            errors.push({field: 'job_start_date', msg: 'Please fill the start date field.'});
        }

        if (attr.job_end_date == '')
        {
            errors.push({field: 'job_end_date', msg: 'Please fill the  end date field.'});
        }

        if (attr.job_end_time == '') {

            errors.push({field: 'job_end_time', msg: 'Please fill the  end time.'});
        }

        if (attr.job_start_time == '') {
            errors.push({field: 'job_start_time', msg: 'Please fill the  start time.'});
        }

        if (!attr.job_wages) {
            errors.push({field: 'job_wages', msg: 'Please fill wages field.'});
        }
        if (!attr.job_required_minyawns)
            //errors.push({field: 'job_required_minyawns', msg: 'Please enter required field'});
            if (!attr.job_location)
                errors.push({field: 'job_location', msg: 'Please enter location'});
//            if (!attr.job_tags)
//                errors.push({field: 'job_tags', msg: 'Please enter tags'});
        if (attr.job_required_minyawns == 0)
            errors.push({field: 'job_required_minyawns', msg: 'Please select more than one'});
        if (!attr.job_details)
            errors.push({field: 'job_details', msg: 'Please enter job details'});
        if (!attr.job_task)
            errors.push({field: 'job_task', msg: 'Please enter ' + 'tasks'});
        if (errors.length > 0)
            return errors;
    }

});
/*
 *
 * @param {type} model of each job with details
 * @returns string having job status
 *
 */
function job_status_e(model) {
    var job_status = '';
    var return_status = '';
//model.toJSON().job_status != 1
    if (model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check && (model.toJSON().job_status == 1||  model.toJSON().job_status == 0)) {

        job_status = "Available";

    }
    else if (model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check && (model.toJSON().job_status === 3 || model.toJSON().job_status === 2)) {

        job_status = "Closed";
    }
    else
    {

        job_status = "Expired";
    }

    switch (job_status)
    {
        case 'Available': //JOB STATUS AVAILABLE



            if (model.toJSON().users_applied.length === 0) // 0 APPLICANTS
            {

                if (model.toJSON().user_to_job_status.indexOf('hired') >= 0)
                    return_status = '';
                else
                    return_status = "<div class='st-status open'>Applications Open.</div><div class='st-meta'>" + model.toJSON().days_to_job_expired + "days to go</div>";


            }
            else //X MINIONS APPLIED
            {

                if (model.toJSON().user_to_job_status.indexOf('hired') >= 0)
                    return_status = '';
                else
                    return_status = "<div class='st-status open'>Applications Open.</div><div class='st-meta'>" + model.toJSON().days_to_job_expired + "days to go</div>";

            }


            break;

        case 'Closed': //JOB STATUS CLOSED

            if (model.toJSON().job_status === 3)//Max Applicants reached
            {
                if (model.toJSON().job_owner_id !== logged_in_user_id && role === 'employer') {
                    return_status = 'Applications Closed';
                } else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0) {
                    return_status = '';
                } else {
                    return_status = "<div class='st-status open'>" + 'Applications Closed Maximum number of minions have applied</div>';
                }
               
            }
            else   //SELECTION DONE
            {
                
                var numOfHired = 0;
              
                for (var i = 0; i < model.toJSON().user_to_job_status.length; i++) {
                    var status=model.toJSON().user_to_job_status[i];
                    if (status === 'hired')
                        numOfHired++;


                }
               
                
                if (numOfHired > 0)
                   return_status = "<div class='st-status open'>"+numOfHired + '  have een selected' + model.toJSON().days_to_job_expired + '  day to go for the job</div>';


     

            }

            break;
        case 'Expired': //EXPIRED

            if (model.toJSON().applied_user_id.indexOf(logged_in_user_id) >= 0 && role === 'Minion') { //check and show if logged in minyawn is rated

                for (var i = 0; i < model.toJSON().user_to_job_status.length; i++)
                {
                   
                    if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_rating[i] !== 'Rating:Awaited'){
                        return_status = "<div class='st-status open'>Job Date is Over.You have been rated &nbsp;&nbsp;" + model.toJSON().user_to_job_rating[i] + "</div>";
                      break;
                    }else{
                        return_status = "<div class='st-status closed'>Job Date is Over</div>";
                    }
                }
            } else
            {
                return_status = "<div class='st-status closed'>Job Date is Over</div>";

            }



            break;
        default:
            return_status = 'Bummer! We will have this fixed';

    }

    return return_status;

}
/*
 * 
 * @param {type} model
 * @returns {String} BUTTON HTML AS STRING 
 *  TO BE PRINTED IN THE VIEW
 * 
 */

function job_collapse_b(model) {

    var job_time = '';

    var job_button = '';


     if (model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check && (model.toJSON().job_status == 1 ||  model.toJSON().job_status == 0)) {

        job_time = "Available";

    }
    else if (model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check && (model.toJSON().job_status === 3 || model.toJSON().job_status === 2)) {

        job_time = "Closed";
    }
    else
    {

        job_time = "Expired";
    }



    switch (job_time) {


        case 'Available':


            if (logged_in_user_id) {

                if (model.toJSON().no_applied === 0) // 0 APPLICANTS/NO ONE APPLIED
                {

                    if (role === 'Employer') {


                        if (model.toJSON().job_owner_id === logged_in_user_id) // IS JOB OWNER
                            job_button = "<a href='#fakelink' class='btn btn-primary'><i class='icon-location-arrow'></i>Send Invites</a>";
                        else //OTHER EMPLOYERS
                            job_button = "<i class='icon-location-arrow'></i>Create Similar Jobs";
                    }
                    else// USER ROLE MINION
                    {
                         
                         if(model.toJSON().applied_user_id.length >0){//IF NO ONE HAS APPLIED
                        for (var i = 0; i < model.toJSON().applied_user_id.length; i++) {

                            if (model.toJSON().applied_user_id[i] === logged_in_user_id)   //user has applied   
                            {
                                job_button = "<div class='st-applicant'>" + model.toJSON().no_applied + " have applied.</div><a href = '#' id = 'unapply-job' class ='btn btn-primary ' data-action ='unapply' data-job-id= " + model.toJSON().post_id + "><i class='icon-remove'></i>Un-apply</a>";

                            } else
                            {

                                job_button = "<div class='st-applicant'>" + model.toJSON().no_applied + " have applied.</div><a href = '#' id = 'apply-job-browse' class ='btn btn-primary ' data-action ='apply' data-job-id= " + model.toJSON().post_id + "><i class='icon-ok'></i>Apply Now</a>";

                            }


                        }
                         }else
                             {
                                 job_button = "<div class='st-applicant'>" + model.toJSON().no_applied + " have applied.</div><a href = '#' id = 'unapply-job' class ='btn btn-primary ' data-action ='apply' data-job-id= " + model.toJSON().post_id + "><i class='icon-ok'></i>Apply Now</a>"; 
                             }

                    }

                } else //X applicants
                {
                    if (role === 'Employer') {
                        if (model.toJSON().job_owner_id === logged_in_user_id) // IS JOB OWNER
                            job_button = " <div class='st-applicant'>" + model.toJSON().no_applied + " have applied.</div><a href='" + siteurl + '/jobs/' + model.toJSON().post_slug +"' class='btn btn-primary'><i class='icon-check'></i>Select Minions</a>"
                        else
                            job_button = "<a class='st-green-link' href='#'><i class='icon-location-arrow'></i>Create Similar Jobs</a>";
                    } else// USER ROLE MINION
                    {

                        for (var i = 0; i < model.toJSON().applied_user_id.length; i++) {

                            if (model.toJSON().applied_user_id[i] === logged_in_user_id)   //user has applied   
                            {
                                job_button = "<div class='st-applicant'>" + model.toJSON().no_applied + " have applied.</div><a href = '#' id = 'unapply-job' class ='btn btn-danger ' data-action ='unapply' data-job-id= " + model.toJSON().post_id + "><i class='icon-remove'></i>Un-apply</a>";
                                break;
                            } else
                            {

                                job_button = "<div class='st-applicant'>" + model.toJSON().no_applied + " have applied.</div><a href = '#' id = 'unapply-job' class ='btn btn-primary ' data-action ='apply' data-job-id= " + model.toJSON().post_id + "><i class='icon-ok'></i>Apply Now</a>";

                            }


                        }
                    
                    }

                }


            } else
            {
                job_button = job_button = "<a class='st-green-link' href='#'><i class='icon-location-arrow'></i>Sign In to apply</a>";

            }

            break;


        case 'Closed':

            if (logged_in_user_id) {

                if (model.toJSON().job_status === 3)//Max Applicants reached
                {

                    if (role == "Employer")//EMPLOYER
                    {
                        if (model.toJSON().job_owner_id === logged_in_user_id) // IS JOB OWNER
                            job_button = " <div class='st-applicant'>" + model.toJSON().no_applied + " have applied.</div><a href='" + siteurl + '/jobs/' + model.toJSON().post_slug +"' class='btn btn-primary'><i class='icon-check'></i>Select Minions</a>"
                        else
                            job_button = "<a class='st-green-link' href='#'><i class='icon-location-arrow'></i>Create Similar Jobs</a>";


                    } else //MINION
                    {
                        for (var i = 0; i < model.toJSON().applied_user_id.length; i++)
                        {

                            if (model.toJSON().applied_user_id[i] == logged_in_user_id) {//APPLIED USER 
                                job_button = "<div class='st-applicant'> You have already Applied. </div><a href = '#' id = 'unapply-job' class ='btn btn-danger ' data-action ='unapply' data-job-id= " + model.toJSON().post_id + "><i class='icon-remove'></i>Un-apply</a>";
//alert(model.toJSON().applied_user_id[i]);

                            }
                            else if(model.toJSON().applied_user_id.indexOf(logged_in_user_id) === -1 ) {
                               
                                job_button = "<a class='st-green-link' href='#'><i class='icon-location-arrow'></i>Find Similar Jobs</a>";
                            }

                        }



                    }

                } else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0)//SELECTION DONE
                {

                    if (role == "Employer")//EMPLOYER
                    {
                        if (model.toJSON().job_owner_id === logged_in_user_id) // IS JOB OWNER
                            job_button = "";
                        else
                            job_button = "<a class='st-green-link' href='#'><i class='icon-location-arrow'></i>Create Similar Jobs</a>";


                    } else //MINION
                    {

                        for (var i = 0; i < model.toJSON().applied_user_id.length; i++)
                        {

                            if (model.toJSON().user_to_job_status[i] === 'hired' && model.toJSON().applied_user_id[i] === logged_in_user_id) {
                                job_button = " You have been hired";

                            } else
                            {
                                job_button = "<a class='st-green-link' href='#'><i class='icon-location-arrow'></i>Find Similar Jobs</a>";

                            }

                        }

                    }

                }
            } else
            {
                job_button = "<a class='st-green-link' href='#'><i class='icon-location-arrow'></i>Find Similar Jobs</a>";
            }
            break;


        case 'Expired':


            if (model.toJSON().user_to_job_rating.indexOf('Well Done') == -1 || model.toJSON().user_to_job_rating.indexOf('Terrible') == -1) //RATINGS PENDING FOR ALL
            {

                if (logged_in_user_id)// IF USER IS LOGGED IN
                {

                    if (role === 'Employer') {
                        if (model.toJSON().job_owner_id === logged_in_user_id) // 1) IF USER IS A JOB OWNER
                            job_button = "<a class='st-green-link' href='" + siteurl + '/jobs/' + model.toJSON().post_slug +"' target='_blank'>Give ratings to minions</a>";
                        else
                            job_button = "<a href='#fakelink' class='btn btn-primary'><a class='st-green-link' href='#'>Create Similar Jobs</a></a>";

                    } else if (role === 'minion') //USER ROLE MINION
                    {
                        for (var i = 0; i < model.toJSON().applied_user_id.length; i++) {//IF MINION HIRED OR RATED SHOW BLANK
                            if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status.indexOf('hired') > 0)
                                job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";
                            else
                                job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";
                        }
                    } else //NOT LOGGED IN USER
                    {
                        job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";
                    }



                } else
                {
                    job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";
                }


            } else if (model.toJSON().user_to_job_status.indexOf('hired') == -1) {//EXPIRED WITHOUT SELECTION

                if (logged_in_user_id)
                {
                    if (role === 'Employer') { // ROLE IS EMPLOYER

                        if (model.toJSON().job_owner_id === logged_in_user_id) // 1) IF USER IS A JOB OWNER
                            job_button = "<a href='#' class='st-green-link'>Do you want to  repeat the job ?</a>";
                        else
                            job_button = "<a href='#fakelink' class='btn btn-primary'><a class='st-green-link' href='#'>Create Similar Jobs</a></a>";


                    } else // ROLE IS MINIONS
                    {
                        for (var i = 0; i < model.toJSON().applied_user_id.length; i++) {//IF MINION HIRED OR RATED SHOW BLANK
                            if (model.toJSON().user_to_job_status[i] === 'hired')
                                job_button = "";
                            else
                                job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";
                        }

                    }

                } else
                {
                    job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";
                }

            } else if (model.toJSON().count_rated == 1 || model.toJSON().count_rated == 0)//RATINGS DONE FOR ALL
            {
                if (logged_in_user_id) {
                    if (role === 'Employer')//ROLE EMPLOYER
                    {
                        if (model.toJSON().job_owner_id === logged_in_user_id) // 1) IF USER IS A JOB OWNER
                            job_button = "<a href='#' class='st-green-link'>Do you want to repeat the job ?</a>";
                        else
                            job_button = "<a class='st-green-link' href='#'>Create Similar Jobs</a>";

                    } else //ROLE MINION
                    {

                        job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";



                    }



                } else
                {
                    job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";


                }


            } else //RATINGS PENDING FOR A FEW
            {
                if (logged_in_user_id) {
                    if (role === 'Employer')//ROLE EMPLOYER
                    {


                    } else //ROLE MINION
                    {



                    }



                } else
                {
                    job_button = "<a class='st-green-link' href='#'>Find Similar Jobs</a>";


                }
            }
            break;

        default:

            job_button = 'Bummer! We will have this fixed asap!';



    }

    return job_button;





}

function job_collapse_button(model)
{

    var status_button;
    if (logged_in_user_id)
    {
        if (role === 'Minion') {



            if (model.toJSON().applied_user_id.indexOf(logged_in_user_id) >= 0) { /* if user applied*/
//alert(logged_in_user_id);
                for (var i = 0; i < model.toJSON().applied_user_id.length; i++)
                {

                    if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check)
                        status_button = "<a href = '#' id = 'unapply-job' class ='btn btn-mini btn-danger ' data-action ='unapply' data-job-id= " + model.toJSON().post_id + "  > Unapply </a>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired' && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check)
                        status_button = "<span  class='job-text-color'>You are Hired.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check)
                        status_button = "<span  class='job-text-color'>Minions Have been selected.</span>";
                    //else if (model.toJSON().applied_user_id[i] !== logged_in_user_id && model.toJSON().user_to_job_status.indexOf('applied') >= 0)
                    //    status_button = '<a href="#" id="apply-job-browse" class="btn btn-medium btn-block green-btn btn-success" data-action="apply" data-job-id="' + model.toJSON().post_id + '">Apply</a>';
                    else if (model.toJSON().applied_user_id.indexOf(logged_in_user_id) === -1 && model.toJSON().job_status === 2 && model.toJSON().user_to_job_status[i] !== 'hired')
                        status_button = "<span  class='job-text-color' >Selection Complete.</span>";

                    else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check && model.toJSON().user_to_job_rating !== 'Rating:Awaited')
                        status_button = "<span  class='job-text-color' >You have been rated &nbsp;&nbsp;" + model.toJSON().user_to_job_rating[i] + "</span>";

                    else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check)
                        status_button = '<span class="job-expired" >Job Expired.</span>';



                }
            } else
            {
                if (model.toJSON().job_status === 3 && model.toJSON().user_to_job_status.indexOf('hired') === -1)
                    status_button = "<span  class='job-text-color'>Applications Closed.</span>";
                else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0)
                    status_button = "<span class='job-text-color'>Selection Complete.</span>";
                else if (model.toJSON().job_status === 1 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check)
                    status_button = '<a href="#" id="apply-job-browse" class="btn btn-primary btn-mini " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Apply</a>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check)
                    status_button = '<span class="job-expired" >Job Expired.</span>';


            }


        } else
        {

            if (model.toJSON().job_owner_id === logged_in_user_id)
            {

                if (model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /*applied but not hired*/
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="job-text-color " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';
                else if (model.toJSON().job_status === 3 && model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* max applications job locked  */
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="job-text-color" data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';
                else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* not locked but hired  */
                    status_button = '<span class="job-text-color" >Minions Hired.</span>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check && model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /* hired and expired  */
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="job-text-color" data-action="apply" data-job-id="' + model.toJSON().post_id + '">Rate Your Minions</a>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check && model.toJSON().user_to_job_status.indexOf('hired') === -1) /*not hired and expired*/
                    status_button = "<span class='job-expired'>Job Expired.</span>";
            } else
            {
                if (model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().job_status !== 3 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* applied and but not hired */
                    status_button = "<span class='job-text-color'>Please log-in as minion to apply</span>";
                else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* applied and but not hired */
                    status_button = "<span class='job-text-color'>Selection Complete</span>";
                else if (model.toJSON().job_status === 3 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* job locked */
                    status_button = "<span class='job-text-color'>Applications closed.</span>";
                else if (model.toJSON().job_status === 2 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* hired */
                    status_button = "<span class='job-text-color'>Applications closed.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /* job Exipred */
                    status_button = "<span class='job-expired'>Job Expired.</span>";

            }
            //status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';

//alert(status_button);
        }



    } else
    {
        if ((model.toJSON().users_applied.length === 0 || model.toJSON().users_applied.length >= 0) && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check && model.toJSON().job_status !== 3)
            status_button = "<span class='job-text-color'>Available</span>";
        else if (model.toJSON().job_status === 3) /* job locked */
            status_button = "<span class='job-text-color'>Applications closed.</span>";
        else if (model.toJSON().job_status === 2 && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired */
            status_button = "<span class='job-text-color'>Selection Complete.</span>";

        else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /* job Exipred */
            status_button = "<span class='job-expired'>Job Expired.</span>";

    }
    //alert(status_button);
    return status_button;
}

function job_status_li(model)
{
    var job_status1;
    if (logged_in_user_id) {
        if (role === 'Minion') {
            // alert(model.toJSON().user_to_job_status.length);

            if (model.toJSON().applied_user_id.indexOf(logged_in_user_id) >= 0) {

                for (var i = 0; i < model.toJSON().user_to_job_status.length; i++)
                {

                    //  console.log(model.toJSON().user_to_job_status);
                    if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired' && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* if logged in minion in hired*/
                        job_status1 = "<span  class='job-text-color'>You have been selected for this job.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'applied')/*logged in user has applied for the job*/
                        job_status1 = "<span  class='job-text-color'>You have applied for this job.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'applied' && model.toJSON().job_status === 2) /*logged in user has applied for the job*/
                        job_status1 = "<span  class='job-text-color'>You have applied for this job.</span>";
//                    else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /*expired*/
//                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired' && model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /* if logged in minion in hired*/
                        job_status1 = "<span  class='job-text-color'>Ratings .</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().user_to_job_status[i] === 'applied') /* if logged in minion in hired*/
                        job_status1 = "<span  class='job-text-color'>Minions Selected.</span>";
                    else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /*expired*/
                        job_status1 = "<span class='job-expired'>Job Expired.</span>";


                }
//return job_status1;
            }
            else
            {
                //      alert("blank_users");
                if (model.toJSON().user_to_job_status.indexOf('hired') >= 0)/* if logged in is not hired but othes are*/
                    job_status1 = "<span  class='job-text-color'>Minions have been selected.</span>";

                else if (model.toJSON().job_status === 3 && model.toJSON().user_to_job_status.indexOf('hired') === -1)/* if logged in is not hired but othes are*/
                    job_status1 = "<span  class='job-text-color'>Applications Closed.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /*expired*/
                    job_status1 = "<span class='job-expired'>Job Expired.</span>";

                else
                    job_status1 = "<span  class='job-text-color'>Available.</span>";
                //     return job_status1;
            }

        } else
        {

            /*
             *  For logged in Employer
             *  <!--
             */
            if (model.toJSON().job_owner_id === logged_in_user_id)
            {

                if (model.toJSON().users_applied.length === 0 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check)
                    job_status1 = "<span  class='job-text-color'>No Applicants yet.</span>";
                else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().job_status !== 3 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /*applied but not hired*/
                    job_status1 = "<span  class='job-text-color'>Minions Applied.</span>";
                else if (model.toJSON().job_status === 3 && model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* max applications job locked  */
                    job_status1 = "<span  class='job-text-color'>Applications closed.</span>";
                else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* not locked but hired  */
                    job_status1 = "<span  class='job-text-color'>Minions Selected.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired and expired  */
                    job_status1 = "<span  class='job-text-color'>Rate Your Minions.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /* job Exipred */
                    job_status1 = "<span class='job-expired'>Job Expired.</span>";
                //return job_status1;
            }
            else
            {

                if (model.toJSON().users_applied.length === 0 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check)
                    job_status1 = "<span  class='job-text-color'>Available</span>";
                else if (model.toJSON().job_status === 3 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check)  /* applied and but not hired */
                    job_status1 = "<span  class='job-text-color'>Selection Complete</span>";
                else if (model.toJSON().job_status === 2 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* applied and but not hired */
                    job_status1 = "<span  class='job-text-color'>Applications Closed</span>";
                else if (model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* hired */
                    job_status1 = "<span  class='job-text-color'>Please login as a Minion to apply.</span>";
//                else if (model.toJSON().job_status === 2 && model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check) /* hired */
//                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please login as a Minion to apply.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /* job Exipred */
                    job_status1 = "<span class='job-expired'>Job Expired.</span>";

            }



        }
    }
    else
    {

        if (model.toJSON().users_applied.length === 0 && model.toJSON().todays_date_time < model.toJSON().job_end_date_time_check)
            job_status1 = "<span  class='job-text-color'>Available</span>";
        else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* applied and but not hired */
            job_status1 = "<span  class='job-text-color'>Minions have been selected </span>";
        else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('applied') >= 0 && model.toJSON().job_status === 1) /* applied and but not hired */
            job_status1 = "<span  class='job-text-color'>Minions have Applied </span>";
        else if (model.toJSON().job_status === 3) /* job locked */
            job_status1 = "<span  class='job-text-color'>Applications closed.</span>";
        else if (model.toJSON().job_status === 2 && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired */
            job_status1 = "<span  class='job-text-color'>Applications closed.</span>";
        else if (model.toJSON().todays_date_time > model.toJSON().job_end_date_time_check) /* job Exipred */
            job_status1 = "<span class='job-expired'>Job Expired.</span>";
    }
    //});

    return job_status1;
}




function load_job_minions(jobmodel)
{
   
    jQuery(".load_ajaxsingle_job_minions").show();
    var Fetchuserprofiles = Backbone.Collection.extend({
        model: Userprofile,
        url: SITEURL + '/wp-content/themes/minyawns/libs/job.php/jobminions'
    });
    var select_button;
    window.fetchj = new Fetchuserprofiles;
    window.fetchj.fetch({
        data: {
            minion_id: jQuery("#hidden_minion_id").val(),
            job_id: jQuery("#job_id").val()
        },
        success: function(collection, response) {

            if (collection.length > 0) {
                var template = _.template(jQuery("#minion-cards").html());
                _.each(collection.models, function(model) {
                    var global_model = model;
                    if (is_job_owner(jobmodel.toJSON().job_owner_id) || is_admin === '1')
                        var select_button = is_minion_selected(jobmodel, model);

                    var ratings_button_text = ratings_button(jobmodel, model);

                    var html = template({result: model.toJSON(), select_button: select_button, ratings_button: ratings_button_text});
                    jQuery(".thumbnails").animate({left: '100px'}, "slow").prepend(html);
                });

                if (is_job_owner(jobmodel.toJSON().job_owner_id) && jobmodel.toJSON().user_to_job_status.indexOf('hired') === -1 && jobmodel.toJSON().todays_date_time < jobmodel.toJSON().job_end_date_time_check) {
                    var template = _.template(jQuery("#confirm-hire").html());
                    //var html=template({user_id:collection.models.toJSON().user_id,job_id:jobmodel.toJSON.post_id});
                    jQuery(".list-jobs").append(template);
                }

            } else if (global_model.toJSON().todays_date_time < global_model.toJSON().job_end_date_time_check)
            {
                jQuery(".thumbnails").append(jQuery("#blank-card").html());

            }
        }
    });


}

var Userprofile = Backbone.Model.extend({
    url: function() {
        return SITEURL + '/wp-content/themes/minyawns/libs/job.php/jobminions';
    }
});

var Usercomments = Backbone.Model.extend({
    url: function() {
        return SITEURL + '/wp-content/themes/minyawns/libs/job.php/getcomments';
    }
});
//    $('input:checkbox').click(function() {
//        if ($(this).is(':checked')) {
//            $('input:checkbox').not(this).prop('checked', false);
//        }
//
//        $(this).attr("checked", "checked");
//    });

function is_job_owner(job_owner_id)
{
    var is_owner = (job_owner_id === logged_in_user_id) ? true : false;

    return is_owner;

}


function is_minion_selected(jobmodel, model)
{
    var selectButton = "";
    if (jobmodel.toJSON().applied_user_id.length > 0) {

        for (var i = 0; i <= jobmodel.toJSON().applied_user_id.length; i++)
        {
//console.log(jobmodel.toJSON());
//console.log(model.toJSON());



            if (jobmodel.toJSON().applied_user_id[i] === model.toJSON().user_id && jobmodel.toJSON().user_to_job_status[i] === 'applied' && jobmodel.toJSON().job_owner_id === logged_in_user_id && jobmodel.toJSON().user_to_job_status.indexOf('hired') === -1 && jobmodel.toJSON().todays_date_time < jobmodel.toJSON().job_end_date_time_check) {
                selectButton = '<div class="roundedTwo" id="select-button-' + model.toJSON().user_id + '"><input type="checkbox" id="select-' + model.toJSON().user_id + '" name="confirm-miny[]" value="' + model.toJSON().user_id + '"  data-user-id="' + model.toJSON().user_id + '" data-job-id="' + jobmodel.toJSON().post_id + '"><label for="rounded1' + model.toJSON().user_id + '" > </label>Select Your Minions</div>';
            } else if ((jobmodel.toJSON().todays_date_time > jobmodel.toJSON().job_end_date_time_check && jobmodel.toJSON().applied_user_id[i] === model.toJSON().user_id && jobmodel.toJSON().user_to_job_status[i] === 'hired' && model.toJSON().user_to_job_rating_like === '0' && model.toJSON().user_to_job_rating_dislike === '0'))
            {
                //alert(model.toJSON().rating_positive);
                var id = model.toJSON().user_id;
                jQuery("#" + id + "").addClass('minyans-select');
                selectButton += "<div class='dwn-btn'><div class='row-fluid' id='rating_container" + model.toJSON().user_id + "'><div class='span6'><a id='vote-up' class='btn btn-small btn-block  btn-success well-done' href='#like' is_rated='0' vote='1'   job-id='" + jobmodel.toJSON().post_id + "' user_id='" + model.toJSON().user_id + "' action='vote-up' emp_id='" + jobmodel.toJSON().job_owner_id + "'>+1 Well Done</a>"
                selectButton += "</div><div class='span6'><a id='vote-down'" + model.toJSON().user_id + "' class='btn btn-small btn-block  btn-danger terrible' href='#like' is_rated='0' vote='-1'   job-id='" + jobmodel.toJSON().post_id + "' user_id='" + model.toJSON().user_id + "' action='vote-down' emp_id='" + jobmodel.toJSON().job_owner_id + "'>";
                selectButton += "-1 Terrible Job</a></div><div id='review-box" + model.toJSON().user_id + "' style='display:none'><textarea type='text' id='review-text" + model.toJSON().user_id + "' class='' maxlength='160'/><div class='maxchar'>Max charector 160</div><input type='button' value='submit' class='rate-negative rate-button btn btn-medium btn-block green-btn btn-success' id='review" + model.toJSON().user_id + "' user-id='" + model.toJSON().user_id + "' job-id='" + jobmodel.toJSON().post_id + "' emp_id='" + jobmodel.toJSON().job_owner_id + "' action='' vote='' ></input></div></div>";


            }
        }
    }
    return selectButton;



}

function ratings_button(jobmodel, model)
{
    var selectButton = "";
    if (jobmodel.toJSON().applied_user_id.length > 0) {

        for (var i = 0; i <= jobmodel.toJSON().applied_user_id.length; i++)
        {
            if (model.toJSON().user_to_job_rating_dislike > 0)
            {
                var rate_message = "Terrible";
                var class_name = 'btn btn-small btn-block  btn-danger terrible';

            }
            else if (model.toJSON().user_to_job_rating_like > 0)
            {
                var rate_message = "Well Done";
                var class_name = "btn btn-small btn-block  btn-success well-done";
            }

            if (jobmodel.toJSON().todays_date_time > jobmodel.toJSON().job_end_date_time_check && jobmodel.toJSON().applied_user_id[i] === model.toJSON().user_id && jobmodel.toJSON().user_to_job_status[i] === 'hired' && (model.toJSON().user_to_job_rating_like > '0' || model.toJSON().user_to_job_rating_dislike > '0'))
            {
                selectButton = "<a id='vote-upuserid' class='" + class_name + "' href='#like' is_rated='0' employer-vote='1'  action='vote-up' >" + rate_message + "</a>"

            }
        }
    }
    return selectButton;
}


function job_minyawns_grid(job)
{
    var miny_grid = "";
    console.log(job.toJSON().users_applied.length);
    for (var i = 0; i < job.toJSON().users_applied.length; i++) {
        if (job.toJSON().is_verfied[i] == 'Y')
            var is_verified = "<span>Minyawn verified </span>";
        else
            var is_verified = "";
        if (job.toJSON().user_to_job_status.indexOf('hired') >= 0)
        {

            if (job.toJSON().user_to_job_status[i] === 'hired') {

                /* miny_grid += "<a href=" + siteurl + "/profile/" + job.toJSON().applied_user_id[i] + " target='_blank'><div class='span4'>";
                 miny_grid += "<div class='minyawns-details'><span class='image-div'>" + job.toJSON().user_profile_image[i] + "</span><div style='float: left; width: 54%; '><b>" + job.toJSON().users_applied[i] + "</b><br>"+is_verified+"</div></a>";
                 miny_grid += "<a id='vote-up' href='#fakelink' employer-vote='1' job-id=" + job.toJSON().post_id + "><i class='icon-thumbs-up'></i>" + job.toJSON().user_rating_like[i] + "</a>";
                 miny_grid += "<a id='vote-down' href='#fakelink'  class='icon-thumbs' employer-vote='-1' job-id=" + job.toJSON().post_id + "><i class='icon-thumbs-down'></i>" + job.toJSON().user_rating_dislike[i] + "</a>";
                 miny_grid += "</div><div class='minyawns-job'><b>" + job.toJSON().user_to_job_status[i] + "</b><span >" + job.toJSON().user_to_job_rating[i] + "</span></div></div>";*/



                miny_grid += "<div class='span4'>";
                miny_grid += "<div class='minyawns-details'><span class='image-div'>" + job.toJSON().user_profile_image[i] + "</span><div ><b>" + job.toJSON().users_applied[i] + "</b>" + is_verified + "</div>";
                miny_grid += "<a id='vote-up' href='#fakelink' employer-vote='1' job-id=" + job.toJSON().post_id + "><i class='icon-thumbs-up'></i>" + job.toJSON().user_rating_like[i] + "</a>";
                miny_grid += "<a id='vote-down' href='#fakelink'  class='icon-thumbs' employer-vote='-1' job-id=" + job.toJSON().post_id + "><i class='icon-thumbs-down'></i>" + job.toJSON().user_rating_dislike[i] + "</a>";
                miny_grid += "</div><div class='minyawns-job'><b>" + job.toJSON().user_to_job_status[i] + "</b><span >" + job.toJSON().user_to_job_rating[i] + "</span></div></div>";
            } else
            {

            }

        } else
        {
            //  alert("print_applied");
            miny_grid += "<div class='span4'><a href=" + siteurl + "/profile/" + job.toJSON().applied_user_id[i] + " target='_blank'>";
            miny_grid += "<div class='minyawns-details'><span class='image-div'>" + job.toJSON().user_profile_image[i] + "</span><div ><b>" + job.toJSON().users_applied[i] + "</b>" + is_verified + "</a></div>";
            miny_grid += "<a id='vote-up' href='#fakelink' employer-vote='1' job-id=" + job.toJSON().post_id + "><i class='icon-thumbs-up'></i>" + job.toJSON().user_rating_like[i] + "</a>";
            miny_grid += "<a id='vote-down' href='#fakelink'  class='icon-thumbs' employer-vote='-1' job-id=" + job.toJSON().post_id + "><i class='icon-thumbs-down'></i>" + job.toJSON().user_rating_dislike[i] + "</a>";
            miny_grid += "</div><div class='minyawns-job'><b>" + job.toJSON().user_to_job_status[i] + "</b><span >" + job.toJSON().user_to_job_rating[i] + "</span></div></div>";
        }

    }

    return miny_grid;

}
function filter_categories(id, cat_name)
{

    var cat_id = (jQuery("#category_id").val()) > 0 ? jQuery("#category_id").val() + ',' + id : id;
    jQuery("input[name='categoryids[]']").val(cat_id);
//
    // load_browse_jobs('','',cat_id)
    window.location = siteurl + '/jobs/?cat_id=' + id + '&cat_name=' + cat_name.replace(' ', '-');


}


function remove_cat()
{
    window.location = siteurl + '/jobs/';

}




function load_comments(user_id)
{
    $("#example_right").unbind('click').popover({
        content: "asdasda",
        title: 'Dynamic response!',
        html: true,
        delay: {show: 500, hide: 100}
    }).popover('show');


    //$(".commentsclick").popover({placement:'right',content:'asdasd'});
    var Fetchusercomments = Backbone.Collection.extend({
        model: Usercomments,
        url: SITEURL + '/wp-content/themes/minyawns/libs/job.php/getcomments'
    });

    window.fetchc = new Fetchusercomments;
    window.fetchc.fetch({
        data: {
            minion_id: user_id,
            //job_id: jQuery("#job_id").val()
        },
        success: function(collection, response) {

            console.log(collection.models);
//            if (collection.length > 0) {
//                var template = _.template(jQuery("#minion-cards").html());
//                _.each(collection.models, function(model) {
//
//
            //                    var html = template({result: model.toJSON(), select_button: select_button});
// jQuery(".thumbnails").animate({left: '100px'}, "slow").prepend(html);
//                });
////
//
//            }

        }

    });
}


/*
 *  LOADS PRE-LOADED TEMPLATES FOR NEW JOB
 *
 *  ONCLICK OF THE LI
 *
 */
$("li").live('click', function() {

    var id = $(this).attr('id');
    $('#job_tags_tagsinput').find('span').remove();

    var map = {};
    $("#" + id + " input").each(function() {
        map[$(this).attr("name")] = $(this).val(); // creates an array for hidden names with values pairs

        $("#" + $(this).attr("name")).val($(this).val()); // *here the hidden field names are same as form input ids* assign based on name.

        /*
         *  FOR CATEGORIES
         *
         */
        if ($(this).attr("name") === 'categories') {
            var categories = $(this).val();

            var indv_categories = categories.split(','); //category ids saved as , seperated in hidden type. they are split and looped through


            for (var i = 0; i < indv_categories.length; i++)
            {
                $("#category-" + indv_categories[i]).removeAttr('checked'); //clears checkboxes before loading new values
                $("#category-" + indv_categories[i]).attr('checked', 'checked');

            }

        }
        /*
         *  END CATEFORIES
         *
         */

        var tags;
        if ($(this).attr("name") == 'job_tags') {
            tags = $(this).val();
            var tags_jquery = tags.split(',');
            for (var i = 0; i < tags_jquery.length; i++)
            {
                $("#job_tags_tagsinput").prepend('<span class="tag"><span>' + tags_jquery[i] + '&nbsp;&nbsp;</span><a class="tagsinput-remove-link"></a></span>');
            }
            $("#user_skills").val(tags);
        }


    });

});


/*
 *  TO DELETE TAGS ON ADDING
 *
 *  FROM A TEMPLATE
 */
$(".tag a").live('click', function() {

    $(this).parent().remove();
});