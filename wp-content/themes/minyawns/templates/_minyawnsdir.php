
<script type="text/template" id="minyawn-directory-card">
    <li class="span3 thumbspan" id="minyawn<%= result.user_id %>">
                           <div class="thumbnail" id="thumbnail-10">
                              <div class="m1" onclick="return true">
                                 <div class="caption">
								
                                    <div class="minyawns-img">
                                      <%= result.user_avatar %>
                                    </div>
                                     <% if(result.user_verified === 'Y'){%>
    <!-- <img class="verfied" src="<?php echo get_template_directory_uri(); ?>/images/verifed.png" />-->
    <div class="verfied-txt">Verified Minion</div>
    <% } %> 
                                    <h4><a href=<?php echo site_url() ?>/profile/<%= result.user_id %> target="_blank"><%= result.minion_name %></a></h4>
                                    <div class="collage"> <%= result.college %></div>
                                    <div class="social-link">
                                      <%= result.linkedin %>
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
                              <div class="m2">
                                 <div class="caption">
                                    <div class="minyawns-img">
<%= result.user_avatar %>
                                    </div>
                                    <div class="rating">
                                       <a href="#fakelink" id="thumbs_up_10">
                                       <i class="icon-thumbs-up"></i> <%= result.rating_positive %>
                                       </a>
                                       <a href="#fakelink" class="icon-thumbs" id="thumbs_down_10">
                                       <i class="icon-thumbs-down"></i><%= result.rating_negative %>
                                       </a>
                                    </div>
                                    <h4><a href=<?php echo site_url() ?>/profile/<%= result.user_id %> target="_blank"><%= result.minion_name %></a></h4>
                                    <div class="collage"><%= result.college %></div>
                                    <div class="collage"><%= result.major %></div>
                                    <div class="social-link">
                                       <%= result.user_url %>
                                    </div>
                                    <div class="social-link">
                                       <%= result.user_email %>
                                    </div>
					<a class="btn btn-primary invite-btn" id="invite-minion" minion-id="<%= result.user_id %>" employer-id=<?php echo get_current_user_id() ?>>
												   <i class="icon-ok"></i>
												 Invite Minion
												   </a>				
                                    <div class="tags">
                                     <% var sk=result.skills.split(',');
                                     if(result.skills.length > 0){ %>
                                       Tags:<br> 
                                      <% for(i=0;i<sk.length;i++){ %> <span class="label"><%= sk[i] %></span><%}%></li>
                                      <% } else {%>
                                      No skills added yet!
                                      <%}%>
                                      </div>
                                 </div>
                              </div>
                           </div>
                        </li>   
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
    <tr class="active">
            <td class="td-job-title"><%= result.job_title%></td>
            <td class="sm-font"><%= result.job_start_date%></td>
            <td>
			<a href="#" class="btn btn-primary invite-btn" job-id=<%= result.job_id%> minyawn-id=<% result.minyawn_id %>>
			 <i class="icon-ok"></i> invite
			</a>
			
			</td>
          </tr>
    </script>


