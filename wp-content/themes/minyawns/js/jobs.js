function load_browse_jobs() {

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
//jQuery(".load_more").hide();
            console.log(collection.length);
            if (collection.length === 0) {
                var template = _.template(jQuery("#no-result").html());
                jQuery("#accordion2").append(template);
                jQuery("#load-more").hide();
            } else {

//var job_stat="<input type='button'>But</input>";
// alert(job_stat);
                var template = _.template(jQuery("#jobs-table").html());
                _.each(collection.models, function(model) {
                    var job_stat = job_status_li(model);
                    var job_collapse_button_var = job_collapse_button(model);

                    if (model.toJSON().load_more === 1)
                        jQuery("#load-more").hide();
//alert(job_stat);

                    var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var});
                    // var html = this.tab_template({data : collection.toJSON(),buttonhtml:_this.add_client_button_html,breadcrumb: _this.bread_crumb ,fact_find:check_capability("ph_fact_find")});

                    jQuery("#accordion2").append(html);
                });
                jQuery(".load_ajax").hide();
            }



        },
        error: function(err) {
//console.log(err);
        }

    });
}



function fetch_my_jobs()
{
// jQuery("#accordion2").empty();
//  jQuery("#list-my-jobs").empty();

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
                if (jQuery("#browse-jobs-table").length > 0 && jQuery("#jobs-table").length == 0) {

                    jQuery("#browse-jobs-table").append(template);
                } else {
                    jQuery("#list-my-jobs").html(template);
                }
//jQuery("#list-my-jobs").hide();
                jQuery("#load-more").hide();
            } else {

                
                jQuery("#accordion24").empty();
                var template = _.template(jQuery("#jobs-table").html());
                _.each(collection.models, function(model) {
                    var job_stat = job_status_li(model);
                    var job_collapse_button_var = job_collapse_button(model);
                    if (model.toJSON().load_more === 1)
                        jQuery("#load-more").hide();
                    var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var});
                    jQuery("#accordion24").append(html);
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

    if (role === 'Minion') {
        // alert(model.toJSON().user_to_job_status.length);

        if (logged_in_user_id) {

            if (model.toJSON().user_to_job_status.length > 0) {

                for (var i = 0; i < model.toJSON().user_to_job_status.length; i++)
                {

                    /*
                     *  Logged in M
                     */

                    if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired') /* if logged in minion in hired*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You are hired for this job.</span>";
                    else if (model.toJSON().applied_user_id[i] !== logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired')/* if logged in is not hired but othes are*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Have been selected.</span>";
                    else if (model.toJSON().applied_user_id[i] !== logged_in_user_id && model.toJSON().job_status === '2') /* if logged in user is not selectd but req are filled*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications Closed.</span>";
                    else if ((model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'applied')) /*logged in user has applied for the job*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You have applied for this job.</span>";
                    else if ((model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'applied' && model.toJSON().job_status === '2'))
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You have applied for this job.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status.indexOf('hired') >= 0)
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Selected.</span>";
                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().job_status === '2')
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
                    else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /*expired*/
                        job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
                }
            }
            else
            {
                if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* hired and expired  */
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
                else
                    job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Available.</span>";
            }
        } else
        {



            /*
             *
             *  not logged in
             */


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
            else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') === -1) /*applied but not hired*/
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Applied.</span>";
            else if (model.toJSON().job_status === '2') /* max applications job locked  */
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
            else if (model.toJSON().job_status !== '2' && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* not locked but hired  */
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Selected.</span>";
            else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired and expired  */
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Rate Your MInions.</span>";
            else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check && model.toJSON().user_to_job_status.indexOf('hired') === -1) /*not hired and expired*/
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
            else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* job Exipred */
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
        }
        else
        {

            if (model.toJSON().users_applied.length === 0)
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please log-in as minion to apply</span>";
            else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') === -1) /* applied and but not hired */
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please log-in as minion to apply</span>";
            else if (model.toJSON().job_status === 3) /* job locked */
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
            else if (model.toJSON().job_status === 2 && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired */
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
            else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* job Exipred */
                job_status1 = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
        }



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



            if (model.toJSON().user_to_job_status.length > 0) { /* if user applied*/
//alert(logged_in_user_id);
                for (var i = 0; i < model.toJSON().applied_user_id.length; i++)
                {
//                    alert(model.toJSON().applied_user_id[i]);
                    //alert(model.toJSON().job_status);
                    if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().job_status !== 3 && model.toJSON().job_status === 1)
                        status_button = "<a href = '#' id = 'unapply-job' class ='btn btn-medium btn-block btn-danger red-btn' data-action ='unapply' data-job-id= '<%= result.post_id %>' > Unapply </a>";

                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'hired')
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You are Hired.</span>";

                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().user_to_job_status[i] === 'applied')
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Minions Selected.</span>";
                    else if (model.toJSON().applied_user_id.indexOf(logged_in_user_id) === -1 && model.toJSON().job_status === 3)
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications Closed.</span>";

                    else if (model.toJSON().applied_user_id.indexOf(logged_in_user_id) === -1 && model.toJSON().job_status === 2 && model.toJSON().user_to_job_status[i] !== 'hired')
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Selection Complete.</span>";

                    else if (model.toJSON().applied_user_id[i] === logged_in_user_id && model.toJSON().todays_date_time > model.toJSON().job_end_time_check && (model.toJSON().user_rating_like.length > 0 || model.toJSON().user_rating_dislike.length > 0))
                        status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>You have been rated" + model.toJSON().user_rating_like[i] + model.toJSON().user_rating_dislike[i] + "</span>";

                    else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check)
                        status_button = '<span style="display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;">Job Expired.</span>';


                }
            } else
            {

                if (model.toJSON().job_status === 1 && model.toJSON().todays_date_time < model.toJSON().job_end_time_check)
                    status_button = '<a href="#" id="apply-job-browse" class="btn btn-medium btn-block green-btn btn-success" data-action="apply" data-job-id="' + model.toJSON().post_id + '">Apply</a>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check)
                    status_button = '<span style="display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;">Job Expired.</span>';


            }


        } else
        {

            if (model.toJSON().job_owner_id === logged_in_user_id)
            {
                if (model.toJSON().users_applied.length === 0)
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';
                if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') === -1) /*applied but not hired*/
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';
                else if (model.toJSON().job_status === 3) /* max applications job locked  */
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Select Your Minions</a>';
                else if (model.toJSON().job_status === 2) /* not locked but hired  */
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Rate Your Minions</a>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired and expired  */
                    status_button = '<a href="' + siteurl + '/jobs/' + model.toJSON().post_slug + '" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="' + model.toJSON().post_id + '">Rate Your Minions</a>';
                else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check && model.toJSON().user_to_job_status.indexOf('hired') === -1) /*not hired and expired*/
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";
            } else
            {
                if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') === -1) /* applied and but not hired */
                    status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please log-in as minion to apply</span>";
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
        if (model.toJSON().users_applied.length === 0)
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please log-in as minion to apply</span>";
        else if (model.toJSON().users_applied.length > 0 && model.toJSON().user_to_job_status.indexOf('hired') === -1) /* applied and but not hired */
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Please log-in as minion to apply</span>";
        else if (model.toJSON().job_status === '2') /* job locked */
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
        else if (model.toJSON().job_status !== '2' && model.toJSON().user_to_job_status.indexOf('hired') >= 0) /* hired */
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Applications closed.</span>";
        else if (model.toJSON().todays_date_time > model.toJSON().job_end_time_check) /* job Exipred */
            status_button = "<span style='display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;'>Job Expired.</span>";

    }
    return status_button;
}


