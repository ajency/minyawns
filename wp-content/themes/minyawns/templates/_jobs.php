<script type="text/template" id="jobs-table">   
      <li class="_li job-open">
                              <div class="row-fluid">
                                 <div class="span9 ">
                                    <div class="row-fluid bdr-gray">
                                      <div class="span12 job-details">
                                          <div class="job-title">
                                             <h5><a href=<?php echo site_url() ?>/job/<%= result.post_slug %> target="_blank" > <%= result.post_title %></a></h5>
                                          </div>
                                          <div class="job-meta">
                                             <ul class="inline">
                                                <li><i class="icon-calendar"></i><%= result.job_start_day %> <%= result.job_start_month %>, <%= result.job_start_year %></li>
                                                <li><i class="icon-time"></i> <%= result.job_start_time %> &nbsp;<%= result.job_start_meridiem %> to <%= result.job_end_time %>  &nbsp;<%= result.job_end_meridiem %></li>
                                                <li class="no-bdr"><i class="icon-map-marker"></i> <%= result.job_location %></li>
                                             </ul>
                                          </div>
                                          <p> <%= result.job_details %></p>
                                       </div>
                                    </div>
                                    <div class="additional-info">
                                       <div class="row-fluid">
                                          <div class="span6"><span> Category :</span><br><% for(i=0;i<result.job_categories.length;i++){ %> <span class="category-link" style="cursor: pointer; cursor: hand;" onclick="filter_categories('<%= result.job_category_ids[i] %>','<%= result.job_categories[i]%>')"><%= result.job_categories[i] %></span><%}%></div>
                                          <div class="span6"> <span> Tags :</span> <br><% for(i=0;i<result.tags.length;i++){ %> <span class="label"><%= result.tags[i] %></span><%}%></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="span3 status">
                                    <div class="st-fluid">
                                       <div class="st-moile-span1">
                                          <div class="st-wages"> wages <b>$<%= result.job_wages %></b></div>
                                       </div>
                                       <div class="st-moile-span2">
                                           <%= job_progress %>                                          
                                       </div>
                                       <div class="clear"></div>
                                    </div>
                                    <div class="st-footer">                                       
                                        
                                       <%= job_collapse_button %>
                                      
                                    </div>
                                 </div>
                              </div>
                                <form class="paypal" action="payments.php" method="post" id="paypal_form" target="_blank">

    <input type="hidden"  name="returnUrl" id="returnUrl" value="<?php echo $returnUrl; ?>" / >
    <input type="hidden" name="cancelUrl" id="cancelUrl"  value="<?php echo $cancelUrl; ?>" / >
    <input type="hidden"  name="notify_url" id="notify_url" value="<?php echo site_url() . '/paypal-payments/'; ?>" / >
    <input type='hidden' name='hdn_jobwages' id='hdn_jobwages' value='' />
    <div class="row-fluid minyawns-grid1">
	<div class="span12 ">
    <ul class="thumbnails">
    <span class='load_ajaxsingle_job_minions' style="display:none"></span>
    </ul>
	</br></br></br></br><span id="div_confirmhire"></span>
    </form>
                           </li>
</script>

<script type="text/template" id="minion-cards">


    <li class="span3" id="<%= result.user_id %>" >

    <div class="thumbnail select-button-<%= result.user_id %>" id="thumbnail-<%= result.user_id %>">
   <% if(result.is_verified === 'Y'){%>
    <img class="verfied" src="<?php echo get_template_directory_uri(); ?>/images/verifed.png" />
   <% } %> 
   <div class="m1">
   <div class="caption" >
    <div class="minyawns-img" >
    <%= result.user_image%>
    </div>
  
    <h4> <%= result.name %></h4>
    <div class="collage"> <%= result.college%> </div>
    <div class="collage"> <%= result.major%> </div>
    <div class="social-link">
    <%= result.user_email %>
    </div>
    <div class="social-link">
    <%= result.linkedin %>
    </div>
  <div class="rating">
    <a href="#fakelink" id="thumbs_up_<%= result.user_id %>">
    <i class="icon-thumbs-up" ></i> <%= result.rating_positive %>
    </a>
    <a href="#fakelink"  class="icon-thumbs" id="thumbs_down_<%= result.user_id %>">
    <i class="icon-thumbs-down" "></i> <%= result.rating_negative %>
    </a>
    </div>
   
    </div>
	</div>
	<div class="m2">
	
	   <div class="caption" >
	   <div  onclick="window.open('<?php echo site_url(); ?>/profile/<%= result.user_id %>')">
    <div class="minyawns-img" >
    <%= result.user_image%>
    </div>
    <div class="rating">
    <a href="#fakelink" id="thumbs_up_<%= result.user_id %>">
    <i class="icon-thumbs-up" ></i> <%= result.rating_positive %>
    </a>
    <a href="#fakelink"  class="icon-thumbs" id="thumbs_down_<%= result.user_id %>">
    <i class="icon-thumbs-down" "></i> <%= result.rating_negative %>
    </a>
    </div>
    <h4> <%= result.name %></h4>
    <div class="collage"> <%= result.college%> </div>
    <div class="collage"> <%= result.major%> </div>
    <div class="social-link">
    <%= result.user_email %>
    </div>
    <div class="social-link">
    <%= result.linkedin %>
    </div>
	</div>
	<div class="tags">
	Tags:<br>
    <%
    var split_skills=result.user_skills.split(',');
    for(var index=0;index<=split_skills.length;index++){
    %>
    <span class="label label-small"><%= split_skills[index] %></span>

    <% } %>
		</div>
    
    <div class="dwn-btn">
    <%= select_button %>
    <%= ratings_button %>
    <%  if(result.comment !== 0){ %>   <div class='popover fade bottom in' style='top: 30px; left: -88.0625px; display: block;'><div class='arrow'></div><div class='popover-content'> <%= result.comment %></div></div><% } %>
    </div>
    </div>
	
	</div>
    </div>

    </li>

