function load_browse_jobs() {

        $(".load_ajax").css('display', 'block');
        $("#calendar-jobs").hide();/*bread crumbs*/
        $("#calendar").hide();
        $("#accordion2").empty();
        $(".load_more").show();
        $(".load-ajax-browse").hide();
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
                //$(".load_more").hide();
                if (collection.length === 0) {
                    var template = _.template($("#no-result").html());
                    $("#accordion2").append(template);
                    $("#load-more").hide();

                } else {
                    var template = _.template($("#browse-jobs-table").html());
                    _.each(collection.models, function(model) {

                        if (model.toJSON().load_more === 1)
                            $("#load-more").hide();


                        var html = template(model.toJSON());
                        $("#accordion2").append(html);
                    });
                    $(".load_ajax").hide();
                }



            },
            error: function(err) {
//console.log(err);
            }

        });

    }
    
    
    
      function fetch_my_jobs()
    {
        $("#accordion2").empty();
        $("#list-my-jobs").empty();

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
                $(".load_ajax1_myjobs").hide();

                if (collection.length === 0) {

                    var template = _.template($("#no-result").html());

                    if ($("#browse-jobs-table").length > 0 && $("#list-my-jobs").length == 0) {

                        $("#browse-jobs-table").append(template);
                    } else {
                        $("#list-my-jobs").html(template);
                    }
                    //$("#list-my-jobs").hide();
                    $("#load-more").hide();

                } else {
                    if (window.location.href.indexOf("jobs") > -1) {


                        var template = _.template($("#my-jobs").html());
                        _.each(collection.models, function(model) {

                            var html = template(model.toJSON());
                            $("#list-my-jobs").append(html);
                        });
                    }
                    else
                    {
                        $("#accordion22").empty();
                        var template = _.template($("#browse-jobs-table-profile").html());
                        _.each(collection.models, function(model) {

                            if (model.toJSON().load_more === 1)
                                $("#load-more").hide();


                            var html = template(model.toJSON());
                            $("#accordion22").append(html);
                        });
                        $(".load_ajax").hide();

                    }

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

