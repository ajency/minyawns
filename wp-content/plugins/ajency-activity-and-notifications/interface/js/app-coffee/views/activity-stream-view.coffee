define ['startapp','text!app/templates/activity-stream.html','moment'], (App,activityStreamTpl,moment)->

    App.module "ListActivity.Views", (Views, App)-> 

        class SingleView extends Marionette.ItemView
 
            initialize:-> 
         
 
            tagName     : 'div'
            
            template    : '<div class="avatar-box">
                  <div class="avatar left" href="#">
                      <img src="{{{NOAVATAR}}}" class="avatar-img ajan-user-pic-{{user_id}}">
                  </div>
                  <div class="avatar-content">
                      <h5 class="avatar-heading left">{{{action}}} </h5>
                      <h5 class="avatar-heading left full-width">
                      <small class="ajan-user-name ajan-user-name-{{user_id}}"> Minyawn</small>
                      <small class="ajan-user-role ajan-user-role-{{user_id}}"></small>
                      <small class="ajan-user-additional-info-{{user_id}}"></small></h5>
                       
                      <p class="comment m-tb-5">{{content}}</p>

                      <div class="comment-info m-b-10">
                          <span class="comment-date left">
                              {{activity_date}}
                          </span>
                          <span class="left">&nbsp;|&nbsp;</span>
                          <span class="comment-time left">
                          {{activity_time}}
                          </span>

                          <span class="right rep-del">
                              <a href="#" class="reply">
                                  comments({{comment_count}})
                              </a>&nbsp;
                              <a href="#" class="reply">
                                  <span class="glyphicon glyphicon-share-alt"></span>
                              </a>&nbsp;
                              <a href="#" class="delete">
                                  <span class="glyphicon glyphicon-trash"  ></span>
                              </a>

                          </span>
                      </div>

               
                    </div>
                    <div class="alert-msg">
                        <div class="icon-close right">
                            <a href="#"  ><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                        Successfully deleted the message
                    </div>
                </div>'

            mixinTemplateHelpers:(data)->
                data.NOAVATAR = NOAVATAR
                activity_date = data.date_recorded
                date_recorded = data.date_recorded.split(" ")
                date_recorded_date = date_recorded[0]
                date_recorded_time = date_recorded[1]
                activity_date = moment(date_recorded_date) 
                data.activity_date =activity_date.format("MMM Do YY");
                data.activity_time =date_recorded_time;  

                data

            
         



        class Views.ShowPackage extends Marionette.CompositeView

           

            template    : activityStreamTpl

            itemView    : SingleView

            itemViewContainer : '#activity_container' 
 
            events      :
              'click #ajan-post-activity':(e)->
                e.preventDefault()
                console.log "click event"
                data = {content:$("#activity_content").val(),item_id:ajan_item_id}
                @trigger "save:new:activity" , data

            onRender:(collection)->
              @trigger "get:user:info"
              @trigger "fetch:latest:comments"

            onItemAdded:-> 
              console.log "view onDomRefresh"
              @trigger "get:user:info"  

            onAddedActivityModel : ()->
              console.log "onNewActivityAdded" 
              @trigger "get:user:info"  

            onChangeUserImage : (n)->
              _.each n.models, (model) -> 
                $(".ajan-user-pic-" + model.get("ID")).attr "src", model.get("profile_pic")
                $(".ajan-user-role-" + model.get("ID")).html model.get("user_role")
                $(".ajan-user-name-" + model.get("ID")).html model.get("name")
                unless model.get("additional_info") is "" 
                  $(".ajan-user-additional-info-" + model.get("ID")).addClass "ajan-user-additional-info"
                  $(".ajan-user-additional-info-" + model.get("ID")).html model.get("additional_info")
 
                
                return

            onOptionAdded :->
              console.log("newactivity added view")
         

            

          

 


         

            


        


            



        
        