</script>

<script type="text/template" id="confirm-hire">
    <input type="hidden" id="hidden_selected_min"/>
    <span class="load_ajaxconfirm" style="display:none"></span>
    <a  id="confirm-hire-button"  class="btn btn-medium btn-block green-btn btn-success">Confirm & Hire</a>

</script>

<script type="text/template" id="blank-card">

    <div class="row-fluid minyawns-grid">
    <ul class="thumbnails apply-job">
    <li class="span3">
    <div class="thumbnail">

    <div class="caption">
    <div class="minyawns-img">
    <img src="<?php echo get_template_directory_uri() ?>/images/profile.png">
    </div>
    <div class="rating">
    <a href="#fakelink">
    <i class="icon-thumbs-up"></i> 0
    </a>

    <a href="#fakelink" class="icon-thumbs">
    <i class="icon-thumbs-down"></i> 0
    </a>
    </div>
    <h4></h4>
    <div class="collage">"Give it a shot. Be the first to apply.</div>
    <hr>
    <div class="dwn-btn">

    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>

</script>

<script type="text/templates" id="no-result">
    <div class="alert alert-info myjobs no-job ">
    <b style="text-align: center">No Jobs Available ! </b>&nbsp;
    There doesn't seem to be anything here.
    </div>
</script>

<script type="text/templates" id="comment-popover">
    <div class='tabbable tabs-below'><ul class='nav nav-tabs'><li class='active'>
    <a href='#A' data-toggle='tab'>Well done</a></li><li class='teriblecomments'><a href='#B' data-toggle='tab'>Terrible job</a></li></ul><a class="close"  href="#">&times;</a>
    <div class='tab-content'>
    <div class='tab-pane active' id='A'>
    <ul>
    <%
    if(result.positive.length >0) {
    for(var i=0;i<result.positive.length;i++){ %>
    <li><div class='jobname'>
    <a href='#'> <%= result.positive_title[i] %></a>
    </div>
    <div class='yourcomment'><%= result.positive[i] %></div>
    <% } }else {%>
    <div class='jobname'>You don't have any ratings!</a></div>       
    <% } %>  </li>
    </ul>
    </div>
    <div class='tab-pane tariblecontent' id='B'>
    <ul>
    <% if(result.negative.length >0)
    {  for(var i=0;i<result.negative.length;i++){ %>
    <li><div class='jobname'><a href='#'><%= result.negative_title[i] %></a></div>
    <div class='yourcomment'> <%= result.negative[i] %> </div></li>
    <% }
    }else {%>
    <div class='jobname'>Congrats! You don't have any terrible ratings!</a></div>       
    <% } %>       
    </ul>
    </div></div></div>
</script>

<script type="text/template" id="sample-jobs-template">
    <li id="<%= result.post_id %>">
      <div class="row-fluid"> 
        <div class="span2">
        <i class="icon-suitcase"></i>
         </div>
              <div class="span10">
               <%= result.post_title %>
                <div class="date-meta">Posted on <%= result.job_start_day %> <%= result.job_start_month %>, <%= result.job_start_year %></div>
                 </div>
                 </div>
                <div id="hidden_values">
                <input type="hidden" class="hidden_elements" name="job_task" id="job_title" value="<%= result.post_title %>"/>
                <input type="hidden" class="hidden_elements" name="job_start_date" id="start-date" value="<%= result.job_start_date %>"/>
                <input type="hidden" class="hidden_elements" name="job_end_date" id="end-date" value="<%= result.job_end_date %>"/>
                 <input type="hidden" class="hidden_elements" name="job_start_time" id="start-time" value="<%= result.job_start_time %> <%= result.job_start_meridiem %>"/>
                 <input type="hidden" class="hidden_elements" name="job_end_time" id="start-end" value="<%= result.job_end_time %> <%= result.job_end_meridiem %>"/>
                 <input type="hidden" class="hidden_elements" name="job_required_minyawns" id="mrequired" value="<%= result.required_minyawns %>"/>
                 <input type="hidden" class="hidden_elements" name="job_wages" id="jwages" value="<%= result.job_wages %>"/>
                 <input type="hidden" class="hidden_elements" name="job_location" id="jlocation" value="<%= result.job_location %>"/>
                 <input type="hidden" class="hidden_elements" name="job_tags" id="jtags" value="<%= result.tags %>"/>
                 <input type="hidden" class="hidden_elements" name="categories" id="jcategories" value="<%= result.job_category_ids %>"/>
                 <input type="hidden" class="hidden_elements" name="job_details" id="jdesc" value="<%= result.job_details %>"/>
                </div>
                 </li>
    
</script>
        