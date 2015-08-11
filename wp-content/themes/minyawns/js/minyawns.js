/**
 */



jQuery("#signinlink").click(function() {
   /* commented on 19jun2014 jQuery('#myModal').modal('hide')
    jQuery('#mylogin').modal('show')
    */
    window.location = siteurl+"/wp-login.php";
});



    

  






jQuery(document).ready(function($) {

     $(document.body).on('change', '#lst_sitecity', function() {

        if($("#lst_sitecity").val() =="Seattle"){

            if(siteurl.indexOf("fresno") > -1)
                window.location = seattle_url;
        }
        else{

            if(siteurl.indexOf("fresno") <= -1)
                window.location = fresno_url ;
        }

        var redirect_urls = get_fresno_seattle_urls();

        console.log('redirect urls');
        console.log(redirect_urls);

    })

    /*   Functions to set and get cookies */

    function setCookie(cname,cvalue,exdays){
        var d = new Date();
        d.setTime(d.getTime()+(exdays*24*60*60*1000));
        var expires = "expires="+d.toGMTString();
        //document.cookie = cname+"="+cvalue+"; "+expires;
        document.cookie = cname+"="+cvalue+"; "+expires+" ; path=/";
    }

    function getCookie(cname){
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++)
        {
            var c = ca[i].trim();
            if (c.indexOf(name)==0) return c.substring(name.length,c.length);
        }
        return "";
    }



    /*function to check & set cookie minyawns_city */
    function checkCookie(){


        modal_loaded = false;
        var city =getCookie("minyawns_visitor_city");

        if((typeof city === 'undefined')|| (city==="") ){
                  setTimeout(function(){

                    $('#chossecity').modal('show');

                }, 1000);


        }
        else{
            redirect_visitor_based_on_city_select(city,modal_loaded)

         }

    }

    function getURLParameter(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
    }

    var citychk = getURLParameter('citychk');
    var newUrlCity = getURLParameter('city');

 /* minyawns city selection pop up*/
     /* if(  (citychk === null) ||  (newUrlCity === null) || (parseInt(citychk) !=0) || (newUrlCity==="") ) {
        checkCookie() ;  //check and set minyawns_visitor_city cookie
     }else{

          expiry_days =  365  ; //set to 1 years

          setCookie("minyawns_visitor_city",newUrlCity,expiry_days);
      }*/





    function get_fresno_seattle_urls(){

        var site_protocol = window.location.protocol;
        var site_host =  window.location.host;
        var site_pathname = window.location.pathname;

        if(site_host.indexOf("fresno") > -1){
            var fresno_host =  site_host;
            var seattle_host = site_host.replace("fresno.", "");

        }

        else if(site_host.indexOf("fresno") <= -1){
            if(site_host.indexOf("www") <= -1){
                var fresno_host = "fresno."+site_host;
                var seattle_host = site_host;
            }
            else{
                var fresno_host = site_host.replace("www.", "www.fresno.");
                var seattle_host = site_host ;
            }
        }
        var site_url = new Array();

        site_url['seattle_url'] = site_protocol+"//"+seattle_host+site_pathname;
        site_url['fresno_url'] = site_protocol+"//"+fresno_host+site_pathname;

        return site_url;
    }


    function redirect_visitor_based_on_city_select(city,modal_loaded){

        var site_protocol = window.location.protocol;
        var site_host =  window.location.host;
        var site_pathname = window.location.pathname;



        console.log(window.location.protocol)
        console.log(window.location.host)
        console.log(window.location.pathname)

        if(city == "seattle"){

            if(modal_loaded == true){
                $('#chossecity').modal('hide');
            }

            //site_host = "fresno.localhost";

            if(site_host.indexOf("fresno") > -1){

                var site_host = site_host.replace("fresno.", "");

                redirect_url= site_protocol+"//"+site_host+site_pathname;

                window.location = redirect_url;
            }


        }
        else{


            if(modal_loaded == true){
                $('#chossecity').modal('hide');
            }
           // site_host = "www.minyawns.ajency.in";
            //alert(cur_site_url.indexOf("fresno"))
            if(site_host.indexOf("fresno") <= -1){
                if(site_host.indexOf("www") <= -1){
                    var site_host = "fresno."+site_host;
                }
                else{
                    var site_host = site_host.replace("www.", "www.fresno.");
                }


                redirect_url= site_protocol+"//"+site_host+site_pathname;


                window.location = redirect_url;


            }

        }

    }


    $(document.body).on('click', '.select__city', function() { 

        var cur_site_url = document.URL ;

        var selected_city = $(this).attr('city')

        expiry_days =  365  ; //set to 1 years

        setCookie("minyawns_visitor_city",selected_city,expiry_days);


        var modal_loaded = true ;
        redirect_visitor_based_on_city_select(selected_city,modal_loaded);


    })



	
	
//Braintree payment form
 $(document.body).on('click', '#paypal_pay', function() { 
	
	
	$('.payment_msg').html('').hide();
	 $("#submit").removeAttr("disabled");
	 $('.payformdiv').find('input:text').val('');    
	 //$('.payformdiv').find('input:hidden').val('');  
	 
	 
	if($('#paypal_form').length>0){
		
		$('#admin_submit').click(function(){
			//alert('admion save');
			 $('#hdn_markaspaid').val('1');
			 $('#paypal_form').submit();
			
			
		})
			
			
		
		 
		var ajax_submit = function (e) {
			//alert('ajax submit')
			
		      form = $('#paypal_form');
		      e.preventDefault();
		      $("#submit").attr("disabled", "disabled");
		    /*  $.post('braintree_payments', form.serialize(), function (data) {
		        form.parent().replaceWith(data);
		      });
		      
		      */
		      var target_ = $(e.target);
		      $(".submit_loader").show();
		      $.post(ajaxurl, {
	            action: 'braintree_payments',
	            data: form.serializeArray(),
	             
	        },
	                function(response) {
	        			$(".submit_loader").hide();
	        	 		//form.parent().replaceWith(data);
	        				
	        				target_.find('.row-fluid').find('.payment_msg').show().html('');
	        				
	        				if(response.success==true){
	        					target_.find('.row-fluid').find('.payment_msg')
	        										.addClass("payment_success").removeClass("alert")
	        										.removeClass("payment_error");
	        					
	        					target_.find('.row-fluid').find('.payment_msg').html('<i class="icon-ok"></i> &nbsp; ');
	        					
	        					target_.find('.payformdiv').html('');
	        					target_.find('.row-fluid').find('.payment_msg').append(response.msg)
	        					setTimeout(function(){ location.reload();}, 3000);
	        				}
	        				else{
	        					
	        					target_.find('.row-fluid').find('.payment_msg')
								.removeClass("payment_success").addClass("alert")
								.addClass("payment_error");
	        					
	        					 
	        					target_.find('.row-fluid').find('.payment_msg').append(response.msg)
	        					
	        					
	        				}
	        				
	        				
	        			    
	        				 
	        				/*if(response.error == false){
	        					
	        				}*/
	        	 		console.log(target_);
	        	 		console.log('response');
	        	 		console.log(response)
	        	 					
	                     
	                })


		      
		    }
		    var braintree = Braintree.create('MIIBCgKCAQEAyL76cIAt5S6/q8WIhJUXwVnjoQWeYk+KmGF/GM0xJdZD+XeZNoeqUSSz0J0D77lQN6uOhCOSI9IRpmWL+Z4OVNz6KxuyHWxm8z04JvrGutNpNKTHg06KhiVoINt70gzgOjTqk9RqNnrmGo8BMZ4bY52o4rMzaCXhkT/syn4ZDQ8jZT5eQ+WZsbRa4e+q864VJwrOWQrdFNHH5RvyVe5Mq7yy+T1NmCHAfaKGmBXKB8Lf9htwUKB+R2oniUjDUK27+eY8M+g4EeqNCi3aOOcttiT1Pvpa2HOJQbmXZsjXSqEd7P7cwAMxhbWGXukIlgRE7Oc/GGO+fo356rNB4ihlgQIDAQAB');
		    braintree.onSubmitEncryptForm('paypal_form', ajax_submit);	
			
	}
	
})	
	

	
	
	
	
	
	
	
	

//	The menu on the left
			jQuery(function() {
				jQuery('#menuleft').mmenu();
				
			});


			//	The menu on the right
			jQuery('#menuright').mmenu({
position: "right"
});
/*$('body').on('click', '[data-toggle=collapse-next]', function (e) {
    // Try to close all of the collapse areas first
    var parent_id = $(this).data('parent');*/
    
	/*$.each($(parent_id + ' .accordion-body'),function(){
		
		if($(this).hasClass('in'))
			$(this).collapse('hide');
	
	});*/
    // ...then open just the one we want
   /* var $target = $(this).closest('.panel').find('.accordion-body');
    
	if(!$target.hasClass('in'))
		$(this).text('Hide Information');
	else	
		$(this).text('Show Information');
	
	$target.collapse('toggle');
});	*/
//$('body').on('click', '[data-toggle=collapse-next]', function (e) {
 $(document.body).on('click', '[data-toggle=collapse-next]', function(e) { 
	
    // Try to close all of the collapse areas first
    var parent_id = $(this).data('parent');
   // $(parent_id+' .accordion-body').collapse('hide');

    // ...then open just the one we want
    var $target = $(this).parents('._li').find('.accordion-body');
   
    var texthtml;
   // alert("toggle");
    
    
   if($(e.target).closest('.status').find('.accordion-toggle').html() === 'Hide Information'){
	   texthtml='Show More Information';
	   $(e.target).parent().closest('.job-closed').find('.jobs-rating').hide('350') ;
   }       
   else{
       texthtml="Hide Information";
       $(e.target).parent().closest('.job-closed').find('.jobs-rating').show('350') ;
   }
   
    $target.collapse('toggle');
    $(e.target).closest('.status').find('.accordion-toggle').text(texthtml);
});	

    if ($(window).width() < 800) {

        (function($) {

            var allPanels = $('.accordion > dd').hide();

            $('.accordion > dt > a').click(function() {
                allPanels.slideUp();
                $(this).parent().next().slideDown();
                return false;
            });

        })(jQuery);

// do stuff

//$('body').on('click', '[data-toggle=collapse-next]', function (e) {
//    // Try to close all of the collapse areas first
//    var parent_id = $(this).data('parent');
//    $(parent_id+' .accordion-body').collapse('hide');
//
//    // ...then open just the one we want
//    var $target = $(this).parents('.panel').find('.accordion-body');
//    $target.collapse('toggle');
//});	
    }

    $("#select3").fcbkcomplete({
        json_url: "data.txt",
        addontab: true,
        maxitems: 10,
        input_min_size: 0,
        height: 10,
        cache: true,
        newel: true,
        select_all_text: "select",
    });

    var no_of_minyawns = 0;
 
$(document.body).on('click', '.jumper', function(e) { 
        e.preventDefault();

        $("body, html").animate({
            scrollTop: $($(this).attr('href')).offset().top
        }, 600);

    });

    var _rys = jQuery.noConflict();
    _rys("document").ready(function() {
        _rys(window).scroll(function() {
            if (_rys(this).scrollTop() > 136) {
                _rys('.bottom-menu-inverse').addClass("f-menublock");
            } else {
                _rys('.bottom-menu-inverse').removeClass("f-menublock");
            }
        });
    });

    $('#frm_login #txt_email, #frm_login #txt_pass').keydown(function(e) {
        if (e.keyCode == 13) {
            $('#form1').submit();
        }
    });
    $('.roundedTwo input').click(function() {
        $('.thumbnail').addClass('highlight')
    })

    jQuery('#link_employerregister').attr("onclick", "return true");
    jQuery('#link_minyawnregister').attr("onclick", "return true");
    jQuery('.m1').attr("onclick", "return true");


    $('.slider1').bxSlider({
        slideWidth: 200,
        minSlides: 1,
        maxSlides: 3,
        slideMargin: 10,
        auto: true,
        autoControls: true
    });


    $(function() {
        $(window).scroll(function(e)
        {
            if ($(this).scrollTop() > 300)
            {

                $(".steps-3 h4").show('fade');
            }
            else
            {
                $(".steps-3 h4").hide('fade');
            }
        });

    })


    $(function() {
        $(window).scroll(function(e)
        {
            if ($(this).scrollTop() > 1600)
            {

                $(".tooltip-right").show('slide');
                $(".tooltip-left").show('slide');
            }
            else
            {
                $(".tooltip-right").hide('slide');
                $(".tooltip-left").hide('slide');
            }
        });

    })


//    $('#trigger').popover({
//        html: true,
//        content: function() {
//            return 'asdasdads';
//        }
//    
//}).click(function(e){
//        var element = $(this);
//        $.ajax({
//            url: '/episoderatings/like/',
//            type: 'POST',
//            dataType: 'json',
//            data: {
//             
//            },
//            success: function(response){
//                if(response=='You have liked this episode'){
//                    $('span#episode_likes').text(parseInt($('span#episode_likes').text())+1);
//                }
//                $(element).attr('data-content',response).popover('show');
//            }
//        });
//        e.preventDefault();
//    });


    $('#link').click(function() {
        alert('beep');
    });


    /********************************** PROFILE JS CODE *************************************/
//$('html').click(function(e) {
//    $('#user-popdown').popover('hide');
//});
    function getSizes(im, obj)
    {
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
//        if (thumb_width > 0) {
//            $("#done-cropping").show();
//            $("#image_height").val(thumb_height);
//            $("#image_width").val(thumb_width)
//            $("#image_x_axis").val(x_axis);
//            $("#image_y_axis").val(y_axis);
//        }
        if (thumb_width > 0)
        {
            //if (confirm("Do you want to save image..!"))
            //{


            $("#done-cropping").show();
            $("#image_height").val(thumb_height);
            $("#image_width").val(thumb_width)
            $("#image_x_axis").val(x_axis);
            $("#image_y_axis").val(y_axis);

            //}
        }
        else
            alert("Please select portion..!");
    }

    //hide image select crop area on modal hide
    $('#myprofilepic').bind('hide', function() {
        $('img#uploaded-image').imgAreaSelect({hide: true});
    });

    $('img#uploaded-image').imgAreaSelect({
        aspectRatio: $("#aspect_ratio").val(),
        onSelectEnd: getSizes

    });
    $("#job_wages,#job_required_minyawns").keydown(function(event) {

        var charCode = (event.which) ? event.which : event.keyCode;
        if (charCode !== 46 && charCode > 31 && (charCode < 48 || charCode > 57 && charCode != 190))
            return false;

        return true;
    });

//    if (jQuery('#user-popdown').length > 0)
//    {
//        $('#user-popdown').popover(
//                {
//                    placement: 'bottom',
//                    html: true,
//                    content: '<div id="profile-data"><a href="" class="change-avatar"><div class="avatar user-1-avatar" width="150" height="150" /></a><div class="profile-data-display"><br><p class="muted" style=" color: #73C31B; ">' + email + '</p><h4></h4><span style="float:left; margin-right:10px;">Role:</span><p class="muted "> ' + role + '</p></div><div class="profile-actions"><span><a href="' + siteurl + '/profile/" class="popup_link"><i class="icon-user"></i> View Profile</a>&nbsp;<a href="' + logouturl + '" id="logout-button" class="popup_link"><i class="icon-unlock"></i>Logout </a></span></div></div>',
//                }
//        );
//    }




    $('#change-avatar-span').click(function(e) {

        e.preventDefault();
        //$('#change-avatar').click();
    });


var profuserid = $('#photoimg').attr('data-user');

    $('#photoimg').fileupload({
        url: SITEURL + '/wp-content/themes/minyawns/libs/user.php/change-avatar?uid='+profuserid,
        dataType: 'json',
        done: function(data) {
          
            /*console.log(data);
             $(".load_ajax-crop-upload").hide();
             $('#change-avatar-span').find('img').attr('src', data.result.image);
             alert(data.result.image);
             $('#change-avatar').removeAttr("disabled");
             $("#uploaded-image").attr('src', data.result.image);
             $("#image_name").val(data.result.image_name);
             
             if (data.result.image_height > 500)
             $("#uploaded-image").css('height', 'auto');
             
             if (data.result.image_width > 500)
             $("#uploaded-image").css('width', 'auto');*/
            // $("#myprofilepic").remove();
          window.location.reload(true);
            $(".load_ajax-crop-upload").hide();
           // $('#change-avatar-span').find('img').attr('src', data.result.image);
//            $("#image_name").attr('src', data.result.image);
            $('#change-avatar').removeAttr("disabled");




            ratio_y = data.result.image_height / 420
            ratio_x = data.result.image_width / 500
            if (ratio_y < ratio_x)
                a_ratio = Math.round(ratio_x * 1000) / 1000;
            else
                a_ratio = Math.round(ratio_y * 1000) / 1000;

            if (a_ratio < 1)
                a_ratio = 1;


            // alert("original :- width"+data.result.image_width+", height "+data.result.image_height+", ratio:"+a_ratio);
            img_width = Math.round((data.result.image_width / a_ratio) * 1000) / 1000;
            img_height = Math.round((data.result.image_height / a_ratio) * 1000) / 1000;

           // $("#uploaded-image").attr('src', data.result.image); remove this to show tool
            $("#image_name").val(data.result.image_name);
            $("#uploaded-image").css('width', img_width);
            $("#uploaded-image").css('height', img_height);


            $("#uploaded-image").load(function() {

                // $('img#uploaded-image').imgAreaSelect( {update: true} );           
                $("#div_cropmsg").html("Please drag to select/crop your picture.<br/>");

                //get the image position
                if ($("#uploaded-image").attr('src') != "")
                {
                    loaded_img_x = Math.round($("#uploaded-image").position().top * 1000) / 1000;
                    loaded_img_y = Math.round($("#uploaded-image").position().left * 1000) / 1000;

                    //alert(loaded_img_x+" - "+loaded_img_y);
                    pd_aspect_ratio = $("#aspect_ratio").val().split(":");

                    var defaultcrop_adjust;
                    defaultcrop_adjust = 50;

                    /* default crop fix for small dimension images */
                    if (pd_aspect_ratio[0] == 2)
                    {
                        defaultcrop_adjust_x = 50;
                        defaultcrop_adjust_y = 50;
                        if ((img_width < 200))
                            defaultcrop_adjust_x = img_width / 4;
                        if ((img_height < 100))
                            defaultcrop_adjust_y = img_height / 4;
                        if (defaultcrop_adjust_x < defaultcrop_adjust_y)
                            defaultcrop_adjust = defaultcrop_adjust_x;
                        else
                            defaultcrop_adjust = defaultcrop_adjust_y;
                    }


                    if (pd_aspect_ratio[0] == 1)
                    {
                        defaultcrop_adjust_x = 50;
                        defaultcrop_adjust_y = 50;
                        if ((img_width < 100))
                            defaultcrop_adjust_x = img_width / 2;
                        if ((img_height < 100))
                            defaultcrop_adjust_y = img_height / 2;
                        if (defaultcrop_adjust_x < defaultcrop_adjust_y)
                            defaultcrop_adjust = defaultcrop_adjust_x;
                        else
                            defaultcrop_adjust = defaultcrop_adjust_y;
                    }
                    /* End default crop fix for small dimension images */




                    default_x1 = (img_width / 2) - (pd_aspect_ratio[0] * defaultcrop_adjust);
                    default_y1 = (img_height / 2) - (pd_aspect_ratio[1] * defaultcrop_adjust);
                    default_x2 = (img_width / 2) + (pd_aspect_ratio[0] * defaultcrop_adjust);
                    default_y2 = (img_height / 2) + (pd_aspect_ratio[1] * defaultcrop_adjust);

                    /* alert(img_width / 2);
                     alert(pd_aspect_ratio[0]);
                     alert(pd_aspect_ratio[1]);*/

                    /* alert(loaded_img_x);
                     alert(loaded_img_y);
                     */
                    /*default_x1 = loaded_img_x+300 ;
                     default_y1 = loaded_img_y+300 ;
                     default_x2 = loaded_img_x+400;
                     default_y2 = loaded_img_y +400; 
                     */
                    /*alert(default_x1+" -- "+default_x2);
                     alert(default_y1+" -- "+default_y2);*/

                    default_x1 = Math.round(default_x1 * 1000) / 1000;
                    default_y1 = Math.round(default_y1 * 1000) / 1000;
                    default_x2 = Math.round(default_x2 * 1000) / 1000;
                    default_y2 = Math.round(default_y2 * 1000) / 1000;


                    default_thumb_width = default_x2 - default_x1;
                    default_thumb_height = default_y2 - default_y1;
                    $("#done-cropping").show();
                    $("#image_height").val(default_thumb_height);
                    $("#image_width").val(default_thumb_width)
                    $("#image_x_axis").val(default_x1);
                    $("#image_y_axis").val(default_y1);

                    $('img#uploaded-image').imgAreaSelect({
                        x1: default_x1,
                        y1: default_y1,
                        x2: default_x2,
                        y2: default_y2,
                        update: true


                    });

                }

            })

        },
        start: function(e, data) {
            $(".load_ajax-crop-upload").show();

            $('#change-avatar').attr("disabled", "disabled");
            var progress = parseInt(data.loaded / data.total * 100, 10);
        }
    });

    $(document.body).on('click', '#done-cropping', function() { 
        $(".load_ajax-crop-upload").show();
        $("#div_cropmsg").html("<br/>");


        console.log("w: " + $("#image_width").val() + " h:" + $("#image_height").val() + 'x1:' + $("#image_x_axis").val() + 'y1:' + $("#image_y_axis").val() + "image_name:" + $("#image_name").val() + " asp_ratio:" + $("#aspect_ratio").val());

var image_name=$("#image_name").val();
       
        $.ajax({
            type: "POST",
            url: SITEURL + '/wp-content/themes/minyawns/libs/user.php/resize-user-avatar',
            data: {w: $("#image_width").val(), h: $("#image_height").val(), 'x1': $("#image_x_axis").val(), 'y1': $("#image_y_axis").val(), image_name: image_name.replace(/ /g, "_"), asp_ratio: $("#aspect_ratio").val()}
        }).done(function(img_link) {
            $('#myprofilepic').modal('hide')
//            $('#change-avatar-span').find('img').attr('src', img_link);
//            $('#logged-in').find('img').attr('src', img_link);
            //location.reload();
            $(".load_ajax-crop-upload").hide();
            $("#div_cropmsg").html('<p class="help-block meta">Upload an image for your profile.</p></br>');

        });
    });



    //reset height for first span
    $(' .profile-wrapper').height($('#profile-edit').height() + 100);
    $(function() {
        $('.switch')['bootstrapSwitch']();
    });
    /** ANimate the profile view + edit views */ 
    $(document.body).on('click', '.edit-user-profile', function(e) { 

        e.preventDefault();
        var span1 = $('#profile-view');
        var span2 = $('#profile-edit');
        var w = $(span1).width();
        if (!$(this).hasClass('loaded'))
        {
            if ($(this).hasClass('view'))
            {

                $(span1).animate({left: 0}, 500);
                $(span2).show().animate({left: w}, 500);
                //  $('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a>');
                $('#bread-crumbs-id').html("<a href='" + siteurl + "/jobs' class='view loaded'>My Jobs</a><a href='#' class='view edit-user-profile'>Profile</a><a href='#' class='view loaded edit-user-profile'>My</a>");
            }
            else
            {

                $(this).removeClass('loaded');
                $('#profile-edit').find('div.alert').remove();
                $(span1).animate({left: -1 * w}, 500);
                $(span2).css({'left': w, 'top': 0});
                $(span2).show().animate({left: 0}, 500);
                $('#bread-crumbs-id').html("<a href='" + siteurl + "/jobs' class='view loaded'>My Jobs</a><a href='#' class='view edit-user-profile'>Profile</a><a href='#' class='view loaded edit-user-profile'>Edit Profile</a>");

            }
        }
    });
    //set emulateHTTP to true to send PUT requests as POST
    //Backbone.emulateHTTP = true;
    //Backbone.emulateJSON = true;











$('#min-profimagerr').fileupload({
        url: SITEURL + '/wp-content/themes/minyawns/libs/user.php/upload-profile-pic',
        dataType: 'json',
        done: function(data) {
          
          console.log(data);

          return false;
          
           /* $(".load_ajax-crop-upload").hide();
            $('#change-avatar-span').find('img').attr('src', data.result.image);
            $("#image_name").attr('src', data.result.image);
            $('#change-avatar').removeAttr("disabled");*/




            ratio_y = data.result.image_height / 420
            ratio_x = data.result.image_width / 500
            if (ratio_y < ratio_x)
                a_ratio = Math.round(ratio_x * 1000) / 1000;
            else
                a_ratio = Math.round(ratio_y * 1000) / 1000;

            if (a_ratio < 1)
                a_ratio = 1;


            // alert("original :- width"+data.result.image_width+", height "+data.result.image_height+", ratio:"+a_ratio);
            img_width = Math.round((data.result.image_width / a_ratio) * 1000) / 1000;
            img_height = Math.round((data.result.image_height / a_ratio) * 1000) / 1000;

           // $("#uploaded-image").attr('src', data.result.image); remove this to show tool
            $("#image_name").val(data.result.image_name);
            $("#uploaded-image").css('width', img_width);
            $("#uploaded-image").css('height', img_height);


            $("#uploaded-image").load(function() {

                // $('img#uploaded-image').imgAreaSelect( {update: true} );           
                $("#div_cropmsg").html("Please drag to select/crop your picture.<br/>");

                //get the image position
                if ($("#uploaded-image").attr('src') != "")
                {
                    loaded_img_x = Math.round($("#uploaded-image").position().top * 1000) / 1000;
                    loaded_img_y = Math.round($("#uploaded-image").position().left * 1000) / 1000;

                    //alert(loaded_img_x+" - "+loaded_img_y);
                    pd_aspect_ratio = $("#aspect_ratio").val().split(":");

                    var defaultcrop_adjust;
                    defaultcrop_adjust = 50;

                    /* default crop fix for small dimension images */
                    if (pd_aspect_ratio[0] == 2)
                    {
                        defaultcrop_adjust_x = 50;
                        defaultcrop_adjust_y = 50;
                        if ((img_width < 200))
                            defaultcrop_adjust_x = img_width / 4;
                        if ((img_height < 100))
                            defaultcrop_adjust_y = img_height / 4;
                        if (defaultcrop_adjust_x < defaultcrop_adjust_y)
                            defaultcrop_adjust = defaultcrop_adjust_x;
                        else
                            defaultcrop_adjust = defaultcrop_adjust_y;
                    }


                    if (pd_aspect_ratio[0] == 1)
                    {
                        defaultcrop_adjust_x = 50;
                        defaultcrop_adjust_y = 50;
                        if ((img_width < 100))
                            defaultcrop_adjust_x = img_width / 2;
                        if ((img_height < 100))
                            defaultcrop_adjust_y = img_height / 2;
                        if (defaultcrop_adjust_x < defaultcrop_adjust_y)
                            defaultcrop_adjust = defaultcrop_adjust_x;
                        else
                            defaultcrop_adjust = defaultcrop_adjust_y;
                    }
                    /* End default crop fix for small dimension images */




                    default_x1 = (img_width / 2) - (pd_aspect_ratio[0] * defaultcrop_adjust);
                    default_y1 = (img_height / 2) - (pd_aspect_ratio[1] * defaultcrop_adjust);
                    default_x2 = (img_width / 2) + (pd_aspect_ratio[0] * defaultcrop_adjust);
                    default_y2 = (img_height / 2) + (pd_aspect_ratio[1] * defaultcrop_adjust);

                    /* alert(img_width / 2);
                     alert(pd_aspect_ratio[0]);
                     alert(pd_aspect_ratio[1]);*/

                    /* alert(loaded_img_x);
                     alert(loaded_img_y);
                     */
                    /*default_x1 = loaded_img_x+300 ;
                     default_y1 = loaded_img_y+300 ;
                     default_x2 = loaded_img_x+400;
                     default_y2 = loaded_img_y +400; 
                     */
                    /*alert(default_x1+" -- "+default_x2);
                     alert(default_y1+" -- "+default_y2);*/

                    default_x1 = Math.round(default_x1 * 1000) / 1000;
                    default_y1 = Math.round(default_y1 * 1000) / 1000;
                    default_x2 = Math.round(default_x2 * 1000) / 1000;
                    default_y2 = Math.round(default_y2 * 1000) / 1000;


                    default_thumb_width = default_x2 - default_x1;
                    default_thumb_height = default_y2 - default_y1;
                    $("#done-cropping").show();
                    $("#image_height").val(default_thumb_height);
                    $("#image_width").val(default_thumb_width)
                    $("#image_x_axis").val(default_x1);
                    $("#image_y_axis").val(default_y1);

                    $('img#uploaded-image').imgAreaSelect({
                        x1: default_x1,
                        y1: default_y1,
                        x2: default_x2,
                        y2: default_y2,
                        update: true


                    });

                }

            })

        },
        start: function(e, data) {
            $(".load_ajax-crop-upload").show();

            $('#change-avatar').attr("disabled", "disabled");
            var progress = parseInt(data.loaded / data.total * 100, 10);
        }
    });

    $(document.body).on('click', '#done-cropping', function() { 
        $(".load_ajax-crop-upload").show();
        $("#div_cropmsg").html("<br/>");


        console.log("w: " + $("#image_width").val() + " h:" + $("#image_height").val() + 'x1:' + $("#image_x_axis").val() + 'y1:' + $("#image_y_axis").val() + "image_name:" + $("#image_name").val() + " asp_ratio:" + $("#aspect_ratio").val());

var image_name=$("#image_name").val();
       
        $.ajax({
            type: "POST",
            url: SITEURL + '/wp-content/themes/minyawns/libs/user.php/resize-user-avatar',
            data: {w: $("#image_width").val(), h: $("#image_height").val(), 'x1': $("#image_x_axis").val(), 'y1': $("#image_y_axis").val(), image_name: image_name.replace(/ /g, "_"), asp_ratio: $("#aspect_ratio").val()}
        }).done(function(img_link) {
            $('#myprofilepic').modal('hide')
//            $('#change-avatar-span').find('img').attr('src', img_link);
//            $('#logged-in').find('img').attr('src', img_link);
            //location.reload();
            $(".load_ajax-crop-upload").hide();
            $("#div_cropmsg").html('<p class="help-block meta">Upload an image for your profile.</p></br>');

        });
    });



    //reset height for first span
    $(' .profile-wrapper').height($('#profile-edit').height() + 100);
    $(function() {
        $('.switch')['bootstrapSwitch']();
    });
    /** ANimate the profile view + edit views */ 
    $(document.body).on('click', '.edit-user-profile', function(e) { 

        e.preventDefault();
        var span1 = $('#profile-view');
        var span2 = $('#profile-edit');
        var w = $(span1).width();
        if (!$(this).hasClass('loaded'))
        {
            if ($(this).hasClass('view'))
            {

                $(span1).animate({left: 0}, 500);
                $(span2).show().animate({left: w}, 500);
                //  $('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a>');
                $('#bread-crumbs-id').html("<a href='" + siteurl + "/jobs' class='view loaded'>My Jobs</a><a href='#' class='view edit-user-profile'>Profile</a><a href='#' class='view loaded edit-user-profile'>My</a>");
            }
            else
            {

                $(this).removeClass('loaded');
                $('#profile-edit').find('div.alert').remove();
                $(span1).animate({left: -1 * w}, 500);
                $(span2).css({'left': w, 'top': 0});
                $(span2).show().animate({left: 0}, 500);
                $('#bread-crumbs-id').html("<a href='" + siteurl + "/jobs' class='view loaded'>My Jobs</a><a href='#' class='view edit-user-profile'>Profile</a><a href='#' class='view loaded edit-user-profile'>Edit Profile</a>");

            }
        }
    });












$('#min-profimage').fileupload({
    dataType : 'json',
    url : SITEURL + '/wp-content/themes/minyawns/libs/user.php/upload-profile-pic',
    add: function (e, data) {
        data.submit();
    },
    done: function (e, data) {
            //console.log(data);
            ratio_y = data.result.image_height / 420
            ratio_x = data.result.image_width / 500
            if (ratio_y < ratio_x)
                a_ratio = Math.round(ratio_x * 1000) / 1000;
            else
                a_ratio = Math.round(ratio_y * 1000) / 1000;

            if (a_ratio < 1)
                a_ratio = 1;

            img_width = Math.round((data.result.image_width / a_ratio) * 1000) / 1000;
            img_height = Math.round((data.result.image_height / a_ratio) * 1000) / 1000;

            $("#uploaded-image").attr('src', data.result.image);
            $("#image_name").val(data.result.image_name);
            $("#uploaded-image").css('width', img_width);
            $("#uploaded-image").css('height', img_height);

            $("#uploaded-image").load(function() {

                // $('img#uploaded-image').imgAreaSelect( {update: true} );           
                $("#div_cropmsg").html("Please drag to select/crop your picture.<br/>");

                //get the image position
                if ($("#uploaded-image").attr('src') != "")
                {

                    console.log('image loaded...');
                    loaded_img_x = Math.round($("#uploaded-image").position().top * 1000) / 1000;
                    loaded_img_y = Math.round($("#uploaded-image").position().left * 1000) / 1000;

                    //alert(loaded_img_x+" - "+loaded_img_y);
                    pd_aspect_ratio = $("#aspect_ratio").val().split(":");

                    var defaultcrop_adjust;
                    defaultcrop_adjust = 50;

                    /* default crop fix for small dimension images */
                    if (pd_aspect_ratio[0] == 2)
                    {
                        defaultcrop_adjust_x = 50;
                        defaultcrop_adjust_y = 50;
                        if ((img_width < 200))
                            defaultcrop_adjust_x = img_width / 4;
                        if ((img_height < 100))
                            defaultcrop_adjust_y = img_height / 4;
                        if (defaultcrop_adjust_x < defaultcrop_adjust_y)
                            defaultcrop_adjust = defaultcrop_adjust_x;
                        else
                            defaultcrop_adjust = defaultcrop_adjust_y;
                    }


                    if (pd_aspect_ratio[0] == 1)
                    {
                        defaultcrop_adjust_x = 50;
                        defaultcrop_adjust_y = 50;
                        if ((img_width < 100))
                            defaultcrop_adjust_x = img_width / 2;
                        if ((img_height < 100))
                            defaultcrop_adjust_y = img_height / 2;
                        if (defaultcrop_adjust_x < defaultcrop_adjust_y)
                            defaultcrop_adjust = defaultcrop_adjust_x;
                        else
                            defaultcrop_adjust = defaultcrop_adjust_y;
                    }
                    /* End default crop fix for small dimension images */




                    default_x1 = (img_width / 2) - (pd_aspect_ratio[0] * defaultcrop_adjust);
                    default_y1 = (img_height / 2) - (pd_aspect_ratio[1] * defaultcrop_adjust);
                    default_x2 = (img_width / 2) + (pd_aspect_ratio[0] * defaultcrop_adjust);
                    default_y2 = (img_height / 2) + (pd_aspect_ratio[1] * defaultcrop_adjust);

                    default_x1 = Math.round(default_x1 * 1000) / 1000;
                    default_y1 = Math.round(default_y1 * 1000) / 1000;
                    default_x2 = Math.round(default_x2 * 1000) / 1000;
                    default_y2 = Math.round(default_y2 * 1000) / 1000;


                    default_thumb_width = default_x2 - default_x1;
                    default_thumb_height = default_y2 - default_y1;
                    $("#done-cropped").show();
                    $("#image_height").val(default_thumb_height);
                    $("#image_width").val(default_thumb_width)
                    $("#image_x_axis").val(default_x1);
                    $("#image_y_axis").val(default_y1);
                    $("#unique_code").val(data.result.unique_code);

                    $('img#uploaded-image').imgAreaSelect({
                        x1: default_x1,
                        y1: default_y1,
                        x2: default_x2,
                        y2: default_y2,
                        update: true


                    });

                }

            })
},
start: function(e, data) {
    $(".load_ajax-crop-upload").show();

    $('#change-avatar').attr("disabled", "disabled");
    var progress = parseInt(data.loaded / data.total * 100, 10);
}
});





$(document.body).on('click', '#done-cropped', function() { 
        $("#preloadprocess").css('display','block');
        $("#div_cropmsg").html("<br/>");


        //console.log("w: " + $("#image_width").val() + " h:" + $("#image_height").val() + 'x1:' + $("#image_x_axis").val() + 'y1:' + $("#image_y_axis").val() + "image_name:" + $("#image_name").val() + " asp_ratio:" + $("#aspect_ratio").val());

var image_name=$("#image_name").val();
       
        $.ajax({
            type: "POST",
            url: SITEURL + '/wp-content/themes/minyawns/libs/user.php/profile-pic-resize',
            data: {w: $("#image_width").val(), unique_code: $("#unique_code").val(), h: $("#image_height").val(), 'x1': $("#image_x_axis").val(), 'y1': $("#image_y_axis").val(), image_name: image_name.replace(/ /g, "_"), asp_ratio: $("#aspect_ratio").val()}
        }).done(function(data) {
            if(data.path.length>0){
                $("#preloadprocess").css('display','none');
                $('#myprofilepic').modal('hide');
                $('#profile_pic_path').val(data.path);
                $('#profile_image_id').val(data.unique_id);
                $("#avatar img").attr('src', data.url);

            }
                        
        });
    });














    /**
     * A simple backbone model for profile
     */
    var Profile = Backbone.Model.extend({
        url: function() {
            return SITEURL + '/wp-content/themes/minyawns/libs/user.php/user';
        },
        validate: function(attr) {

            var errors = [];
            _.each(attr, function(index, ele) {

                if (ele == 'id')
                    return;

                /*if (ele == 'user_skills2')
                    return;*/

                /*if (ele == 'short_bio')
                    return;*/


                if (ele == 'linkedin')
                    return;

                 if (ele == 'facebook_link')
                    return;

                if (ele == 'short_bio')
                {
                    if (attr[ele].length >200){
                        errors.push({field: ele, msg: 'Max 200 characters '});
                    }else if (attr[ele].length <=0){
                        return
                    }
                }


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
//alert(validateURL("asdasd"));
        e.preventDefault();
        var _this = $(this);
        $(this).attr('disabled', 'disabled');
        //remove previuous errors
        $('#profile-edit-form').find('span.form-error').remove();


        //attach it to global window so we can use it later to update the main profile view
        window.profile = new Profile();
        window.profile.bind('invalid', function(model, error, options) {

            _.each(error, function(ele, index) {
                var msg = ucfirst(ele.msg);


                
                    

                    if (ele.field == "company_website") {
                        if (validateURL($("#company_website").val()) === false) {
                            $('#company_website').parent().append('<span class="form-error">Please enter a valid url</span>');
                            return false;
                        }
                    }


                              

                var msg_new = msg.replace('_', ' ');


                $('#' + ele.field).parent().append('<span class="form-error">' + msg_new.replace('skills2', 'skills') + '</span>');



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
                if (data.last_name === undefined)
                {
                    data.last_name = '';
                }
                if (data.first_name != undefined) {
                    $('#profile-view').find('.name').html(data.first_name + ' ' + data.last_name + ' <a href="#" class="edit edit-user-profile"><i class="icon-edit"></i> Edit</a>');
                } else {
                    $('#profile-view').find('.name').html(data.company_name + ' <a href="#" class="edit edit-user-profile"><i class="icon-edit"></i> Edit</a>');
                }
                //minyawns role
                $('#profile-view').find('.college_data').text('College:' + data.college);
                $('#profile-view').find('.major_data').text('Major:' + data.major);
                var skills = '';
                var skill_name = '';

//                _.each(data.user_skills2, function(ele, index) {
//                    skills += "<span class='label label-small'>" + ele + "</span>";
//                });
                if (data.first_name != undefined)
                    skill_name = data.user_skills2.split(',');

                for (i = 0; i < skill_name.length; i++)
                {
                    skills += "<span class='label label-small'>" + skill_name[i] + "</span>";
                }

                $('#profile-view').find('.list-box').html(skills);
                //employer role
                $('#profile-view').find('.location').text(data.location);
                $('#profile-view').find('.employer-body').text(data.profilebody);
                $('#profile-view').find('.profilebody').text(data.profilebody);
                $('#profile-view').find('.website').html('Company Website : <a href="http://' + data.company_website + '" target="_blank">' + data.company_website + '</a>');
                //show success message
                $('#profile-edit').prepend('<div class="alert alert-success alert-box"><b>Profile</b> updated succesfully <button type="button" class="close fui-cross" data-dismiss="alert"></button></div>');
//                var span1 = $('#profile-view');
//                var span2 = $('#profile-edit');
//                var w = $(span1).width();
//                $(span1).animate({left: 0}, 500);
//                $(span2).hide();
//                
                window.location.href = SITEURL + '/profile';
                // $(span1).show().animate({left: w}, 500);
                $('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a>');
            },
            errors: function() {
                $(_this).removeAttr('disabled');
                alert('Error!!! Please try again');
            }
        });
    });
    /********************************** PROFILE JS CODE *************************************/
    /*
     *  LOADs a new link now
     * 
     */
//    $("#add-job-button,#new-job,#create_my_jobs").on('click', function(e) {
//
//load_add_job_form(e);
//        //jQuery("#parent_item").html("My Jobs");
////        jQuery("#sub_item").html("Add Job");
////        window.location.hash = '#add-job';
////        var _this = $("#add-job-button");
////        e.preventDefault();
////        $("#accordion24").empty();
////        $(".load_more").toggle();
////        // $("#add-job-form").toggle();
////        $(".main-menu ul li").removeClass("selected");
////        $("#job-success").hide();
////        $("#add-job-form").toggle("slow", function() {
////            if ($("#add-job-form").is(':hidden')) {
////                $(_this).html('<i class="fui-mail"></i> Add Jobs');
////                $("#my_jobs").removeClass('selected');
////                $("#load-more-my-jobs").hide();
////            } else {
////                $(_this).html('Cancel');
////                $("#load-more-my-jobs").hide();
////
////            }////            }

////        });
////        $("#add-job-form").find('input:text').val('');
////        $("#job_task").val('');
////        $("#job_details").val(" ");
////
////        //$('#job_tags_tagsinput').find('span').remove();
//    });




    $('#add-job').click(function(e) {

        e.preventDefault();
        _this = $(this);


        //remove previuous errors
        $('#job-form').find('span.form-error').remove();
        //attach it to global window so we can use it later to update the main profile view
        window.job = new Job();
       
        window.job.bind('invalid', function(model, error, options) {

            _.each(error, function(ele, index) {

                $('#' + ele.field).closest('div.controls').append('<span class="form-error">' + ele.msg + '</span>');
            })
            $(".modal_ajax_large").hide();
        });

        var data = $("#job-form").serializeArray();
        $(this).attr('disabled', 'disabled');
        var job_data = {};
        _.each(data, function(ele, index) {
            job_data[ele.name] = ele.value;
        });
        $(".modal_ajax_large").show();
        window.job.save(job_data,
                {
                    wait: true,
                    success: function(model, resp) {


//console.log(resp.post_id);return;
                        //get model data
                        // $(_this).removeAttr('disabled');
                        $("#add-job-form").slideUp("slow");
                        //  $("#add-job-button").html('<i class="fui-mail"></i> Add Jobs');
                        $("#add-job-form").find('input:text').val('');
                        $("#job_task").val('');
                        $("#job_details").val(" ");

                        $('#job_tags_tagsinput').find('span').remove()
                        $('html, body').animate({scrollTop: '0px'}, 300);
                        $("#job-success").show();
                        $(".modal_ajax_large").hide();
                        var id;

                        window.location.href = resp.post_slug;
                        // load_browse_jobs(resp.post_id + '', 'single_json_my_jobs');
                    },
                    errors: function() {
                        $(_this).removeAttr('disabled');
                        alert('Error!!! Please try again');
                    }
                });
    });
    $("#browse-jobs").click(function(e) {
        $("#calendar-jobs").hide();/*bread crumbs*/
        $("#calendar").hide();
        $("#hide-calendar").hide();
        $("#show-calendar").show();
        $(".browse-jobs-table").show();
    });
    $("#browse").click(function(e) {

        $("#accordion2").empty();
        $(".browse-jobs-table").show();
        $("#hide-calendar").hide();
        $("#show-calendar").show();
        load_browse_jobs(); //function in jobs.js
    });

    $("#my_jobs").click(function(e) {

        fetch_my_jobs(logged_in_user_id);
    });




    $("#load-more,#load-more-my-jobs").click(function(e) {
        $(".load_ajax").show();
        // $("#accordion2").empty();

        var _data = {
            offset: window.fetchj.models.length

        };

        var first = getUrlVars()["cat_id"];

        if (typeof(first) !== 'undefined')
            _data.filter = first;

        if ($("#tab_identifier").val() === '1') {
            _data.my_jobs = '1';

            // $("#accordion24").empty();
        }
//if ($("#tab_identifier").val() === '0') {
//window.fetchj.bind('add',function(collection){
//     var existing = this.where({
//    post_title: collection.get('post_title'),
//   
//  });
//  //console.log(existing);
//  if (existing.length > 1) 
//      {
//          this.remove(collection)
//         // alert(existing['post_title']);
//      }
////  alert(existing.length);
//     var job_stat = job_status_li(collection);
//                    var job_collapse_button_var = job_collapse_button(collection);
//                    var minyawns_grid = job_minyawns_grid(collection)
//                    if (collection.toJSON().load_more === 1){
//                        $("#load-more,#load-more-my-jobs").hide();
//                    }                                 
//  
//                    
//                    var template = _.template($("#jobs-table").html());
//                    //console.log(collection.models.length);
//                    var html = template({result: collection.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var, minyawns_grid: minyawns_grid});
//
//                    if ($("#tab_identifier").val() === '1') {
//                        $("#accordion24").append(html);
//                    }
//                    else {
//                       
//                        $("#accordion2").append(html);
//                    }
//});
//}

        window.fetchj.fetch({
            remove: false,
            add: true,
            data: _data,
            success: function(collection, response) {
                $(".load_ajax").hide();
                var template = _.template($("#jobs-table").html());
                $("#accordion2").empty();
                $("#accordion24").empty();
                _.each(collection.models, function(model) {
                    var job_stat = job_status_e(model);
                    var job_collapse_button_var = job_collapse_b(model);
                    var minyawns_grid = job_minyawns_grid(model)
                    if (model.toJSON().load_more === 1)
                        $("#load-more,#load-more-my-jobs").hide();
                    //console.log(collection.models.length);
                    var html = template({result: model.toJSON(), job_progress: job_stat, job_collapse_button: job_collapse_button_var, minyawns_grid: minyawns_grid});

                    if ($("#tab_identifier").val() === '1') {
                        $("#accordion24").append(html); 
                    }
                    else {

                        $("#accordion24").append(html); 
                    }

                });
            },
            error: function(err) {
//console.log(err);
            }

        });
    });
    /*############POP UP############*/
    /*Function to etrieve password */
    $(document.body).on('click', '#user-submit', function() { 
        jQuery('#frm_forgotpassword').submit();
    })


    /*forgot password form validation */
    $('#frm_forgotpassword').validate({
        rules: {
            'user_login': {
                required: true

            }

        },
        submitHandler: function(form) {

            jQuery("#div_msgforgotpass").html("<img src='" + jQuery("#hdn_siteurl").val() + "/wp-content/themes/minyawns/images/ajax-loader.gif' width='50' height='50' class='img-center'/>");
            jQuery.post(ajaxurl, {
                action: 'retrieve_password_ajx',
                user_login: jQuery("#user_login").val(),
            },
                    function(response) {
                        console.log(response);
                        if (response.success == true)
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
    jQuery(document.body).on('click', '#btn_forgotpass', function() {  
        jQuery("#div_forgotpass").toggle();
        jQuery("#div_msgforgotpass").html("");
    })


    /* reset password form validation */
    $('#resetpassform').validate({
        rules: {
            'pass1': {
                required: true,
                minlength: 6
            },
            'pass2': {
                required: true,
                minlength: 6,
                equalTo: "#pass1"
            }
        },
        messages: {
            'pass1': {
                required: 'Please enter new password'
            },
            'pass2': {
                required: 'Please renter new password',
                equalTo: "The password fields entered do not match"
            }
        }

    });
    /* end reset pasword validation */

    /*trigger login lick on no acess login option click*/
 jQuery(document.body).on('click', '#btn__login_oaccess', function() { 
        jQuery("#btn__login").trigger('click');
   });
 jQuery("#link__employerregister").on("click", function() {
        jQuery("#link_employerregister").trigger('click');
   });
  jQuery("#link__minyawnregister").on("click", function() {
        jQuery("#link_minyawnregister").trigger('click');
   });
    /* POPUP LOGIN */

    //hide forget password section on login pop up link click
    jQuery(document.body).on('click', '#btn__login,#btn__loginpop', function() {  
        jQuery("#div_forgotpass").hide();
        jQuery("#div_msgforgotpass").html("");
        jQuery("#user_login").val("");
        jQuery("#div_loginmsg").html("");
        jQuery("#wp-fb-ac-fm").append('<input type="hidden" name ="fb_chk_usersigninform" id="fb_chk_usersigninform" value="loginfrm" /> '); ////jQuery("#usr_role").val('employer');
        jQuery("#frm_login").trigger("reset");
        $("#txt_email").removeClass("error");
        $(".error").hide();
    })

    //user login form validation and user login
    jQuery(document.body).on('click', '#btn_login', function() {   
        jQuery('#frm_login').submit();
        
    })




    $('#frm_login').validate({
        rules: {
            'txt_pass': {
                required: true,
                minlength: 3
            },
            'txt_email': {
                required: true,
                minlength: 6,
                email: true
            }

        },
        submitHandler: function(form) {
            jQuery("#div_loginmsg").html("<img src='" + jQuery("#hdn_siteurl").val() + "/wp-content/themes/minyawns/images/ajax-loader.gif' width='50' height='50' class='img-center'/>");
            jQuery.post(ajaxurl, {
                action: 'popup_userlogin',
                pdemail: jQuery("#txt_email").val(),
                pdpass: jQuery("#txt_pass").val(),
            },
                    function(response) {

                        if (response.success == true)
                        {
                            if (jQuery("#noaccess_redirect_url").length > 0) {
                                window.location.href = jQuery("#noaccess_redirect_url").val();
                            } else {

//                                if (response.user_role == 'employer') {

                                   if(location.href.match("#my-jobs") == null){
                                    
                                        window.location =jQuery("#hdn_siteurl").val() + '/jobs/#browse';
                                   }else{ 
                                    window.location.href = jQuery("#hdn_siteurl").val() + '/jobs/#my-jobs';
                                   }
                                    
//                                } else {
//
//                                    window.location = jQuery("#hdn_siteurl").val() + '/jobs/#browse';
//                                }
                                
                            }
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
    jQuery(document.body).on('click', '#lnk_signin', function() {   
       /* commented on 19june2014 jQuery("#signup_popup_close").click();
        jQuery("#btn__login").click();
        */
        window.location = siteurl+"/wp-login.php";
    })
    jQuery(document.body).on('click', '.login-signup', function() {    
        $('#mylogin').modal('hide')
    })


    /* POPUP SIGNUP */

    //function to set div,message for minion sign up modal
    function setup_minionsignup_modal()
    {
        jQuery("#div_signupheader").html('<h4 id="myModalLabel">Sign Up as a Minion</h4>');
        //jQuery("#div_signup_subheader").html('Not a Minion? Go ahead sign up to get one <a href="#" id="show_employerreg">here</a>');
        jQuery("#signup_role").val('minyawn');
        if (jQuery("#usr_role").length > 0)
        {
            jQuery("#usr_role").val("minyawn");
        }
        else
        {
            jQuery("#wp-fb-ac-fm").append('<input type="hidden" name ="usr_role" id="usr_role" value="minyawn" /> '); //jQuery("#usr_role").val('minyawn');
        }

        if (jQuery("#fb_chk_usersigninform").length > 0)
        {
            jQuery("#fb_chk_usersigninform").remove();
        }
        jQuery("#div_alreadyregister").html("Already a Minyawn?");
        jQuery("#signup_fname").attr("placeholder", "First Name");
        jQuery("#signup_lname").attr("placeholder", "Last Name");
        jQuery("#signup_fname").show()
        jQuery("#signup_lname").show()
        jQuery("#signup_email").show()
        jQuery("#signup_password").show()
        jQuery("#signup_company").hide();
        jQuery("#div_signupmsg").html("");
        //validator_signup.resetForm();
        jQuery("#signup_email").val("");
        jQuery("#signup_password").val("");
        jQuery("#signup_fname").val("");
        jQuery("#signup_lname").val("");
        jQuery("#signup_email").removeClass('error');
    }
 jQuery(document.body).on('click', '#link_minyawnregister', function() {     
        setup_minionsignup_modal()
    })

   jQuery(document.body).on('click', '#show_minionreg', function() { 
        setup_minionsignup_modal()

    })





function customValidate(data){
console.log(data.rules);
return false;
}


function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };


    //function to set div,message for employer sign up modal
    function setupemployersignup_modal()
    {
        jQuery("#div_signupheader").html('<h4 id="myModalLabel">Sign Up as an Employer </h4> ');

        jQuery("#div_signup_subheader").html('Looking for a job? Sign in as a <a href="#" id="show_minionreg">Minion</a>');
        jQuery("#signup_role").val('employer');
        if (jQuery("#usr_role").length > 0)
        {
            jQuery("#usr_role").val("employer");
        }
        else
        {
            jQuery("#wp-fb-ac-fm").append('<input type="hidden" name ="usr_role" id="usr_role" value="employer" /> '); ////jQuery("#usr_role").val('employer');
        }
        if (jQuery("#fb_chk_usersigninform").length > 0)
        {
            jQuery("#fb_chk_usersigninform").remove();
        }
        jQuery("#div_alreadyregister").html("Already registered at Minyawns?");
        jQuery("#signup_fname").attr("placeholder", "First Name");
        jQuery("#signup_lname").attr("placeholder", "Last Name");
        jQuery("#signup_fname").show();
        jQuery("#signup_lname").show();
        jQuery("#signup_email").show();
        jQuery("#signup_password").show();
        jQuery("#signup_company").show();
        jQuery("#div_signupmsg").html("");
        validator_signup.resetForm();
        jQuery("#signup_email").val("");
        jQuery("#signup_password").val("");
        jQuery("#signup_fname").val("");
        jQuery("#signup_lname").val("");
        jQuery("#signup_email").removeClass("error");
    }

 jQuery(document.body).on('click', '#link_employerregister', function() {  
        setupemployersignup_modal()
    })

 jQuery(document.body).on('click', '#show_employerreg', function() { 
        setupemployersignup_modal()

    })

//on enter key press trigger form submission
$(document.body).on('keyup', '#myModal', function(e) { 
  if (e.keyCode == 13) {
    $("#btn_signup").trigger('click')
  }
});

//on enter key press trigger form submission Business
$(document.body).on('keyup', '#myModalBiz', function(e) { 
  if (e.keyCode == 13) {
    $("#btn_signup-biz").trigger('click')
  }
});

//on enter key press trigger form submission
$(document.body).on('keyup', '#mylogin', function(e) {  
  if (e.keyCode == 13) { 
    $("#btn_login").trigger('click')
  }
});



jQuery(document.body).on('click', '#btn_signup', function(e) {

    var error = [];

    if($("#signup_password").val().length == 0){
        error.push('signup_password');
    }
    if($("#signup_email").val().length == 0){
        error.push('signup_email');
    }
    if (!ValidateEmail($("#signup_email").val())) {
            error.push('signup_email');
    }
    if($("#signup_fname").val().length == 0){
        error.push('signup_fname');
    }
    if($("#signup_lname").val().length == 0){
        error.push('signup_lname');
    }
    if($("#telephone_no").val().length == 0){
        error.push('telephone_no');
    }
    if(!$.isNumeric($("#telephone_no").val())){
        error.push('telephone_no');
    }
    if($("#university_name").val().length == 0){
        error.push('university_name');
    }
    if($("#major_in").val().length == 0){
        error.push('major_in');
    }
        /*console.log(error);
        console.log(error.length);*/

        if(error.length>0){
            $("#signup-error-photo").hide();
            $("#signup-error").show();
            return false;
        }else{
            if($("#profile_pic_path").val().length == 0){
                $("#signup-error").hide();
                $("#signup-error-photo").show();
                return false;
            }else{
                $("#signup-error").hide();
                $("#signup-error-photo").hide();
                jQuery('#frm_signup').submit();
            }
            
        }
      
    })






    var validator_signup = $('#frm_signup').validate({
        rules: {
            /*'signup_password': {
                required: true,
                minlength: 3
            },
            'signup_email': {
                required: true,
                minlength: 6,
                email: true
            },
            'signup_fname': {
                required: true,
                minlength: 2
            },
            'signup_lname': {
                required: true,
                minlength: 2
            },
            'telephone_no': {
                required: true,
                minlength: 2
            },
            'university_name': {
                required: true,
                minlength: 2
            },
            'major_in': {
                required: true,
                minlength: 2
            }*/

        },
        submitHandler: function(form) {

            jQuery("#div_signupmsg").html("<img src='" + jQuery("#hdn_siteurl").val() + "/wp-content/themes/minyawns/images/ajax-loader.gif' width='50' height='50' class='img-center'/>");
            jQuery.post(ajaxurl, {
                action: 'popup_usersignup',
                //data :  data 
                pdemail_: jQuery("#signup_email").val(),
                pdpass_: jQuery("#signup_password").val(),
                pdfname_: jQuery("#signup_fname").val(),
                pdlname_: jQuery("#signup_lname").val(),
                pdcompany_: jQuery("#signup_company").val(),
                pdrole_: jQuery("#signup_role").val(),
                min_telephone_: jQuery("#telephone_no").val(),
                min_university_: jQuery("#university_name").val(),
                min_major_: jQuery("#major_in").val(),
                profile_pic_path: jQuery("#profile_pic_path").val(),
                profile_image_id: jQuery("#profile_image_id").val()
            },
            function(response) {
                console.log(response);
                if (response.success == true)
                {
                    jQuery("#div_signupmsg").html(response.msg);
                    jQuery("#signup_email").val("");
                    jQuery("#signup_password").val("");
                    jQuery("#signup_fname").val("");
                    jQuery("#signup_lname").val("");

                    jQuery("#profile_pic_path").val("");
                    jQuery("#profile_image_id").val("");
                    jQuery("#telephone_no").val("");
                    jQuery("#university_name").val("");
                    jQuery("#major_in").val("");
                    
                    window.location.href = SITEURL+'/profile/';
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

    // biz popup
    jQuery(document.body).on('click', '#btn_signup-biz', function(e) {   
        jQuery('#frm_signup-biz').submit();
    })

    var validator_signup = $('#frm_signup-biz').validate({
        rules: {
            'signup_password': {
                required: true,
                minlength: 3
            },
            'signup_email': {
                required: true,
                minlength: 6,
                email: true
            },
            'signup_fname': {
                required: true,
                minlength: 2
            },
            'signup_lname': {
                required: true,
                minlength: 2
            }

        },
        submitHandler: function(form) {

            jQuery("#div_signupmsg").html("<img src='" + jQuery("#hdn_siteurl").val() + "/wp-content/themes/minyawns/images/ajax-loader.gif' width='50' height='50' class='img-center'/>");
            jQuery.post(ajaxurl, {
                action: 'popup_usersignup',
                //data :  data 
                pdemail_: jQuery("#signup_email").val(),
                pdpass_: jQuery("#signup_password").val(),
                pdfname_: jQuery("#signup_fname").val(),
                pdlname_: jQuery("#signup_lname").val(),
                pdcompany_: jQuery("#signup_company").val(),
                pdrole_: jQuery("#signup_role").val()
            },
            function(response) {
                console.log(response);
                if (response.success == true)
                {
                    jQuery("#div_signupmsg").html(response.msg);
                    jQuery("#signup_email").val("");
                    jQuery("#signup_password").val("");
                    jQuery("#signup_fname").val("");
                    jQuery("#signup_lname").val("");
                    window.location.href = SITEURL+'/profile/';
                }
                else
                {
                    jQuery("#div_signupmsg").html(response.msg);
                }
            })
            return false;
        }

    });
    // biz popup ends

$(document.body).on('click', '.edit-job-data', function(e) {   

        e.preventDefault();

        var span1 = $('.job-view-list');
        var span2 = $('#edit-job-form');
        var w = $(span1).width();
        if ($(this).hasClass('view'))
        {

            $("#delete_jobs_link").hide();
            $(span1).animate({left: 0}, 500);
            $(span2).show().animate({left: w + 400}, 500);
            $(".job-view-list").show();
            if ($(".alert-error").length > 0)
                $(".alert-error").show();
        }
        else
        {
            $(".job-view-list").hide();
            $("#delete_jobs_link").show();
            $(".alert-error").hide();
            $('#edit-job-form').find('div.alert').remove();
            $(span1).animate({left: -2 * w}, 500);
            $(span2).css({'left': w, 'top': '60px'});
            $(span2).show().animate({left: 0}, 500);
            if ($(".edit").attr("is-job-paid") == 1)
            {
                $("#edit-job-form").prepend("<div class='alert alert-error'>This job is paid and cannot be edited.</div>");
                $("#edit-job-form").find('input, textarea, button, select').attr('disabled', 'disabled');
                return;
            }
        }
    });
    $('#update-job').click(function(e) {

        e.preventDefault();
        _this = $(this);
        //remove previuous errors
        $('#job-form').find('span.form-error').remove();
        //attach it to global window so we can use it later to update the main profile view
        window.job = new Job();
        window.job.bind('invalid', function(model, error, options) {

            _.each(error, function(ele, index) {

                $('#' + ele.field).closest('div.controls').append('<br/><span class="form-error">' + ele.msg + '</span>');
            })
        });
        var data = $("#job-form").serializeArray();
        $(this).attr('disabled', 'disabled');
        var job_data = {};
        _.each(data, function(ele, index) {
            job_data[ele.name] = ele.value;
        });
        window.job.save(job_data,
                {
                    wait: true,
                    success: function(model, resp) {

                        var data = model.toJSON();
                        $('html, body').animate({scrollTop: '0px'}, 300);
// alert(data.job_task);
//remove success
                        _.pluck(data, 'success');
                        window.location.reload();
                        //   load_browse_jobs(model.toJSON().post_id, 'single_job');
//                        if (data.job_task === undefined)
//                        {
//                            data.job_task = '';
//                        }
//                        if (data.job_task !== undefined) {
//                            $('#single-jobs').find('a').html(data.job_task);
//                        }
//
//                        if (data.job_start_date !== undefined)
//                        {
//                            $('.job-date').find('span').html(data.job_start_date);
//                        }
//
//                        if (data.job_wages !== undefined)
//                        {
//                            $(".wages").html("$" + data.amount);
//
//                        }
//                       
//                       
//                         var jsDate = new Date(data.job_start_time);
//                         var jsendDate=new Date(data.job_end_time);
//                         alert(data.job_start_time);alert(data.job_end_time);
//                         if (data.job_start_time !== undefined)
//                         {
//                         
//                         }
//                         if (data.job_end_time !== undefined)
//                         {
//                         
//                         } 
//                        if (data.job_details !== undefined)
//                        {
//                            $(".jobdesc").find('div').html(data.job_details);
//                        }
//                        if (data.job_location != undefined)
//                        {
//                            $(".joblocation").html(data.job_location);
//                        }
//
//                        $("#success_msg").show();
//                        $("#ajax-load").hide();
//                        //get model data
//                        // $(_this).removeAttr('disabled');
//                        e.preventDefault();
//                        var span1 = $('.singlejobedit');
//                        var span2 = $('#edit-job-form');
//                        var w = $(span1).width();
//                        if (!$(this).hasClass('loaded'))
//                        {
//                            if ($(this).hasClass('view'))
//                            {
//
//                                $(span1).animate({left: 0}, 500);
//                                $(span2).show().animate({left: w}, 500);
//                                //$('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a>');
//                            }
//                            else
//                            {
//
//                                $(this).removeClass('loaded');
//                                $('#edit-job-form').find('div.alert').remove();
//                                $(span1).show().animate({left: 0}, 500);
//                                $(span2).css({'left': w, 'top': 0});
//                                $(span2).hide().animate({left: 0}, 500);
//                                //$('#bread-crumbs-id').html('<a href="#" class="view edit-user-profile">My Profile</a> Edit');
//                            }
//                        }
////$("#add-job-form").find('input:text').val('');

                    },
                    errors: function() {
                        $(_this).removeAttr('disabled');
                        alert('Error!!! Please try again');
                    }
                });
    });
 
 




//Single job page apply click action 
jQuery(document.body).on('click', '#apply-job-browse', function(evt) {

    var _this = $(this);
    var _action = $(this).attr('data-action');
    var _job_id = $(this).attr('data-job-id');
    if(_action == "apply"){

        if(profile_completed == 'yes'){

            if($("#apply-job-popup").length==0){
                $( "body" ).append(appy_job_popup_content(_job_id));
            }
            $("#apply-job-popup").modal('show');

        }else{

            if($("#incomplete-profile-popup").length==0){
             $( "body" ).append(incomplete_minion_profile_popup());
         }
         $("#incomplete-profile-popup").modal('show');

     }
 }

 evt.preventDefault();
});





//apply job popup apply click action
  jQuery(document.body).on('click', '#apply-job-final', function(evt) {
 

var _this = $(this);
    var _action = $(this).attr('data-action');
    var _job_id = $(this).attr('data-job-id');

        evt.preventDefault();
       

        $(this).append(' <img src="' + siteurl + '/wp-content/themes/minyawns/images/2.gif" width="10" height="10"/>')
        $(".load_ajax1").show();
        $(".load_ajax3").show();


    $.post(ajaxurl,
                {
                    action: 'minyawn_job_' + _action,
                    job_id: parseInt(_job_id)
                },
        function(response) {

            if (window.page === '1') 
                window.location.reload();


            load_browse_jobs(_job_id, 'single_json');
            $(".load_ajax1").hide();

            if (response.new_action == 'unapply')
            {
                $(_this).removeClass('btn btn-primary').addClass('btn btn-danger').attr('id', 'unapply-job').text('Unapply');
                $(_this).attr('data-action', 'unapply');
            }

        }, 'json');

});








 
    /** Apply/UnApply code */
    jQuery(document.body).on('click', '#unapply-job', function(evt) {
 

        var _this = $(this);
        var _action = $(this).attr('data-action');
        var _job_id = $(this).attr('data-job-id');
 
        if(_action == "apply"){
            
            if($("#apply-job-popup").length==0){

                 $( "body" ).append(appy_job_popup_content())

            }
           
            $("#apply-job-popup").modal('show'); 
        }

        evt.preventDefault();
       

        $(this).append(' <img src="' + siteurl + '/wp-content/themes/minyawns/images/2.gif" width="10" height="10"/>')
        $(".load_ajax1").show();
        $(".load_ajax3").show();

        $.post(ajaxurl,
                {
                    action: 'minyawn_job_' + _action,
                    job_id: parseInt(_job_id)
                },
        function(response) {

            if (window.page === '1') //single job page reload to get new minion data
                window.location.reload();


            load_browse_jobs(_job_id, 'single_json');/*appends a single row to the table*/
            $(".load_ajax1").hide();


            if (response.new_action == 'apply')
            {
                $(_this).removeClass('btn btn-danger').addClass('btn btn-primary').attr('id', 'apply-job-browse').text('Apply');
                $(_this).attr('data-action', 'apply');
            }
            if (response.new_action == 'unapply')
            {
                $(_this).removeClass('btn btn-primary').addClass('btn btn-danger').attr('id', 'unapply-job').text('Unapply');
                $(_this).attr('data-action', 'unapply');
            }


        }, 'json');
    });

    function appy_job_popup_content(_job_id){

        html  = '<div id="apply-job-popup" class="modal hide fade cust-modal apply-modal-dwn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'
      
        html += '<div class="modal-body cust-modal-body">'

        html += '<div class="warning-content">'

        html += '<img src="'+warning_image.src +'" class="modal-img">'

        html += '</div>'
         
        html += '</div>'
		
		html += '<div class="popup-apply-btn-cont text-center">'

        html += '<a href="#" id="apply-job-final" class="btn btn-primary" data-action="apply" data-job-id="'+_job_id+'">Apply</a>'

        html += '</div>'
      
        html += '</div>';

        return html;
    }






    function incomplete_minion_profile_popup(){

        html  = '<div id="incomplete-profile-popup" class="modal hide fade cust-modal apply-modal-dwn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'
      
        html += '<div class="warning-content">'

        html += '<img src="'+THEMEURL +'/images/incomplete_profile.jpg" class="modal-img">'

        html += '</div>'
         
        html += '</div>';

        return html;
    }





    function onload_calendar()
    {

        var view = "month";
        var DATA_FEED_URL = SITEURL + '/wp-content/themes/minyawns/libs/job.php/fetchjobscalendar';
        var op = {
            view: view,
            theme: 3,
            showday: new Date(),
            EditCmdhandler: Edit,
            DeleteCmdhandler: Delete,
            ViewCmdhandler: View,
            onWeekOrMonthToDay: wtd,
            onBeforeRequestData: cal_beforerequest,
            onAfterRequestData: cal_afterrequest,
            onRequestDataError: cal_onerror,
            autoload: true,
            url: DATA_FEED_URL + "?calendar=true&offset=0",
            //quickAddUrl: DATA_FEED_URL + "?method=add",
            // quickUpdateUrl: DATA_FEED_URL + "?method=update",
            //quickDeleteUrl: DATA_FEED_URL + "?method=remove"
        };
        var $dv = $("#calhead");
        var _MH = document.documentElement.clientHeight;
        var dvH = $dv.height() + 2;
        op.height = _MH - dvH;
        op.eventItems = [];
        var p = jQuery("#gridcontainer").bcalendar(op).BcalGetOp();
        if (p && p.datestrshow) {
            $("#txtdatetimeshow").text(p.datestrshow);
        }

        jQuery("#caltoolbar").noSelect();
        $("#hdtxtshow").datepicker({picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn: function(r) {
                var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            }
        });
        function cal_beforerequest(type)
        {
            var t = "Loading data...";
            switch (type)
            {
                case 1:
                    t = "Loading data...";
                    break;
                case 2:
                case 3:
                case 4:
                    t = "The request is being processed ...";
                    break;
            }
            $("#errorpannel").hide();
            $("#loadingpannel").html(t).show();
            $("#loader_ajax_calendar").hide();
        }
        function cal_afterrequest(type)
        {
            switch (type)
            {
                case 1:
                    $("#loadingpannel").hide();
                    break;
                case 2:
                case 3:
                case 4:
                    $("#loadingpannel").html("Success!");
                    window.setTimeout(function() {
                        $("#loadingpannel").hide();
                    }, 2000);
                    break;
            }

        }
        function cal_onerror(type, data)
        {
            $("#errorpannel").show();
        }
        function Edit(data)
        {
            var eurl = "edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";
            if (data)
            {
                var url = StrFormat(eurl, data);
                OpenModelWindow(url, {width: 600, height: 400, caption: "Manage  The Calendar", onclose: function() {
                        $("#gridcontainer").reload();
                    }});
            }
        }
        function View(data)
        {
            var str = "";
            $.each(data, function(i, item) {
                str += "[" + i + "]: " + item + "\n";
            });
            alert(str);
        }
        function Delete(data, callback)
        {

            $.alerts.okButton = "Ok";
            $.alerts.cancelButton = "Cancel";
            hiConfirm("Are You Sure to Delete this Event", 'Confirm', function(r) {
                r && callback(0);
            });
        }
        function wtd(p)
        {
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar div.fcurrent").each(function() {
                $(this).removeClass("fcurrent");
            })
            $("#showdaybtn").addClass("fcurrent");
        }
//to show day view
        $("#showdaybtn").click(function(e) {
//document.location.href="#day";
            $("#caltoolbar div.fcurrent").each(function() {
                $(this).removeClass("fcurrent");
            })
            $(this).addClass("fcurrent");
            var p = jQuery("#gridcontainer").swtichView("day").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });
        //to show week view
        $("#showweekbtn").click(function(e) {
//document.location.href="#week";
            $("#caltoolbar div.fcurrent").each(function() {
                $(this).removeClass("fcurrent");
            })
            $(this).addClass("fcurrent");
            var p = jQuery("#gridcontainer").swtichView("week").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }

        });
        //to show month view
        $("#showmonthbtn").click(function(e) {
//document.location.href="#month";
            $("#caltoolbar div.fcurrent").each(function() {
                $(this).removeClass("fcurrent");
            })
            $(this).addClass("fcurrent");
            var p = jQuery("#gridcontainer").swtichView("month").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });
        $("#showreflashbtn").click(function(e) {
            jQuery("#gridcontainer").reload();
        });
        //Add a new event
        $("#faddbtn").click(function(e) {
            var url = "edit.html";
            OpenModelWindow(url, {width: 500, height: 400, caption: "Create New Calendar"});
        });
        //go to today
        $("#showtodaybtn").click(function(e) {
            var p = jQuery("#gridcontainer").gotoDate().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }


        });
        //previous date range
        $("#sfprevbtn").click(function(e) {

            var p = jQuery("#gridcontainer").previousRange().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }

        });
        //next date range
        $("#sfnextbtn").click(function(e) {
            var p = jQuery("#gridcontainer").nextRange().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });


$(document.body).on('show', '.collapse', function() {    
            $(this).parent().find('a').addClass('open'); //add active state to button on open
        });

$(document.body).on('hide', '.collapse', function() {     
            $(this).parent().find('a').removeClass('open'); //remove active state to button on close
        });
    }




$(document.body).on('click', '#show-calendar', function(e) {  
        onload_calendar(); /*load the calendar*/
        $("#calendar-jobs").show();
        $("#show-calendar").hide();
        $("#hide-calendar").show();

        var span1 = $('.browse-jobs-table');
        var span2 = $('#calendar');
        var w = $(span1).width();

        $(".browse-jobs-table").hide('slow', function() {
            $('#calendar').show();
        });

    });

//    $('input:checkbox').click(function() {
//        if ($(this).is(':checked')) {
//            $('input:checkbox').not(this).prop('checked', false);
//        }
//       
//        $(this).attr("checked", "checked");
//    });


    function remove(array, to_remove)
    {
        var elements = array.split(",");
        var remove_index = elements.indexOf(to_remove);
        elements.splice(remove_index, 1);
        var result = elements.join(",");
        return result;
    }

 
    $(document.body).on('click', '.onoffswitch', function(e) {



        var user_id = $("#" + $(this).attr('id')).find(':checkbox').attr('data-user-id');
        var group_id = $("#minyawn_id").val();

        if ($("#" + $(this).attr('id')).find(':checkbox').is(':checked')) {
            $("#" + $(this).attr('id')).find(':checkbox').not(this).prop('checked', false);

            $("." + $(this).attr('id')).removeClass("Select-minyawns");


            var explode = remove(group_id, user_id);

            no_of_minyawns = no_of_minyawns - 1;


            $("#minyawn_id").val(explode);
            $("#paypal_pay").show();
            $("#selection_message").hide();

            if (no_of_minyawns == 0) {
                $("#wages_per_minyawns").html("0");
                $("#paypal_pay").hide();
                $("#selection_message").show();
            }

            paypal_form_values(no_of_minyawns);

        } else {
            //$("#hidden_selected_min").append(1);

            $("#" + $(this).attr('id')).find(':checkbox').prop("checked", "checked");
            $("." + $(this).attr('id')).addClass("Select-minyawns");

            $("#paypal_pay").show();
            $("#selection_message").hide();
            //no_of_minyawns = no_of_minyawns + 1;
            no_of_minyawns = no_of_minyawns + 1;

            group_id += user_id + ',';

            $("#minyawn_id").val(group_id);
            var cart = $('#imgselect');
            var imgtodrag = $(this).closest('.thumbspan').find('img').eq(0);
            console.log(imgtodrag);
            if (imgtodrag) {
                var imgclone = imgtodrag.clone()
                        .offset({
                    top: imgtodrag.offset().top,
                    left: imgtodrag.offset().left
                })
                        .css({
                    'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
                })
                        .appendTo($('body'))
                        .animate({
                    'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
                }, 1000, 'easeInOutExpo');

                setTimeout(function() {
                    cart.effect("shake", {
                        times: 2
                    }, 200);
                }, 1500);

                imgclone.animate({
                    'width': 0,
                    'height': 0
                }, function() {
                    paypal_form_values(no_of_minyawns);
                    $(this).detach()
                });
            }





        }


//        if (!$('#paypal_form input[type="checkbox"]').is(':checked')) {
//
//            $("#div_confirmhire").html("");//alert("Please select atleast one minyawn to proceed.");
//
//        }
//        else
//        {
//
//            $("#div_confirmhire").html($("#confirm-hire").html());//alert("checked atleast once")
//
//
//        }

    });
$(document.body).on('click', '#hide-calendar', function(e) {   
        var c = 0;
        $("#calendar-jobs").hide();

        $("#show-calendar").show();
        $("#hide-calendar").hide();
        var span1 = $('.browse-jobs-table');
        var span2 = $('#calendar');
        var w = $(span1).width();
        $("#calendar").hide('slow', function() {
            $('.browse-jobs-table').show();
        });
    });

$(document.body).on('click', '#confirm-hire-button', function(evt) {    

        evt.preventDefault();
        var _job_id;
        var group_ids = "";
        var user_id = "";
        var sList = "";
        var no_of_minyawns = 0;
        var _user_id = $(this).attr('data-user-id');
        $('input[name=confirm-miny\\[\\]]:checked').each(function() {
            user_id = $(this).attr('data-user-id');
            _job_id = $(this).attr('data-job-id');
            // var status=$(this).prop("checked","checked");
            sList += "" + $(this).attr('data-user-id') + "," + (this.checked ? "hired" : "applied") + "-";
            //alert(sList);
            //alert(_job_id);
            group_ids += user_id + ',';

            $("#hire-thumb" + user_id).addClass('minyans-select');
            no_of_minyawns = no_of_minyawns + 1;

        });
        if (no_of_minyawns === 0)
        {
            $("#requiredminyawnerror").modal('show')
        } else
        {

            $("#hdn_jobwages").val($("#job_wages").val());
            $("#no_of_minyawns").html(no_of_minyawns);
            $("#wages_per_minyawns").html($("#job_wages").val());
            var total = no_of_minyawns * $("#job_wages").val();
            $("#total_wages").html(total.toFixed(2));
            $.post(SITEURL + '/wp-content/themes/minyawns/libs/job.php/confirm',
                    {
                        user_id: group_ids,
                        job_id: _job_id,
                        status: sList,
                        returnUrl: $("#returnUrl").val(),
                        cancelUrl: $("#cancelUrl").val(),
                        notify_url: $("#notify_url").val(),
                        currencyCode: $("#currencyCode").val(),
                        jobwages: total
                    },
            function(response) {
                $(".load_ajaxconfirm").hide();
                console.log(response);
                $("#paypal_pay").html(response.content);


                $(".load_ajax4").hide();
            }, 'json');
            $("#confirminyawn").modal('show');
            $("#paypal-loader").hide();
        }

    });



$(document.body).on('click', '.well-done,.terrible', function(evt) { 
//alert('.well-done,.terrible')

        if (evt.target.id === 'vote-up' + $(this).attr('user_id')) {
            $("#vote-up" + $(this).attr('user_id')).css("opacity", "1");
            $("#vote-down" + $(this).attr('user_id')).css("opacity", "0.4");
           // $("#review" + $(this).attr('user_id')).attr("action", evt.target.id);
            $("#review" + $(this).attr('user_id')).attr("action", $(evt.target).attr('action'));
            $("#review" + $(this).attr('user_id')).attr("vote", "1");
            //$("#review-text" + $(this).attr('user_id')).removeClass();
            // $("#review-text" + $(this).attr('user_id')).addClass("welldone-textarea");
        } else {
            $("#vote-down" + $(this).attr('user_id')).css("opacity", "1");
            $("#vote-up" + $(this).attr('user_id')).css("opacity", "0.4");
            //$("#review" + $(this).attr('user_id')).attr("action", evt.target.id);
            $("#review" + $(this).attr('user_id')).attr("action", $(evt.target).attr('action'));
            $("#review" + $(this).attr('user_id')).attr("vote", "-1");
            // $("#review-text" + $(this).attr('user_id')).removeClass();
            // $("#review-text" + $(this).attr('user_id')).addClass("terrible-textarea");
        }

        $("#review-box" + $(this).attr('user_id')).show();
        // $("#thumbnail-" + $(this).attr('user_id')).css("height", '545px');


//
////$("#review"+$(this).attr('user_id')).attr("action",)
////$('.rate-positive,.rate-negative').on('click', function(evt) {
//
////        if ($(this).attr('is_rated') != "0")
////            return false;
//
//        $(".rating").find('a').prop('disabled', true);
//        // $(".load_ajaxconfirm").show();
//        //evt.preventDefault();

    });

$(document.body).on('click', '.rate-button', function() {  
    
//alert('rate button clicked');
      //  alert('rate button')

        var action = $(".rate-button").attr("action");

//
//        if (action.length === 0)
//            return false;


        var _this = $(this);
        var _rating = $(this).attr('vote');
        var _job_id = $(this).attr('job-id');
        var _user_id = $(this).attr('user-id');
        var _action = $(this).attr('action');
        var _emp_id = $(this).attr('emp_id');
        var _desc = $("#review-text" + _user_id).val();
       // $('#thumbnail-22').find('.rating').find("#thumbs_up_22").contents(':not(".icon-thumbs-up")').remove()

        $.post(SITEURL + '/wp-content/themes/minyawns/libs/job.php/user-vote',
                {
                    rating: _rating,
                    job_id: _job_id,
                    user_id: _user_id,
                    action: _action,
                    emp_id: _emp_id,
                    review: _desc


                },
        function(response) {

            $(".rating").find('a').prop('disabled', false);
           // if (response.action === "vote-up"+ _user_id) {


            $("#review-box"+_user_id).remove();
            $("#vote-down"+_user_id).remove();
            $("#vote-up"+_user_id).remove();
           // $(".asd").remove();


            $('#thumbnail-'+response.user_id).find('.rating').find("#thumbs_up_"+response.user_id).find('.thumbs_up_counts').html(response.rating);

            $('#thumbnail-'+response.user_id).find('.rating').find("#thumbs_down_"+response.user_id).find('.thumbs_down_counts').html(response.rating_negative);

            //$('.item').contents(':not(img)').remove();
         //     $('#thumbnail-'+response.user_id).find('.rating').find("#thumbs_up_"+response.user_id).contents(':not(".icon-thumbs-up")').remove();
            /*  $('#thumbnail-22').find('.rating').find("#thumbs_up_22").contents().filter(function(){
             return (this.nodeType == 3);
             }).remove();
             */

            if (response.action === "vote-up") {

                $("#thumbs_up_" + _user_id).contents().filter(function() {
                    return this.nodeType !== 1;
                }).remove();
               
//$("#"+ _user_id).empty();
              //  $("#thumbs_up_" + _user_id).append(response.rating);
               // $("#rating_container" + _user_id).empty().append("<a id='vote-upuserid' class='btn btn-small btn-block  btn-success' href='#like' is_rated='0' employer-vote='1'>Well Done</a>");
                // var desc="<div style='top: 486px;left: -17px;display: block;position: absolute;' class='popover fade bottom in'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'><div class='head'>Lorem ipsum dolor sit amet, adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet.</div></div></div>";
               $("#"+_user_id).find(".dwn-btn").remove();

                //$("#review-box"+_user_id).remove();
                //$("#vote-down"+_user_id).remove();

                $("#"+ _user_id + " .comment-div ").append("<div class='up-btn review_popover'><div class='comment-box'> <i class='icon-thumbs-up weldone'></i><p class='custom-p'>"+_desc+"</p><div></div>");
            
            }
            //if (response.action === "vote-down"+ _user_id) {
            if (response.action === "vote-down") {

                $("#thumbs_down_" + _user_id).contents().filter(function() {
                    return this.nodeType !== 1;
                }).remove();
//$("#"+ _user_id).empty();
               $("#"+_user_id).find(".dwn-btn").remove();

               //$("#review-box"+_user_id).remove();
               //$("#vote-up"+_user_id).remove();


               // $("#thumbs_down_" + _user_id).append(response.rating);
               // $("#rating_container" + _user_id).empty().append("<a id='vote-upuserid' class='btn btn-small btn-block  btn-danger terrible' href='#like' is_rated='0' employer-vote='1'>Terrible</a>");
                // var desc="<div style='top: 486px;left: -17px;display: block;position: absolute;' class='popover fade bottom in'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'><div class='head'>Lorem ipsum dolor sit amet, adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet.</div></div></div>";
                 $("#"+ _user_id + " .comment-div").append("<div class='dwn-btn review_popover'><div class='comment-box'> <i class='icon-thumbs-down terrible'></i><p class='custom-p'>"+_desc+"</p><div></div>");

            }
            //$("#thumbnail-" + _user_id).css("height", '480px');



        }, 'json');

    });

$(document.body).on('click', '#edit-selection', function(evt) {   
        $("#edit-selection").hide();
        $("#confirm-hire").show();

    });




});

function getUrlVars()
{
    var vars = [], hash;

    if (window.location.href.indexOf('?') === -1)
    {
        return false;

    } else {

        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }

        return vars;
    }
}


function validateURL(textval) {
    return /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(textval);

}
function ucfirst(str) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: ucfirst('kevin van zonneveld');
    // *     returns 1: 'Kevin van zonneveld'
    str += '';
    var f = str.charAt(0).toUpperCase();
    return f + str.substr(1);
}
(function($) {
    $('.carousel').carousel({interval: 1000, pause: 'hover'});
})(jQuery);

jQuery(document.body).on('show', '.collapse', function() {  
    jQuery(this).parent().find('a').addClass('open'); //add active state to button on open
});

jQuery(document.body).on('hide', '.collapse', function() {  
    jQuery(this).parent().find('a').removeClass('open'); //remove active state to button on close
});

jQuery(".edit-user-profile").click(function() {
    jQuery(".profile-wrapper").addClass("intro");
});


jQuery('a #edit-user-profile').click(function() {
    jQuery(this).addClass('active');
});
// jQuery( window ).load(function() {
//        jQuery(".collapse").collapse({"toggle" : "show"});
//    });

jQuery('#frm_signup').keydown(function(e) {
    if (e.keyCode === 13) { // If Enter key pressed
        jQuery('button').click();
    }
});

function load_profile(id)
{

    var url = siteurl + "/profile/" + id;
    window.open(url, '_blank');
}
$(document.body).on('show', '.collapse', function() { 
    $(this).parent().find('.data-title').addClass('open'); //add active state to button on open
});

$(document.body).on('hide', '.collapse', function() { 
    $(this).parent().find('.data-title').removeClass('open'); //remove active state to button on close
});

jQuery(document.body).on('click', '#delete_jobs_link', function() {  
    
    $("#myModal1").show();
    
//    $.post(SITEURL + '/wp-content/themes/minyawns/libs/job.php/delete-job',
//            {
//                job_id: jQuery("#delete_job").attr("job-id"),
//            },
//            function(response) {
//                window.location.href = siteurl + '/jobs';
//            });

});


jQuery(document).on('click', '#delete_job', function() {  
       $.post(SITEURL + '/wp-content/themes/minyawns/libs/job.php/delete-job',
            {
                job_id: jQuery("#delete_job").attr("job-id"),
            },
            function(response) {
                window.location.href = siteurl + '/jobs/#browse';
            }); 
    
});

function paypal_form_values(no_of_minyawns) {

    $("#hdn_jobwages").val($("#job_wages").val());
    $("#no_of_minyawns").html(no_of_minyawns);
    $("#wages_per_minyawns").html($("#job_wages").val());
    var total = no_of_minyawns * $("#job_wages").val();

    if (no_of_minyawns == 0)
        $("#wages_per_minyawns").html("0");

    $("#total_wages").html(total.toFixed(2));


    $("#amount").val(total.toFixed(2));
    $("#item_number").val($("#job_id").val());




}

jQuery(document).on('click', '#invite-minion', function() { 
jQuery("#invite_to").empty();
 jQuery("#miniondir").modal('show');
   
    var Fetchuserinvites = Backbone.Collection.extend({
        url: SITEURL + '/wp-content/themes/minyawns/libs/job.php/invitejobs'
    });
    window.fetchi = new Fetchuserinvites;
    window.fetchi.fetch({
        data: {
            user_id: jQuery(this).attr("minion-id"),
            employer_id: jQuery(this).attr("employer-id")
        },
        success: function(collection, response) {
          
            var invites = _.template(jQuery("#active_invites").html());
           
            if (collection.length > 0) {


                _.each(collection.models, function(model) {

                  var user_button=button_for_invite(model);

                var html = invites({result: model.toJSON(),button:user_button});


                    jQuery("#invite_to").append(html);
                });


            } else 
            {

               if(logged_in_role === 'Employer')
               jQuery("#invite_to").append("You do not have any open jobs to invite the minion to");
                else    
                jQuery("#invite_to").append("Please login as an employer to invite Minions");

            }
        }
    });
});


function button_for_invite(model){
    
    if(model.toJSON().job_user_status == '4'){
        var button_string="<a href='#' class='btn btn-primary invite-btn on-pop' job-id="+model.toJSON().job_id+" minyawn-id="+ model.toJSON().minyawn_id+" ><i class='icon-ok'></i>Resend Invite</a>";
    }else if(model.toJSON().job_user_status == '1'){
        var button_string="<span class='applied'>Already Applied</span>";
    }else {
         var button_string="<a href='#' class='btn btn-primary invite-btn on-pop' job-id="+model.toJSON().job_id+" minyawn-id="+ model.toJSON().minyawn_id+" ><i class='icon-ok'></i>Invite</a>";
    }
    
    return button_string;
    
}
 
$(document).on('click', '.show-minyawn', function(e) {   
    if(jQuery(e.target).attr('href') || jQuery(e.target).parent().attr('href')  ) {
    return;
  }
       window.open(SITEURL+'/profile/'+jQuery(e.target).closest( "li").attr('item-id')+'/','_target') 
    
}); 

function toProperCase(str) { 
        var noCaps = ['of','a','the','and','an','am','or','nor','but','is','if','then', 
                      'else','when','at','from','by','on','off','for','in','out','to','into','with'];
        return str.replace(/\w\S*/g, function(txt, offset){
            if(offset != 0 && noCaps.indexOf(txt.toLowerCase()) != -1){
                return txt.toLowerCase();    
            }
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    }
 function check_capability (user_cap) { 
 
        ret_val = false; 
        jQuery.each(USER.all_caps, function(i, val) {
             
 
            if( user_cap==val)
            {
 
                capability_name =  val.replace(/_/g,' ');
                capability_name =  toProperCase(capability_name);
                ret_val = capability_name.replace(/Ph /g,'');
 
                return false;

            }

        }); 
        return ret_val;
    }


    //isotope
function set_isotope(){
            jQuery('.isotope').imagesLoaded( function(){
jQuery('.isotope').isotope({
itemSelector: '.item',
masonry: {
columnWidth: '.grid-sizer'
}
});
});
}
//jQuery(document).ready(function() {
//   	jQuery('#example').popover(
//				{
//					placement : 'bottom',
//					html : true,
//					trigger : 'hover',
//					content : '<div id="profile-data" class="verfied-content">We personally verify Minion profiles to help you be sure that they are who they claim to be and they are safe to do business with. Minions with out Verified status have yet to go through the personal verification process</div>',
//				}
//			);
//		});
 
 


//fancybox
jQuery(function($) {
$(".fancybox").fancybox();
});
 

jQuery(function($) {
  $("#me").hide();
  $("#hide").click(function(){
      $("#me").toggle();
      $(this).text(function(i, val) {
          return val === '(Hide information)' ? '(show Information)' : '(Hide information)';
      });
  });
  $('#element').tooltip('toggle')
 $('#element1').tooltip('toggle')
   $('#element3').tooltip('toggle')
   $('#element4').tooltip('toggle')
  $(window).scroll(function(){
      if ($(this).scrollTop() > 120) {
          $('.job-view').addClass('fixed');
      } else {
          $('.job-view').removeClass('fixed');
      }
});










//Validate US phone number
$.fn.usphone = function() 
  {
    this.keyup(function() 
    {
     var curchrindex = this.value.length;
     var curval = $(this).val();
     var strvalidchars = "0123456789()-";
          
     for (i =0; i < this.value.length; i++)
     {
      var curchar = curval[i];
      if (strvalidchars.indexOf(curchar) == -1) 
      {
       //delete the character typed if this is not a valid character.
       $(this).val(curval.substring(0, i) + curval.substring(i+1, this.value.length));
      }
     }
     
     // Insert formatting at the right places
     if (curchrindex == 3) 
     {
      $(this).val("(" + curval + ")" + "-");
     }
     else if (curchrindex == 9)
     {
      $(this).val(curval + "-");
     }
     
     //Do not allow more than 15 characters including the brackets and the "-"
     if (curchrindex == 15) 
     {
      //delete the last character typed 
         $(this).val(curval.substring(0, this.value.length-1 ));
     }
     
    });
  };






















});






            

       













