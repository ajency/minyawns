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

        if ($(this).hasClass('view'))
        {
            $(span1).animate({left: 0}, 500);
            $(span2).show().animate({left: w}, 500);
            $('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a>');
        }
        else
        {
            $('#profile-edit').find('div.alert').remove();
            $(span1).animate({left: -1 * w}, 500);
            $(span2).css({'left': w, 'top': 0});
            $(span2).show().animate({left: 0}, 500);
            $('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a> Edit');
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
        }

    });


    $('#add-job').click(function(e) {

        e.preventDefault();
        var _this = $(this);
        $(this).attr('disabled', 'disabled');

        //remove previuous errors
        $('#job-form').find('span.form-error').remove();

        //attach it to global window so we can use it later to update the main profile view
        window.job = new Job();
        window.job.bind('invalid', function(model, error, options) {

            _.each(error, function(ele, index) {
                $('#' + ele.field).parent().append('<span class="form-error">' + ele.msg + '</span>');
            })
        });
        var data = $("#job-form").serializeArray();

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
    
   
    
   /*############POP UP############*/ 
    /*Function to etrieve password */ 	
	 jQuery("#user-submit").live("click",function(){
		 jQuery('#frm_forgotpassword').submit();
	 })
	
	
	/*forgot password form validation */
	jQuery('#frm_forgotpassword').validate({		
		
		rules : {
			'user_login' : {  
				required  : true 
				 
			} 

		},
		submitHandler : function(form){ 
			
						jQuery("#div_msgforgotpass").html("<img src='"+jQuery("#hdn_siteurl").val()+"/wp-content/themes/minyawns/images/ajax-loader.gif' width='50' height='50'/>");
						jQuery.post(ajaxurl,{
							action : 'retrieve_password_ajx',							
							user_login :jQuery("#user_login").val(),							 
						},
						function(response){  
							console.log(response);
							 if(response.success==true)
							{
								 jQuery("#user_login").val("");
								 jQuery("#div_forgotpass").hide();
								 jQuery("#div_msgforgotpass").html(response.msg);
								
							} 
							else
							{
								jQuery("#div_msgforgotpass").html(response.msg);
							} 
						})
			
						return false; 
		}
		
	});	
	/* end reset pasword validation */
	
	 
	/* forgotpass link */
	jQuery("#btn_forgotpass").live("click",function(){
		jQuery("#div_forgotpass").toggle();		
		jQuery("#div_msgforgotpass").html("");
	})
	 

	/* reset password form validation */
	jQuery('#resetpassform').validate({				
		rules : {
			'pass1' : {  
				required  : true, 
				minlength : 6	
			},			 
			'pass2' : {  
				required  : true, 
				minlength : 6,
				equalTo: "#pass1" 
			} 
		},
		messages:{
			'pass1' : {  
				required  : 'Please enter new password' 				 
			},
			 
			'pass2' : {  
				required  : 'Please renter new password',
				equalTo: "The password fields entered do not match" 
			} 			
		}		 
	
	});	
	/* end reset pasword validation */	
	
	 
	 
	/* POPUP LOGIN */ 	 
   
   //hide forget password section on login pop up link click
   jQuery("#btn__login").live("click",function(){    	 
   	jQuery("#div_forgotpass").hide();
   	jQuery("#div_msgforgotpass").html("");
   	jQuery("#user_login").val("");
   	jQuery("#div_loginmsg").html("");
   	jQuery("#wp-fb-ac-fm").append('<input type="hidden" name ="fb_chk_usersigninform" id="fb_chk_usersigninform" value="loginfrm" /> ');////jQuery("#usr_role").val('employer');
   })
   
   //user login form validation and user login
	jQuery("#btn_login").live("click",function(){
		jQuery('#frm_login').submit();		
	})
	
	
	
	
	jQuery('#frm_login').validate({				
		rules : {

			'txt_pass' : {  
				required  : true, 
				minlength : 3	
			},			 
			'txt_email' : {  
				required  : true, 
				minlength : 6,
				email: true
			} 

		},
		submitHandler : function(form){ 
			jQuery("#div_loginmsg").html("<img src='"+jQuery("#hdn_siteurl").val()+"/wp-content/themes/minyawns/images/ajax-loader.gif' width='50' height='50'/>");
			jQuery.post(ajaxurl,{
				action : 'popup_userlogin',				
				pdemail :jQuery("#txt_email").val(),
				pdpass :jQuery("#txt_pass").val(),
			},
			function(response){  
				console.log(response);
				if(response.success==true)
				{								
					window.location.href = jQuery("#hdn_siteurl").val()+'/profile/';
				} 
				else
				{
					jQuery("#div_loginmsg").html(response.msg);
				}	
			})	
			
		return false; 
		}		
	
	});	
	/*END POPUP LOGIN */
	
	
	/*sign in here link*/
	jQuery("#lnk_signin").live("click",function(){		
		jQuery("#signup_popup_close").click();
		jQuery("#btn__login").click();
	})
	
	
	/* POPUP SIGNUP */
	jQuery("#link_minyawnregister").live("click",function(){	
		jQuery("#signup_role").val('minyawn');		
		
		if(jQuery("#usr_role").length>0)
		{
			jQuery("#usr_role").val("minyawn");
		}
		else
		{		
			jQuery("#wp-fb-ac-fm").append('<input type="hidden" name ="usr_role" id="usr_role" value="minyawn" /> ');//jQuery("#usr_role").val('minyawn');
		}
		
		if(jQuery("#fb_chk_usersigninform").length>0)
		{
			jQuery("#fb_chk_usersigninform").remove();
		}
		
		jQuery("#div_signupmsg").html("");		 
		validator_signup.resetForm();
		jQuery("#signup_email").val("");
		jQuery("#signup_password").val("");
		jQuery("#signup_fname").val("");
		jQuery("#signup_lname").val("");		
	
	})
	
	jQuery("#link_employerregister").live("click",function(){	
		jQuery("#signup_role").val('employer');
		if(jQuery("#usr_role").length>0)
		{
			jQuery("#usr_role").val("employer");
		}
		else
		{	
			jQuery("#wp-fb-ac-fm").append('<input type="hidden" name ="usr_role" id="usr_role" value="employer" /> ');////jQuery("#usr_role").val('employer');
		}
		if(jQuery("#fb_chk_usersigninform").length>0)
		{
			jQuery("#fb_chk_usersigninform").remove();
		}
		
		jQuery("#div_signupmsg").html(""); 		 
		validator_signup.resetForm();
		jQuery("#signup_email").val("");
		jQuery("#signup_password").val("");
		jQuery("#signup_fname").val("");
		jQuery("#signup_lname").val("");		
		
	})	
	
	jQuery("#btn_signup").live("click",function(){	 				
		jQuery('#frm_signup').submit();		
	})	
	
	var validator_signup = jQuery('#frm_signup').validate({				
		rules : {

			'signup_password' : {  
				required  : true, 
				minlength : 3	
			},
			 
			'signup_email' : {  
				required  : true, 
				minlength : 6,
				email: true
			},
			'signup_fname' : {  
				required  : true, 
				minlength : 2	
			},
			'signup_lname' : {  
				required  : true, 
				minlength : 2	
			}

		},
		submitHandler : function(form){	
			
			jQuery("#div_signupmsg").html("<img src='"+jQuery("#hdn_siteurl").val()+"/wp-content/themes/minyawns/images/ajax-loader.gif' width='50' height='50'/>");
			jQuery.post(ajaxurl,{
				action : 'popup_usersignup',
				//data :  data 
				pdemail_ :jQuery("#signup_email").val(),
				pdpass_ :jQuery("#signup_password").val(),
				pdfname_ :jQuery("#signup_fname").val(),
				pdlname_ :jQuery("#signup_lname").val(), 
				pdrole_ :jQuery("#signup_role").val()
			},
			function(response){  
				console.log(response);
				if(response.success==true)
				{
					jQuery("#div_signupmsg").html(response.msg);
					jQuery("#signup_email").val("");
					jQuery("#signup_password").val("");
					jQuery("#signup_fname").val("");
					jQuery("#signup_lname").val("");					
				} 
				 else					  
				{
					 jQuery("#div_signupmsg").html(response.msg);				
				} 	 
			})
		return false; 
		}		
	
	});
	
	/*END POPUP SIGNUP */    

});