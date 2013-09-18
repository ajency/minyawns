function load_browse_jobs(id) {

    jQuery(".load_ajax").css('display', 'block');
    jQuery("#calendar-jobs").hide(); /*bread crumbs*/
    jQuery("#calendar").hide();
    jQuery("#accordion2").empty();
    jQuery(".load_more").show();
    jQuery(".load-ajax-browse").hide();
    var Fetchjobs = Backbone.Collection.extend({
        model: Job,
        url: function() {

            return SITEURL + '/wp-content/themes/minyawns/libs/job.php/fetchjobs'
        }
    });
    window.fetchj = new Fetchjobs;
    window.fetchj.fetch({
        data: {
            'offset': 0

        },
        reset: true,
        success: function(collection, response) {

            if (collection.length === 0) {
                var template = _.template(jQuery("#no-result").html());
                jQuery("#accordion2").append(template);
                jQuery("#load-more").hide();
            } else {

                var template = _.template(jQuery("#jobs-table").html());
                _.each(collection.models, function(model) {
                    var job_stat = job_status_li(model);
                    var job_collapse_button_var = job_collapse_button(model);

                    if (model.toJSON().post_id === id) { /*for single job page*/
                        jQuery("#hidden_minion_id").val(model.toJSON().applied_user_id);
                        jQuery("#job_id").val(id);
                        var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var});
                        jQuery(".singlejobedit").append(html);
                        jQuery(".details").find(".minyawansgrid").hide();
                         jQuery("#select-minyawn").removeAttr('href');
                        jQuery("#select-minyawn").live("click",function(){
                            jQuery("html, body").animate({ scrollTop: jQuery(document).height() }, 1000);
                        });
                        load_job_minions(model);


                    } else {
                        if (model.toJSON().load_more === 1)
                            jQuery("#load-more").hide();
                        var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var});
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
    jQuery("#accordion2").empty();
//  jQuery("#list-my-jobs").empty();
    //jQuery(".browse-jobs-table").empty();
    var Fetchjobs = Backbone.Collection.extend({
        model: Job,
        url: SITEURL + '/wp-content/themes/minyawns/libs/job.php/fetchjobs'
    });
    window.fetchj = new Fetchjobs;
    window.fetchj.fetch({
        data: {
            'my_jobs': 1,
            'offset': 0

        },
        success: function(collection, response) {
            jQuery(".load_ajax1_myjobs").hide();
            if (collection.length === 0) {
                var template = _.template(jQuery("#no-result").html());
                jQuery("#load-more").hide();
            } else {
                jQuery("#accordion24").empty();
                var template = _.template(jQuery("#jobs-table").html());
                _.each(collection.models, function(model) {
                   // alert(model.toJSON().applied_user_id.indexOf(id));
                    if (model.toJSON().job_owner_id === id || model.toJSON().applied_user_id.indexOf(id) >= 0)/* to show my jobs*/
                    {
                        var job_stat = job_status_li(model);
                        var job_collapse_button_var = job_collapse_button(model);

                        if (model.toJSON().load_more === 1)
                            jQuery("#load-more").hide();

                        var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var});
                        jQuery("#accordion24").append(html);
                    } else
                    {
                           jQuery(".load_more").hide();
                       // var template = _.template(jQuery("#no-result").html());
                      
                      //  jQuery("#accordion24").html(jQuery("#no-result").html());
                     
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
function job_status_li(model)
{
    var job_status1;
    if (logged_in_user_id) {
        if (role === 'Minion') {
            // alert(model.toJSON().user_to_job_status.length);

            if (model.toJSON().applied_user_id.indexOf(logged_in_user_id) >= 0) {
                console.log(model.toJSON().applied_user_id);
                for (var i = 0; i < model.toJSON().user_to_job_status.length; i++)
                {
                    if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired' && model.toJSON().todays_date_time < model.toJSON().job_end_time_check) /* if logged in minion in hired*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You have been selected for this job.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'applied')/*logged in user has applied for the job*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You have applied for this job.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'applied' && model.toJSON().job_status === 2) /*logged in user has applied for the job*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You have applied for this job.</span>";
                    else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /*expired*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired' && model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* if logged in minion in hired*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Ratings .</span>";
                    if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status.indexOf('hired') >= 0 && model.toJSON().user_to_job_status[i] === 'applied') /* if logged in minion in hired*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Selected.</span>";
                    else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /*expired*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";


                }
//return job_status1;
            }
            else
            {
                //      alert("blank_users");
                if (model.toJSON().user_to_job_status.indexOf('hired') >= 0)/* if logged in is not hired but othes are*/
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions have been selected.</span>";

                else if (model.toJSON().job_status === 3 && model.toJSON().user_to_job_status.indexOf('hired') === -1)/* if logged in is not hired but othes are*/
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications Closed.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /*expired*/
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";

                else
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Available.</span>";
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

                if (model.toJSON().users_applied.length === 0 && model.toJSON().todays_date_time < model.toJSON().job_end_time_check)
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>No Applicants yet.</span>";
                else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().job_status !== 3) /*applied but not hired*/
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Applied.</span>";
                else if (model.toJSON().job_status === 3 && model.toJSON().user_to_job_status.indexOf('hired') === -1) /* max applications job locked  */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
                else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* not locked but hired  */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Selected.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired and expired  */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Rate Your MInions.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* job Exipred */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
                //return job_status1;
            }
            else
            {

                if (model.toJSON().users_applied.length === 0 && model.toJSON().todays_date_time < model.toJSON().job_end_time_check)
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Available</span>";
                 else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* applied and but not hired */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please login as Minion to apply</span>";
              
                else if (model.toJSON().job_status === 3) /* applied and but not hired */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications Closed</span>";
                else if (model.toJSON().user_to_job_status.indexOf('applied') >= 0) /* hired */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Available.</span>";

                else if (model.toJSON().job_status === 2 && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please login as a Minion to apply.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* job Exipred */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";

            }



        }
    }
    else
    {

        if (model.toJSON().users_applied.length === 0 && model.toJSON().todays_date_time < model.toJSON().job_end_time_check)
            job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Available</span>";
        else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* applied and but not hired */
            job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions have been selected </span>";
        else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('applied') >= 0 && model.toJSON().job_status === 1) /* applied and but not hired */
            job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions have Applied </span>";
        else if (model.toJSON().job_status === 3) /* job locked */
            job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
        else if (model.toJSON().job_status === 2 && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired */
            job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
        else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* job Exipred */
            job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
    }
    //});
    return job_status1;
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
//                    alert(model.toJSON().applied_user_id[i]);
                    //alert(model.toJSON().user_to_job_status.indexOf('hired'));
                    // if (model.toJSON().applied_user_id[i] === logged_in_user_id  && model.toJSON().user_to_job_status.indexOf('hired') >=  0)
                    //   status_button = "";
                    if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status.indexOf('hired') === -1)
                        status_button = "<a href = '#' id = 'unapply-job' class ='btn btn-medium btn-block btn-danger red-btn' data-action ='unapply' data-job-id= " + model.toJSON().post_id + "  > Unapply </a>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired')
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You are Hired.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status.indexOf('hired') >= 0)
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Have been selected.</span>";
                    //else if (model.toJSON().applied_user_id[i] !== logged_in_user_id && model.toJSON().user_to_job_status.indexOf('applied') >= 0)
                    //    status_button = '<a href="#" id="apply-job-browse" class="btn btn-medium btn-block green-btn btn-success" data-action="apply" data-job-id="' + model.toJSON().post_id + '">Apply</a>';
                    else if (model.toJSON().applied_user_id.indexOf(logged_in_user_id) === -1 && model.toJSON().job_status === 2 && model.toJSON().user_to_job_status[i] !== 'hired')
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Selection Complete.</span>";

                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().todays_date_time > model.toJSON().job_end_time_check && (model.toJSON().user_rating_like.length > 0 || model.toJSON().user_rating_dislike.length > 0))
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You have been rated" + model.toJSON().user_rating_like[i] + model.toJSON().user_rating_dislike[i] + "</span>";

                    else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check)
                        status_button = '<span style="display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;">Job Expired.</span>';



                }
            } else
            {
                if (model.toJSON().job_status === 3 && model.toJSON().user_to_job_status.indexOf('hired') === -1)
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications Closed.</span>";
                else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0)
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Selection Complete.</span>";
                else if (model.toJSON().job_status === 1 && model.toJSON().todays_date_time < model.toJSON().job_end_time_check)
                    status_button = '<a href="#" id="apply-job-browse" class="btn btn-medium btn-block green-btn btn-success" data-action="apply" data-job-id="' + model.toJSON().post_id + '">Apply</a>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check)
                    status_button = '<span style="display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;">Job Expired.</span>';


            }


        } else
        {

            if (model.toJSON().job_owner_id === logged_in_user_id)
            {

                if (model.toJSON().user_to_job_status.indexOf('hired') === -1 && model.toJSON().todays_date_time < model.toJSON().job_end_time_check) /*applied but not hired*/
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';
                else if (model.toJSON().job_status === 3 && model.toJSON().user_to_job_status.indexOf('hired') === -1) /* max applications job locked  */
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';
                else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* not locked but hired  */
                    status_button = '<span style="display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;">Minions Hired.</span>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired and expired  */
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Rate Your Minions</a>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check && model.toJSON().user_to_job_status.indexOf('hired') === -1) /*not hired and expired*/
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
            } else
            {
                if (model.toJSON().user_to_job_status.indexOf('hired') === -1) /* applied and but not hired */
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please log-in as minion to apply</span>";
                else if (model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* applied and but not hired */
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Selection Complete</span>";

                else if (model.toJSON().job_status === 3) /* job locked */
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
                else if (model.toJSON().job_status === 2) /* hired */
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* job Exipred */
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";

            }
            //status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';

//alert(status_button);
        }



    } else
    {
        if ((model.toJSON().users_applied.length === 0 || model.toJSON().users_applied.length >= 0) && model.toJSON().todays_date_time < model.toJSON().job_end_time_check && model.toJSON().job_status !== 3)
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Available</span>";
          else if (model.toJSON().job_status === 3) /* job locked */
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
        else if (model.toJSON().job_status === 2 && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired */
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Selection Complete.</span>";
        
        else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* job Exipred */
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";

    }
    return status_button;
}

function load_job_minions(jobmodel)
{
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

                    var select_button = is_minion_selected(jobmodel, model);
                    var html = template({result: model.toJSON(), select_button: select_button});
                    jQuery(".thumbnails").append(html);
                });

                if (is_job_owner(jobmodel.toJSON().job_owner_id) && jobmodel.toJSON().user_to_job_status.indexOf('hired') === -1) {
                    var template = _.template(jQuery("#confirm-hire").html());
                    //var html=template({user_id:collection.models.toJSON().user_id,job_id:jobmodel.toJSON.post_id});
                    jQuery(".list-jobs").append(template);
                }

            } else
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


