/**
 * Custome JS goes here
 */

jQuery(document).ready(function($){
	
	
//	 var ajaxurl =  global.ajaxurl; 	
	// alert(ajaxurl);
	 
	 
	 
	/* POPUP LOGIN */ 	 
	jQuery("#btn_login").live("click",function(){	 
		
		jQuery('#frm_login').submit();		
		//var data = jQuery("#frm_login").serializeArray();
		$.post(ajaxurl,{
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
				window.location.href = $("#hdn_siteurl").val()+'/dashboard/';
			} 
		})
	
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
		return false; 
		}		
	
	});	
	/*END POPUP LOGIN */
	
	
	
	/* POPUP SIGNUP */
	jQuery("#btn_signup").live("click",function(){	 
		
		alert(jQuery("#signup_email").val()+jQuery("#signup_password").val()+jQuery("#signup_fname").val()+jQuery("#signup_lname").val());
		
		
		jQuery('#frm_signup').submit();		
		//var data = jQuery("#frm_login").serializeArray();
		$.post(ajaxurl,{
			action : 'popup_usersignup',
			//data :  data 
			pdemail_ :jQuery("#signup_email").val(),
			pdpass_ :jQuery("#signup_password").val(),
			pdfname_ :jQuery("#signup_fname").val(),
			pdlname_ :jQuery("#signup_lname").val() 
		},
		function(response){  
			console.log(response);
			 if(response.success==true)
			{
				//alert("Registration  success...");				
				//window.location.href = '/home/'+'?msg=succes';
			} 
		})
	
	})
	
	
	
	
	jQuery('#frm_signup').validate({		
		
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