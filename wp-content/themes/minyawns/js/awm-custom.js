/**
 * Custome JS goes here
 */

jQuery(document).ready(function($){
	
	alert("here");
         jQuery('#time-pick').timepicker();
        jQuery('#datepicker-01').datepicker();
	
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
							//data :  data 
							user_login :jQuery("#user_login").val(),
							 
						},
						function(response){  
							console.log(response);
							 if(response.success==true)
							{
								 jQuery("#user_login").val("");
								 jQuery("#div_forgotpass").hide();
								 jQuery("#div_msgforgotpass").html(response.msg);
								//window.location.href = jQuery("#hdn_siteurl").val()+'/profile/#profile';
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
	
	/* jQuery("#user-submit").live("click",function(){	
		 jQuery("#div_msgforgotpass").html("<img src='"+jQuery("#hdn_siteurl").val()+"/wp-content/themes/minyawns/images/ajax-loader.gif' width='50' height='50'/>");
			jQuery.post(ajaxurl,{
				action : 'retrieve_password_ajx',
				//data :  data 
				user_login :jQuery("#user_login").val(),
				 
			},
			function(response){  
				console.log(response);
				 if(response.success==true)
				{
					 jQuery("#user_login").val("");
					 jQuery("#div_forgotpass").hide();
					 jQuery("#div_msgforgotpass").html(response.msg);
					//window.location.href = jQuery("#hdn_siteurl").val()+'/profile/#profile';
				} 
				else
				{
					jQuery("#div_msgforgotpass").html(response.msg);
				} 
			})		
	 })*/
	
	jQuery("#btn_forgotpass").live("click",function(){
		jQuery("#div_forgotpass").toggle();
		//jQuery("#div_forgotpass").show();
		jQuery("#div_msgforgotpass").html("");
	})
	/*
	if(jQuery("#hdn_reset").val()!="norequest")
	{
		jQuery("#btn__login").click();
		if(jQuery("#hdn_reset").val()=="true")
			jQuery("#span_forgotpass").html("Password reset request is sent to your mail box");
		else
			jQuery("#span_forgotpass").html("Your email id is not present in our database.Try with a email id, you have used to register on Minyawns");
	}
	*/
	/*Function to etrieve password */  
	
	
	
	
	
	
	
	
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
	
	
	
	
	
	
	
	
	
    jQuery('#user-popdown').popover(
				{
					placement : 'bottom',
					html : true,
					content : '<div id="profile-data"><a href="" class="change-avatar"><div class="avatar user-1-avatar" width="150" height="150" /></a><div class="profile-data-display"><h4>'+userName+'</h4><p class="muted">@admin</p></div><div class="profile-actions"><span><a href="'+siteurl+'/profile/#profile" class="popup_link"><i class="icon-user"></i> View Profile</a>&nbsp;<a href="#" class="popup_link"><i class="icon-cog"></i> Settings</a>&nbsp;<a href="'+logouturl+'" id="logout-button" class="popup_link"><i class="icon-unlock"></i>Logout </a></span></div></div>',
				}
			);

//	 var ajaxurl =  global.ajaxurl; 	
	// alert(ajaxurl);
 
	 
	 
	 
	/* POPUP LOGIN */ 	 
    
    //hide forget password section
    jQuery("#btn__login").live("click",function(){    	 
    	jQuery("#div_forgotpass").hide();
    	jQuery("#div_msgforgotpass").html("");
    	jQuery("#user_login").val("");
    })
    
    //user login form validation and user login
	jQuery("#btn_login").live("click",function(){
           Query('#frm_login').submit();		

		//var data = jQuery("#frm_login").serializeArray();		

	
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
				//data :  data 
				pdemail :jQuery("#txt_email").val(),
				pdpass :jQuery("#txt_pass").val(),
			},
			function(response){  
				console.log(response);
				if(response.success==true)
				{
					//alert("login successfull..redirect page..");				
					window.location.href = jQuery("#hdn_siteurl").val()+'/profile/#profile';
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
		jQuery("#signup_role").val('minyawn');jQuery("#wp-fb-ac-fm").append('<input type="hidden" name ="usr_role" id="usr_role" value="minyawn" /> ');//jQuery("#usr_role").val('minyawn');
		jQuery("#div_signupmsg").html("");		 
		validator_signup.resetForm();
		jQuery("#signup_email").val("");
		jQuery("#signup_password").val("");
		jQuery("#signup_fname").val("");
		jQuery("#signup_lname").val("");
		 
		//logouturl=logouturl+"&amp;usr_role=minyawn"
	
	})
	
	jQuery("#link_employerregister").live("click",function(){	
		jQuery("#signup_role").val('employer');jQuery("#wp-fb-ac-fm").append('<input type="hidden" name ="usr_role" id="usr_role" value="employer" /> ');////jQuery("#usr_role").val('employer');
		jQuery("#div_signupmsg").html(""); 		 
		validator_signup.resetForm();
		jQuery("#signup_email").val("");
		jQuery("#signup_password").val("");
		jQuery("#signup_fname").val("");
		jQuery("#signup_lname").val("");
		//	logouturl=logouturl+"&amp;usr_role=employer";
		
	})
	
	
	jQuery("#btn_signup").live("click",function(){	 
		//alert(jQuery("#signup_email").val()+jQuery("#signup_password").val()+jQuery("#signup_fname").val()+jQuery("#signup_lname").val());		
		jQuery('#frm_signup').submit();		
		//var data = jQuery("#frm_login").serializeArray();
	
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
			//alert(jQuery("#signup_email").val()+" - "+jQuery("#signup_password").val()+" - "+jQuery("#signup_fname").val()+" - "+jQuery("#signup_lname").val()+ " - "+jQuery("#signup_role").val() )
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
					 //alert("Registration  success...");				
					//window.location.href = '/home/'+'?msg=succes';
				} 
				 else
					  
				{
					 jQuery("#div_signupmsg").html(response.msg);
					//alert("Registration  success...");				
					//window.location.href = '/home/'+'?msg=succes';
				} 	 
			})
		return false; 
		}		
	
	});
	
	
	
	/*END POPUP SIGNUP */
	
	
	
	if(jQuery('#mycarousel').length>0)
	 {
	
		jQuery('#mycarousel').jcarousel({
	    	wrap: 'circular'
	    });
	}
	
	
	$('.nav-toggle').click(function(e){
		  
		e.preventDefault();
		
		if(!$($(this).attr('href')).is(':visible'))
		{
		

		$('.nav-toggle').each(function(){
				if($($(this).attr('href')).is(':visible'))
				{
					$($(this).attr('href')).toggle();
						jQuery(this).parents('tr').css({'background':'',
											'border-left-width': '',
											'border-left-style': '',
											'border-left-color': '',
											'border': ''});
					jQuery(this).html('<div class="arrow-down"></div>');
				
					
				}
			});
		}
		//get collapse content selector
		var collapse_content_selector = $(this).attr('href');					
		var _this=$(this);
		//make the collapse content to be shown or hide
		var toggle_switch = $(this);
		$(collapse_content_selector).toggle(function(){
		  if($(this).css('display')=='none'){
            //change the button label to be 'Show'
			toggle_switch.html('<div class="arrow-down"></div>');
			jQuery(_this).parents('tr').addClass('data_even');
			jQuery(_this).parents('tr').css({'background':'',
											'border-left-width': '',
											'border-left-style': '',
											'border-left-color': '',
											'border': ''});
			
			
		}else{
            //change the button label to be 'Hide'
			toggle_switch.html('<div class="arrow-up"></div>');
			jQuery(_this).parents('tr').addClass('data_even');
			jQuery(_this).parents('tr').css({'background':'#ffffff',
											'border-left-width': '2px',
											'border-left-style': 'solid',
											'border-left-color': '#8ed030',
											});
			
			}
		});
	  });
	  
