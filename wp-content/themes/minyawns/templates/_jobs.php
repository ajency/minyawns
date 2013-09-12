<script type="text/template" id="browse-jobs-table">

    <div style="clear:both;">	</div>
    <div class="accordion-group">
    <div id="last-job-id" last-job="<%= post_id %>" value="<%= post_id %>"></div>
    <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<%= post_id %>">
    <div class="span12 data-title available">
    <div class="job-logo header-sub"> <div class="logo "><%= job_author_logo %></div></div>
    <div class="job-date header-sub">
    <span class="service-total-demand" data-count="0"><%= job_start_day %></span>
    <div>
    <%= job_start_month %><b class="service-client-demand" data-count="0"><%= job_start_year %></b>
    </div>
    <div class="demand"><%= job_day %></div>
    </div>
    <div class="job-time header-sub duration_mob">
    <div class="row-fluid">
    <div class="span5 mob-botm">
    <span data-count="0" class="total-exchange-count"><%= job_start_time %></span>
    <div>
    <%= job_start_meridiem %>
    </div>
    </div>
    <div class="span2">
    <b class="time-bold">to</b>
    </div>
    <div class="span5">
    <span data-count="0" class="total-exchange-count"><%= job_end_time %></span>
    <div>
    <%= job_end_meridiem %>
    </div>
    </div>
    </div>
    </div>

   <div class="job-wage header-sub">

    <ins><span><%= users_applied.length %></span></ins>

    </div>

    <div class="job-progress header-sub">

    <%

    if(can_apply_job == 0 && todays_date_time < job_end_time_check) %>
    <span class="label-available">Available</span>

    <%  else if(can_apply_job == 2) %>
    <span class="label-available">Requirement complete</span>

    <% else if (todays_date_time > job_end_time_check){%>
    <span class="label-unavailable">This job is complete</span>

    <% }else if (can_apply_job == 3){%>
    <span class="label-hired">You are hired for this job.</span>
    <% }else if (can_apply_job == 1) {%>
    <span class="label-available">Minions applied for this job.</span>

    <% }
    %>


    </div>

    
    <div class="job-action job-wage header-sub">
    <ins><span class="amount">$ <%= job_wages %></span>
    </div>
    </div>
    </a>
    </div>

    <div id="collapse<%= post_id %>" class="accordion-body collapse ">
    <div class="accordion-inner list-jobs">
    <div class="row-fluid header-title">
    <div class="span12">
    <h3><a href=<?php echo site_url() ?>/job/<%= post_slug %> target="_blank" > <%= post_title %> <span class="view-link"><i class="icon-search"></i> View</span></a> </h3>
    </div>
    </div>
    <div class="row-fluid job-data expand">
    <div class="span9 inner-data details">
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Requested by :</b></div><div class="span9"> <a href="<?php echo site_url() ?>/profile/<%= job_author_id%>" target="_blank" class="request_link"><%= job_author %></a>  </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Location :</b></div><div class="span9"><%= job_location %> </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Details :</b></div><div class="span9"><%= job_details.substring(0, 140) %> </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Tags :</b></div><div class="span9"> <% for(i=0;i<tags_count;i++){ %> <span class="label"><%= tags[i] %></span><%}%> </div>
    </div>
      <div class="row-fluid minyawansgrid">
    <% for(i=0;i<users_applied.length;i++){ %>
    <a href="<?php echo site_url() ?>/profile/<%= applied_user_id[i]%>" target="_blank"><div class="span6"><%= user_profile_image[i] %><b><%= users_applied[i]%></b></a>

    <a id="vote-up" href="#fakelink" employer-vote="1" job-id="<%= post_id %>">
    <i class="icon-thumbs-up"></i> <%= user_rating_like[i] %>
    </a> 
    <a id="vote-down" href="#fakelink"  class="icon-thumbs" employer-vote="-1" job-id="<%= post_id %>">
    <i class="icon-thumbs-down"></i> <%= user_rating_dislike[i] %>
    </a>

    </div>
    <% }  %>
    <img class="arrow-left" src="<?php echo get_template_directory_uri(); ?>/images/left-arrow.png">
    </div>
    </div>
 
    <div class="span3 action">
    
    <div class="div-box-block">
    <span class='load_ajax1' style="display:none"></span>
    <?php if (get_user_role() === 'minyawn'): ?>
        <% if(todays_date_time > job_end_date_time_check)%>
        <a href="#" class="required">This job is complete!</a>
        <% else if(can_apply_job == 3) %>
        <a href="#" class="required">You are hired!</a>
        <% else if(can_apply_job == 1)%>
        <a href="#" id="unapply-job" class="btn btn-medium btn-block btn-danger red-btn" data-action="unapply" data-job-id="<%= post_id %>">Unapply</a>
        <% else if(can_apply_job == 0 ) %>
        <a href="#" id="apply-job-browse" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>">Apply</a>

        <% else if(can_apply_job == 2 ) %>
        <a href="#" class="required">Requirement Complete</a>



        <?php
    else:
        ?>

        <% if(is_job_owner == 1){%>
        <%  if(can_apply_job == 2 || todays_date_time > job_end_time_check || can_apply_job == 1) %>
        <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>">Select Your Minions</a>

        <% else if (todays_date_time < job_end_time_check && can_apply_job == 0){%>
        <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-medium btn-block green-btn btn-success " data-action="apply" data-job-id="<%= post_id %>">Select Your Minions</a>
        <% }else if(can_apply_job ==3 || todays_date_time > job_end_time_check ){ %>
        <a href="<?php echo site_url() ?>/job/<%= post_slug %>" target="_blank" id="select-minyawn" class="btn btn-large btn-block btn-inverse  btn-rate" data-action="apply" data-job-id="<%= post_id %>">Rate Your Minions</a>
        <% }
        }else{
        %>
        <span style=" display: block;font-size: 13px;line-height: 22px;margin: auto;text-align: center;width: 67%;">Please Log-in as a Minion to apply to this job.</span>
        <% } %>

    <?php
    endif;
    ?>

    </div>

    </div>
    </div>



    </div>
</script>
