define ['startapp','text!app/templates/activity-stream.html'], (App,activityStreamTpl)->

    App.module "ListActivity.Views", (Views, App)-> 

        class SingleView extends Marionette.ItemView
 
              
            tagName     : 'div'
            
            template    : '<div class="avatar-box">
                  <div class="avatar left" href="#">
                      <img src="{{NOAVATAR}}" class="avatar-img">
                  </div>
                  <div class="avatar-content">
                      <h5 class="avatar-heading left">{{action}} </h5>
                
                      <p class="comment m-tb-5">{{content}}</p>

                      <div class="comment-info m-b-10">
                          <span class="comment-date left">
                              14 July 2016
                          </span>
                          <span class="left">&nbsp;|&nbsp;</span>
                          <span class="comment-time left">
                          9:30 am
                          </span>

                          <span class="right rep-del">
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

            
         



        class Views.ShowPackage extends Marionette.CompositeView

           

            template    : activityStreamTpl

            itemView    : SingleView

            itemViewContainer : '#activity_container' 
 

            onShow:-> 
                console.log("viewshw"+NOAVATAR)


         

            


        


            



        
        