<script type="text/template" id="jobs-table">

      <div style="clear:both;">	
      </div>
      <div class="accordion-group">
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

                <div id="collapse<%= result.post_id %>" class="accordion-body collapse ">
                     <div class="accordion-inner list-jobs">
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
                        <% for(i=0;i<result.users_applied.length;i++){ %>
                        <a href="<?php echo site_url() ?>/profile/<%= result.applied_user_id[i]%>" target="_blank"><div class="span4"><span class="image-div"><%= result.user_profile_image[i] %></span><b><%= result.users_applied[i]%></b></a>

                        <a id="vote-up" href="#fakelink" employer-vote="1" job-id="<%= result.post_id %>">
                        <i class="icon-thumbs-up"></i> <%= result.user_rating_like[i] %>
                        </a> 
                        <a id="vote-down" href="#fakelink"  class="icon-thumbs" employer-vote="-1" job-id="<%= result.post_id %>">
                        <i class="icon-thumbs-down"></i> <%= result.user_rating_dislike[i] %>
                        </a>

                    </div>
                    <% }  %>
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
  </div>
</script>