$('div.list_on_exchange').live('click',function(){
    	
    	if($(_this).attr('data-action') == 'list')
    	{
    		var ans = confirm("Are you sure you want to list this service on exchange?" );
    	
    		if(!ans)
    			return;
    	}	
    	
    	var _this = $(this);
    	
    	$(_this).html('Processing...');
    	
    	
    	$.post(ajaxurl,
    			{
    				action 	  			: 'awm_list_on_exchange',
    				list_action			: $(_this).attr('data-action'),
    				service_id  		: $(_this).attr('product-id'),
    				client_service_id	: $(_this).attr('service-id')
    			},
    			function(result)
    			{ 
    				if(result.success)
    				{
    					if(result.action == 'list')
    					{
    						//show listed +1
    						var td = $(_this).closest('tr.expanded').prev('tr').find('td.awm_service_supply');
    						
    						count = $(td).find('span.total-exchange-count').attr('data-count');
    						count = parseInt(count) + 1;
    						$(td).find('span.total-exchange-count').html(count).attr('data-count',count).hide().fadeIn();
    						
    						//show buy button
    						$(td).find('form').fadeIn();
    						
    						//change buy buttons
    						if(count == 1)
    						{
    							var action = $(_this).closest('tr.expanded').prev('tr').find('td.awm_service_action');
        						$(action).find('form.awm-buy').fadeOut();
        						$(action).find('form.exchange-buy').hide().fadeIn();
    						}	
    							
    						count = $(td).find('b.service-exchange-count').attr('data-count');
    						count = parseInt(count) + 1;
    						$(td).find('b.service-exchange-count').html(count).attr('data-count',count).hide().fadeIn();
    						
    						    						
    						td = $(_this).closest('tr.expanded').prev('tr').find('td.awm_service_status');
    						$(td).find('b.service-exchange-count').html(count).attr('data-count',count).hide().fadeIn();
    						
    						//reduce avaliable count
    						count = $(td).find('span.client-available-services').attr('data-count');
    						count = parseInt(count) - 1;
    						$(td).find('span.client-available-services').html(count).attr('data-count',count).hide().fadeIn();
    						
    						$(_this).html('De-list').attr('data-action','de_list').attr('title','De-list from exchange');
    						$(_this).next('div').fadeOut();
    						$(_this).parent().parent().find('td.awm_single_service_status').html('<span class="app">On Exchange</span>');
    					}
    					else if(result.action == 'de_list')
    					{
    						//show listed +1
    						var td = $(_this).closest('tr.expanded').prev('tr').find('td.awm_service_supply');
    						
    						count = $(td).find('span.total-exchange-count').attr('data-count');
    						count = parseInt(count) - 1;
    						$(td).find('span.total-exchange-count').html(count).attr('data-count',count).hide().fadeIn();
    						
    						//show buy button
    						if(count == 0)
    						{
    							$(td).find('form').fadeOut();
    							var action = $(_this).closest('tr.expanded').prev('tr').find('td.awm_service_action');
    							$(action).find('form.awm-buy').hide().fadeIn();
    							$(action).find('form.exchange-buy').fadeOut();
    						}	
    						
    						count = $(td).find('b.service-exchange-count').attr('data-count');
    						count = parseInt(count) - 1;
    						$(td).find('b.service-exchange-count').html(count).attr('data-count',count).hide().fadeIn();
    						
    						
    						
    						td = $(_this).closest('tr.expanded').prev('tr').find('td.awm_service_status');
    						$(td).find('b.service-exchange-count').html(count).attr('data-count',count).hide().fadeIn();
    						
    						//increase avaliable count
    						count = $(td).find('span.client-available-services').attr('data-count');
    						count = parseInt(count) + 1;
    						$(td).find('span.client-available-services').html(count).attr('data-count',count).hide().fadeIn();
    						
    						
    						$(_this).html('List').attr('data-action','list').attr('service-id',result.service_id).attr('title','List on exchange');;
    						$(_this).next('div').fadeIn();
    						$(_this).parent().parent().find('td.awm_single_service_status').html('<span class="app">Available</span>');
    					}	
    				}
    				
    			},'json');
    });
    
    
    $('.awm-service-demand').live('click',function(){
    		
    	var _this = $(this);
    	
    	$(_this).parent('.demand-div').hide().next('b').show();
    	
    	$.post(ajaxurl,
    			{
    				action 	  : 'awm_put_a_demand',
    				service_id  : $(_this).attr('data-service-id'),
    				type : $(_this).attr('data-type')
    			},
    			function(result)
    			{
    				console.log(result);
    				$(_this).parent('.demand-div').show().next('b').hide();
    				if(result.success)
    				{
    					if(result.type == 'add')
    					{
    						var count = $(_this).parent('.demand-div').prev('div').prev('span.service-total-demand').attr('data-count');
    						count = parseInt(count) + 1;
    						$(_this).parent('.demand-div').prev('div').prev('span.service-total-demand').html(count).attr('data-count',count).hide().fadeIn();
    					
    						count = $(_this).parent('.demand-div').prev('div').find('b').attr('data-count');
    						count = parseInt(count) + 1;
    						$(_this).parent('.demand-div').parent().parent('tr').find('td.awm_service_status').find('b.service-demand-count').html(count).hide().fadeIn();
    						$(_this).parent('.demand-div').prev('div').find('b').html(count).attr('data-count',count).hide().fadeIn();
    						$(_this).next('b').show();
    					}
    					else if(result.type == 'remove')
    					{
    						var count = $(_this).parent('.demand-div').prev('div').prev('span.service-total-demand').attr('data-count');
    						count = parseInt(count) - 1;
    						$(_this).parent('.demand-div').prev('div').prev('span.service-total-demand').html(count).attr('data-count',count).hide().fadeIn();
    					
    						count = $(_this).parent('.demand-div').prev('div').find('b').attr('data-count');
    						count = parseInt(count) - 1;
    						$(_this).parent('.demand-div').parent().parent('tr').find('td.awm_service_status').find('b.service-demand-count').html(count).hide().fadeIn();
    						$(_this).parent('.demand-div').prev('div').find('b').html(count).attr('data-count',count).hide().fadeIn();
    						
    						if(count == 0)
    							$(_this).hide();
    					}
    				}
    				   				
    				
    				
    			},'json');
    });
	
});