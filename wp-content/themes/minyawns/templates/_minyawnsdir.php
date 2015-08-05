
<script type="text/template" id="minyawn-directory-card">
    <li class="span3 thumbspan show-minyawn m5li" id="minyawn<%= result.user_id %>" item-id="<%= result.user_id %>">
                           <div class="thumbnail" id="thumbnail-10">
                              <div class="m1" onclick="return true" style="display:none;">
                                 <div class="caption">
								
                                    <div class="minyawns-img">
                                      <%= result.user_avatar %>
                                      
                                      <% if(result.intro_video_id !=''){%>
                                      <a class="vidbutton"><i class="icon-youtube-play"></i> &nbsp;</a>
                                      <% } %> 

                                    </div>

                                     <% if(result.user_verified === 'Y'){%>
    <!-- <img class="verfied" src="<?php echo get_template_directory_uri(); ?>/images/verifed.png" />-->
    <div class="verfied-txt">Verified Minion</div>
    <% } %> 
                                    <h4><a href=<?php echo site_url() ?>/profile/<%= result.user_id %> target="_blank"><%= result.minion_name %></a></h4>
                                    <div class="collage"> <%= result.college %></div>
                                    <div class="social-link   profile-social-link">
                                        <% 
                                        if(result.linkedin.length > 0){

                                          var linkedin_id = result.linkedin.split('/').pop();

                                            if(linkedin_id.length > 0 && linkedin_id != 'linkedin.com'){


                                        if((result.linkedin.indexOf("http://") <= -1) && (result.linkedin.indexOf("https://") <= -1) ){
                                            var linkedinUrl = "http://"+result.linkedin;
                                        }
                                        else{
                                            var linkedinUrl = result.linkedin;
                                        }
                                        %>
                                        <a href='<%= linkedinUrl   %>' target='_blank' class="edit"><i class="icon-linkedin"></i></a>
                                         <%
                                         } }
                                          if(result.facebook_link.length > 0){

                                            var facebook_id = result.facebook_link.split('/').pop();
                                            
                                            if(facebook_id.length > 0){


                                          if((result.facebook_link.indexOf("http://") <= -1) && (result.facebook_link.indexOf("https://") <= -1) ){
                                            var facebook_linkUrl = "http://"+result.facebook_link;
                                        }
                                        else{
                                            var facebook_linkUrl = result.facebook_link;
                                        }
                                        %>
                                        <a href='<%= facebook_linkUrl   %>' target='_blank' class="edit icon-facebook-a"><i class="icon-facebook"></i></a>
                                        <% } } %>
                                    </div>
									<div class="m1-invite">
									<a class="btn btn-primary invite-btn" href= "javascript:void(0)" id="invite-minion" minion-id="<%= result.user_id %>" employer-id=<?php echo get_current_user_id() ?>>
												   <i class="icon-ok"></i>
												 Invite Minion
												   </a>	
									</div>
                                    <div class="rating">
                                       <a href="#fakelink" id="thumbs_up_10">
                                       <i class="icon-thumbs-up"></i><%= result.rating_positive %>
                                       </a>
                                       <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                                       <i class="icon-thumbs-down"></i> <%= result.rating_negative %>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <div class="m7" style="display:block;">
                                 <div class="caption">
								 <div class="row-fluid"><!--p-row-fluid starts-->
								 <div class="span4"><!--span4 starts-->
                                    <div class="minyawns-img">
                                    <%= result.user_avatar %>

                                     <% if(result.intro_video_id !=''){%>
                                      <a class="vidbutton vid-btn" href="#introvideo<%= result.user_id %>" data-toggle="modal"><i class="icon-youtube-play"></i></a>
                                      <% } %> 

                                    </div>
                            <% if(result.user_verified === 'Y'){%>
        <div class="verfied-txt-1">Verified Minion</div>
    <% } %> 
                                    <div class="rating">
                                       <a href="#fakelink" id="thumbs_up_10">
                                       <i class="icon-thumbs-up"></i> <%= result.rating_positive %>
                                       </a>
                                       <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                                       <i class="icon-thumbs-down"></i><%= result.rating_negative %>
                                       </a>
                                    </div>
									</div><!--span4 ends-->
									<div class="span8 text-left"><!--span8 starts-->
									<div class="row-fluid">
									<div class="span8"><!--span9 starts-->
                                    <h4><a href=<?php echo site_url() ?>/profile/<%= result.user_id %> target="_blank"><%= result.minion_name %></a></h4>
                                    <div class="collage"><%= result.college %></div>
                                    <div class="collage major"><%= result.major %></div>

                                    <% if (is_logged_in === '1'){ %>
                                      <div class="social-link">
                                       <%= result.user_email %>
                                    </div>
                                      <%}%>

									

                                    
									<a class="" id="invite-minion"  href= "javascript:void(0)" minion-id="<%= result.user_id %>" employer-id=<?php echo get_current_user_id() ?>>
												   <i class="icon-ok"></i>
												 Invite Minion
												   </a>
									</div><!--span9 ends-->
									
									<div class="span4"><!--span3 starts-->
                                    <div class="social-link  profile-social-link">
                                     <% if (result.linkedin.length > 0 ){
                                      var linkedin_id = result.linkedin.split('/').pop();

                                            if(linkedin_id.length > 0 && linkedin_id != 'linkedin.com'){

                                      %>
                                        <% if(  (result.linkedin.indexOf("https://") <= -1) &&   (result.linkedin.indexOf("http://") <= -1) ) {
                                            var linkedinUrl = "http://"+result.linkedin;
                                        }
                                        else{
                                            var linkedinUrl = result.linkedin;
                                        }
                                        %>
                                        <a href='<%= linkedinUrl   %>' target='_blank' class="edit"><i class="icon-linkedin"></i></a> 
                                       <%} } %>
                                      <% if (result.facebook_link.length > 0 ){
                                          var facebook_id = result.facebook_link.split('/').pop();

                                            if(facebook_id.length > 0){

                                        %>
                                        <% if(  (result.facebook_link.indexOf("https://") <= -1) &&   (result.facebook_link.indexOf("http://") <= -1) ) {
                                            var facebook_linkUrl = "http://"+result.facebook_link;
                                        }
                                        else{
                                            var facebook_linkUrl = result.facebook_link;
                                        }
                                        %>
                                        <a href='<%= facebook_linkUrl   %>' target='_blank' class="edit icon-facebook-a"><i class="icon-facebook"></i></a> 
                                       <%} } %>
                                      </div>
									  </div><!--span3 ends-->
									  </div>
									  <div class="row-fluid"><!--c-row-fluid starts-->
									  <div class="span12"><!--span12 starts-->

                    <!--ratings-->
                    <div class="row-fluid">
                      <div class="min-job-details min-dir">
                        <div class="span4">
                          <div class="jobs-completed">
                            <div class="job-no"><?php echo get_user_completed_job(); ?></div>
                            <div class="job-status">Completed</div>
                            <p>Jobs</p>
                          </div>
                        </div>
                        <div class="span4">
                          <div class="time-warp">
                            <div class="time-circle"><?php echo get_user_punctuality_percent(); ?></div>
                            <p>On time</p>
                          </div>

                        </div>
                        <div class="span4">
                          <div class="missed-job">
                            <div class="missed-job-no">
                              <?php echo get_user_missed_job(); ?>
                            </div>
                            <p>Missed Job</p>
                          </div>

                        </div>
                      </div>
                    </div>
                    <!--/ratings-->
									  <div class="tags">
                                     <% var sk=result.skills.split(',');
                                     if(result.skills.length > 0){ %>
                                       Tags:<br> 
                                      <% for(i=0;i<sk.length;i++){ %> <span class="label"><%= sk[i] %></span><%}%></li>
                                      <% } else {%>
                                      
                                      <%}%>
                                      </div>
									  </div><!--span12 ends-->
									  </div><!--c-row-fluid ends-->
									  
                                    <!--<div class="social-link">
                                       <%= result.user_email %>
                                    </div>
					<a class="btn btn-primary invite-btn" id="invite-minion"  href= "javascript:void(0)" minion-id="<%= result.user_id %>" employer-id=<?php echo get_current_user_id() ?>>
												   <i class="icon-ok"></i>
												 Invite Minion
												   </a>			
                                    <div class="tags">
                                     <% var sk=result.skills.split(',');
                                     if(result.skills.length > 0){ %>
                                       Tags:<br> 
                                      <% for(i=0;i<sk.length;i++){ %> <span class="label"><%= sk[i] %></span><%}%></li>
                                      <% } else {%>
                                      
                                      <%}%>
                                      </div>-->
                                 </div><!--span8 ends-->
                              </div><!--p-row-fluid ends-->
                           </div>
                        </li>




