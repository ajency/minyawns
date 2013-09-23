<script type="text/template" id="jobs-table">

    <div style="clear:both;">	
    </div>
    <div class="accordion-group view" id="job-accordion-<%= result.post_id %>">
    <div id="last-job-id" last-job="<%= result.post_id %>" value="<%= result.post_id %>">
    </div>
    <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<%= result.post_id %>">
    <div class="span12 data-title available">
    <div class="job-logo header-sub"> <div class="logo "><%= result.job_author_logo %></div></div>
    <div class="job-date header-sub">
    <span class="service-total-demand" data-count="0"><%= result.job_start_day %></span>
    <div>
    <%= result.job_start_month %><b class="service-client-demand" data-count="0"><%= result.job_start_year %></b>
    </div>
    <div class="demand"><%= result.job_day %>
    </div>
    </div>
    <div class="job-time header-sub duration_mob">
    <div class="row-fluid">
    <div class="span5 mob-botm">
    <span data-count="0" class="total-exchange-count"><%= result.job_start_time %></span>
    <div>
    <%= result.job_start_meridiem %>
    </div>
    </div>
    <div class="span2">
    <b class="time-bold">to</b>
    </div>
    <div class="span5">
    <span data-count="0" class="total-exchange-count"><%= result.job_end_time %></span>
    <div>
    <%= result.job_end_meridiem %>
    </div>
    </div>
    </div>
    </div>

    <div class="job-wage header-sub">
    <ins><span><%= result.users_applied.length %></span></ins>
    </div>
    <div class="job-progress header-sub">
    <%= job_progress

    %>


    </div>


    <div class="job-action header-sub">
    <ins><span class="amount">$ <%= result.job_wages %></span>
    </div>
    </div>
    </a>
    </div>

    <div id="collapse<%= result.post_id %>" class="accordion-body  single-jobs collapse " >
    <div class="accordion-inner list-jobs ">
    <div class="row-fluid header-title">
    <div class="span12">
    <h3><a href=<?php echo site_url() ?>/job/<%= result.post_slug %> target="_blank" > <%= result.post_title %> <span class="view-link"><i class="icon-search"></i> View</span></a> </h3>
    </div>
    </div>
    <div class="row-fluid job-data expand">
    <div class="span9 inner-data details">
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Requested by :</b></div><div class="span9"> <a href="<?php echo site_url() ?>/profile/<%= result.job_author_id%>" target="_blank" class="request_link"><%= result.job_author %></a> 
    </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Location :</b></div><div class="span9"><%= result.job_location %> 
    </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Details :</b></div><div class="span9"><%= result.job_details.substring(0, 140) %> 
    </div>
    </div>
    <div class="row-fluid minywans_list">
    <div class="span3 "><b>Tags :</b></div><div class="span9"> <% for(i=0;i<result.tags.length;i++){ %> <span class="label"><%= result.tags[i] %></span><%}%> 
    </div>
    </div>
    <div class="row-fluid minyawansgrid">
    <%= minyawns_grid %>
    <img class="arrow-left" src="<?php echo get_template_directory_uri(); ?>/images/left-arrow.png">
    </div>
    </div>

    <div class="span3 action">

    <div class="div-box-block">
    <span class='load_ajax1' style="display:none"></span>
    <%=  job_collapse_button%>

    </div>
    </div>
    </div>

    <form class="paypal" action="payments.php" method="post" id="paypal_form" target="_blank">   

    <input type="hidden"  name="returnUrl" id="returnUrl" value="<?php echo $returnUrl; ?>" / >
    <input type="hidden" name="cancelUrl" id="cancelUrl"  value="<?php echo $cancelUrl; ?>" / >
    <input type="hidden"  name="notify_url" id="notify_url" value="<?php echo site_url() . '/paypal-payments/'; ?>" / >
    <input type='hidden' name='hdn_jobwages' id='hdn_jobwages' value='' />
    <div class="row-fluid minyawns-grid">
    <ul class="thumbnails">
    <span class='load_ajaxsingle_job_minions' style="display:none"></span>
    </ul>
    </form>
    </div>
    </div>
</script>

<script type="text/template" id="minion-cards">  

     <a href="<?php echo site_url() ?>/profile/<%= result.user_id %>" target="_blank"/> 
    <li class="span3" id="<%= result.user_id %>" >
   
    <div class="thumbnail">
    <div class="caption">
    <div class="minyawns-img">
    <%= result.user_image%>
    </div>
    <div class="rating">
    <a href="#fakelink">
    <i class="icon-thumbs-up"></i> <%= result.rating_positive %>
    </a>
    <a href="#fakelink"  class="icon-thumbs">
    <i class="icon-thumbs-down"></i> <%= result.rating_negative %>
    </a>
    </div>
    <h4> <%= result.name %></h4>
    <div class="collage"> <%= result.college%> </div>
    <div class="collage"> <%= result.major%> </div>
    <div class="social-link">
    <%= result.user_email %> 
    </div>
    <%
    var split_skills=result.user_skills.split(',');
    for(var index=0;index<=split_skills.length;index++){
    %>
    <span class="label label-small"><%= split_skills[index] %></span>
    <% } %>
    <hr>
    <div class="dwn-btn">
    <%= select_button %>
    </div>
    </div>
    </div>
     
    </li>
   </a>
</script>

<script type="text/template" id="confirm-hire">
    <input type="hidden" id="hidden_selected_min"/>
    <span class="load_ajaxconfirm" style="display:none"></span>
    <a  id="confirm-hire-button" data-toggle="modal" class="btn btn-medium btn-block green-btn btn-success">Confirm & Hire</a>

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
    <h4> Apply Job</h4>
    <div class="collage">"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</div>
    <hr>
    <div class="dwn-btn">

    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>

</script>