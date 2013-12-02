<script type="text/template" id="minyawn-directory-card">
    <li class="span3 thumbspan" id="minyawn<%= result.user_id %>" onclick="window.open('http://www.minyawns.com/profile/214/')">
                           <div class="thumbnail" id="thumbnail-10">
                              <div class="m1" onclick="return true">
                                 <div class="caption">
								 <div class="minions-applied"> <i class="icon-location-arrow "></i> Minion is Invited</div>
                                    <div class="minyawns-img">
                                      <%= result.user_avatar %>
                                    </div>
                                    <h4><%= result.minion_name %></h4>
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
                                    <h4><%= result.minion_name %></h4>
                                    <div class="collage"><%= result.college %></div>
                                    <div class="collage"><%= result.major %></div>
                                    <div class="social-link">
                                       <%= result.user_url %>
                                    </div>
                                    <div class="social-link">
                                       <%= result.user_email %>
                                    </div>
									<a href="#fakelink" class="btn btn-primary invite-btn">
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
