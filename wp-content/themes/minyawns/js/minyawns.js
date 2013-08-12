/**
 */

jQuery(document).ready(function($) {

    /********************************** PROFILE JS CODE *************************************/
    //reset height for first span
    $('#main-content .profile-wrapper').height($('#profile-edit').height() + 100);

    $(function() {
        $('.switch')['bootstrapSwitch']();
    });

    /** ANimate the profile view + edit views */
    $('.edit-user-profile').live('click', function(e) {

        e.preventDefault();
        var span1 = $('#profile-view');
        var span2 = $('#profile-edit');
        var w = $(span1).width();

        if(!$(this).hasClass('loaded'))
        {
            if($(this).hasClass('view'))
            {
                $(span1).animate({left: 0}, 500);
                $(span2).show().animate({left: w}, 500);
                $('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a>');
            }
            else
            {
                $(this).removeClass('loaded');
                $('#profile-edit').find('div.alert').remove();
                $(span1).animate({left: -1 * w}, 500);
                $(span2).css({'left': w, 'top': 0});
                $(span2).show().animate({left: 0}, 500);
                $('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a> Edit');
            }
        }
    });

    //set emulateHTTP to true to send PUT requests as POST
    //Backbone.emulateHTTP = true;
    //Backbone.emulateJSON = true;


    /**
     * A simple backbone model for profile
     */
    var Profile = Backbone.Model.extend({
        url: function() {
            return 'http://localhost/minyawns/wp-content/themes/minyawns/libs/user.php/user';
        },
        validate: function(attr) {

            var errors = [];

            _.each(attr, function(index, ele) {

                if (ele == 'id')
                    return;

                if (attr[ele] == '')
                {
                    errors.push({field: ele, msg: 'Please enter ' + ele});
                }

            });

            if (errors.length > 0)
                return errors;
        },
        validate_email: function(email) {

            return false;
        }

    });


    $('a#update-profile-info').click(function(e) {

        e.preventDefault();
        var _this = $(this);
        $(this).attr('disabled', 'disabled');

        //remove previuous errors
        $('#profile-edit-form').find('span.form-error').remove();

        //attach it to global window so we can use it later to update the main profile view
        window.profile = new Profile();
        window.profile.bind('invalid', function(model, error, options) {

            _.each(error, function(ele, index) {
                $('#' + ele.field).parent().append('<span class="form-error">' + ele.msg + '</span>');
            })
        });



        var data = $('#profile-edit-form').serializeArray();


        var profile_data = {};
        _.each(data, function(ele, index) {
            profile_data[ele.name] = ele.value;

            if (ele.name == 'user_skills')
                profile_data[ele.name] = ele.value.split(',');

        });

        window.profile.save(profile_data, {
            wait: true,
            success: function(model, resp) {

                //get model data
                $(_this).removeAttr('disabled');
                var data = model.toJSON();

                //remove success
                _.pluck(data, 'success');

                $('#profile-view').find('.name').html(data.first_name + ' ' + data.last_name + ' <a href="#" class="edit edit-user-profile"><i class="icon-edit"></i> Edit</a>');

                //minyawns role
                $('#profile-view').find('.college').text(data.college);
                $('#profile-view').find('.major').text(data.major);
                var skills = '';
                _.each(data.user_skills, function(ele, index) {
                    skills += "<span class='label label-small'>" + ele + "</span>";
                });
                $('#profile-view').find('.user_skills').html(skills);


                //employer role
                $('#profile-view').find('.location').text(data.location);
                $('#profile-view').find('.profilebody').text(data.profilebody);
                $('#profile-view').find('.company_website').html(' <a href="' + data.company_website + '">' + data.company_website + '</a>');

                //show success message
                $('#profile-edit').prepend('<div class="alert alert-success">Profile updated succesfully</div>');


            },
            errors: function() {
                $(_this).removeAttr('disabled');
                alert('Error!!! Please try again');
            }
        });
    });

    /********************************** PROFILE JS CODE *************************************/

    $("#add-job-button").live('click', function(e) {
        e.preventDefault();
        $("#add-job-form").toggle("slow");
        $("#add-job-button").hide();
        $("#cancel-job-button").show();
    });

    $("#cancel-job-button").live('click', function(e) {
        e.preventDefault();
        $("#add-job-form").toggle("slow");
        $("#add-job-form").hide();
        $("#add-job-button").show();
        $("#cancel-job-button").hide();
    });


    var Job = Backbone.Model.extend({
        url: function() {
            return 'http://localhost/minyawns/wp-content/themes/minyawns/libs/job.php/addjob';
        },
        validate: function(attr) {

            var errors = [];
alert(attr.tasks)
//            _.each(attr, function(index, ele) {                            
//                
//                                 alert(attr[index]);
////                if (attr[ele] == '')
////                {
////                    errors.push({field: ele, msg: 'Please enter ' + ele});
////                }
//
//            });

            if (errors.length > 0)
                return errors;
        }

    });


    $('#add-job').click(function(e) {

        e.preventDefault();
        var _this = $(this);
//       
//        //remove previuous errors
        $('#job-form').find('span.form-error').remove();
//
//        //attach it to global window so we can use it later to update the main profile view
        window.job = new Job();
        window.job.bind('invalid', function(model, error, options) {

            _.each(error, function(ele, index) {
                $('#' + ele.field).parent().append('<span class="form-error">' + ele.msg + '</span>');
            })
        });
        var data = $("#job-form").serializeArray(); 
        $(this).attr('disabled', 'disabled');
//
            var job_data = {};
        _.each(data, function(ele, index) {
             job_data[ele.name] = ele.value;

        });

        window.job.save(job_data, {
            wait: true,
            success: function(model, resp) {

                //get model data
                $(_this).removeAttr('disabled');
                $("#add-job-form").slideUp("slow");
                $("#add-job-form").hide();
                $("#add-job-button").show();
                $("#cancel-job-button").hide();

            },
            errors: function() {
                $(_this).removeAttr('disabled');
                alert('Error!!! Please try again');
            }
        });
    });


    $("#browse").click(function(e) {
        var Job = Backbone.Model.extend({
            url: function() {
                return 'http://localhost/minyawns/wp-content/themes/minyawns/libs/job.php/fetchjobs';
            }

        });
        window.job = new Job();
        window.job.save({
            wait: true,
            success: function(model, resp) {


            },
            errors: function() {

            }
        });
    });

});