function is_job_owner(job_owner_id)
{
    var is_owner = (job_owner_id === logged_in_user_id) ? true : false;

    return is_owner;

}


function is_minion_selected(jobmodel, model)
{
    var selectButton;
    if (jobmodel.toJSON().applied_user_id.length > 0) {

        for (var i = 0; i < jobmodel.toJSON().applied_user_id.length; i++)
        {

            if (jobmodel.toJSON().applied_user_id[i] === model.toJSON().user_id && jobmodel.toJSON().user_to_job_status[i] === 'applied' && jobmodel.toJSON().job_owner_id === logged_in_user_id)
                selectButton = '<div class="roundedTwo" id="select-button-' + model.toJSON().user_id + '"><input type="checkbox" id="select-' + model.toJSON().user_id + '" name="confirm-miny[]" value="' + model.toJSON().user_id + '"  data-user-id="' + model.toJSON().user_id + '" data-job-id="' + jobmodel.toJSON().post_id + '"><label for="rounded1' + model.toJSON().user_id + '" > </label>Select Your Minions</div>';
            else if (jobmodel.toJSON().applied_user_id[i] === model.toJSON().user_id && jobmodel.toJSON().user_to_job_status[i] === 'hired' && jobmodel.toJSON().job_owner_id === logged_in_user_id)
                selectButton = '<div class="roundedTwo" id="select-button' + model.toJSON().user_id + '"><label for="rounded1' + model.toJSON().user_id + '"></label>Minion Selected</div>';
            else if (jobmodel.toJSON().todays_date_time > jobmodel.toJSON().job_end_time_check && jobmodel.toJSON().user_to_job_status[i] === 'hired' && jobmodel.toJSON().job_owner_id === logged_in_user_id) {
                selectButton = "<div class='dwn-btn'><div class='row-fluid'><div class='span6'><a id='vote-upuserid' class='btn btn-small btn-block  btn-success well-done' href='#like' is_rated='0' employer-vote='1'   job-id='jobid' user_id='" + model.toJSON().user_id + "' action='vote-up' emp_id='" + jobmodel.toJSON().job_owner_id + "'>1 Well Done</a>"
                selectButton += "</div><div class='span6'><a id='vote-up'" + model.toJSON().user_id + "' class='btn btn-small btn-block  btn-success well-done' href='#like' is_rated='0' employer-vote='1'   job-id='jobid' user_id='" + model.toJSON().user_id + "' action='vote-up' emp_id='" + jobmodel.toJSON().job_owner_id + "'>";
                selectButton += "1 Terrible Job</a></div></div></div>";
            }
        }





    }
    return selectButton;



}


jQuery("15").click("live", function() {

    alert("here");

});