<% if(result.intro_video_id !=''){%>
<div id="introvideo<%= result.user_id %>" class="modal hide fade video-pop in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-body">
            <iframe id="videowrap" frameborder="0" allowfullscreen="1" title="YouTube video player" width="530" height="350" src="https://www.youtube.com/embed/<%= result.intro_video_id %>?enablejsapi=1&origin=<?php echo $_SERVER['HTTP_HOST']; ?>"></iframe>
            </div>
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
           
    </div>
 <%}%>




</script>    

<script type="text/template" id="load-more">
     <button class='btn' id='load_more'>Load More
     </button>   
</script>

<script type="text/templates" id="no-result-minyawn-dir">
    <div class="alert alert-info myjobs no-job ">
    <b style="text-align: center">No Minions yet ! </b>&nbsp;
    There doesn't seem to be anything here.
    </div>
</script>


<script type="text/templates" id="no-result-verfied-minyawn-dir">
    <div class="alert alert-info myjobs no-job ">
    <b style="text-align: center">No Minions Verified yet ! </b>&nbsp;
    There doesn't seem to be anything here.
    </div>
</script>


<script type="text/templates" id="no-more-results-pagination">
    <div class="alert alert-info myjobs no-job ">
    <b style="text-align: center">No More Results ! </b>&nbsp;
   
    </div>
</script>


<script type="text/templates" id="loader-image">
 <span class='load_ajax_large'"></span>
</script>

<script type="text/templates" id="filters-loader-image">
 <span class='modal_ajax_large_filter' id="filters-loader"></span>
</script>

<script type="text/templates" id="active_invites">
    <tr class="active" id="row-<%= result.job_id%>">
            <td class="td-job-title"><%= result.job_title%></td>
            <td class="sm-font"><%= result.job_start_date%></td>
            <td>
			<span id="loader<%= result.job_id%>" class="load_ajax" style="display:none"></span>
			<%= button %>
			
			</td>
          </tr>
    </script>


