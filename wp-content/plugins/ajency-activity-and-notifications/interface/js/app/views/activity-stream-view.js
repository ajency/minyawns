// Generated by CoffeeScript 1.8.0
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  define(['startapp', 'text!app/templates/activity-stream.html', 'moment'], function(App, activityStreamTpl, moment) {
    return App.module("ListActivity.Views", function(Views, App) {
      var SingleView;
      SingleView = (function(_super) {
        __extends(SingleView, _super);

        function SingleView() {
          return SingleView.__super__.constructor.apply(this, arguments);
        }

        SingleView.prototype.initialize = function() {};

        SingleView.prototype.tagName = 'div';

        SingleView.prototype.template = '<div class="avatar-box"> <div class="avatar left" href="#"> <img src="{{{NOAVATAR}}}" class="avatar-img ajan-user-pic-{{user_id}}"> </div> <div class="avatar-content activity-main-{{id}}"> <h5 class="avatar-heading left">{{{action}}} </h5> <h5 class="avatar-heading left full-width"> <small class="ajan-user-name ajan-user-name-{{user_id}}"> Minyawn</small> <small class="ajan-user-role ajan-user-role-{{user_id}}"></small> <small class="ajan-user-additional-info-{{user_id}}"></small></h5> <p class="comment m-tb-5">{{content}}</p> <div class="comment-info m-b-10"> <span class="comment-date left"> {{activity_date}} </span> <span class="left">&nbsp;|&nbsp;</span> <span class="comment-time left"> {{activity_time}} </span> <span class="right rep-del"> <a href="javascript:void(0)" class="reply get-comments" activity="{{id}}"> comments({{comment_count}}) </a>&nbsp; <a href="javascript:void(0)" class="reply reply-activity reply-activity-{{id}}"    activity="{{id}}"> <span class="glyphicon glyphicon-share-alt reply-activity reply-activity-{{id}}" activity="{{id}}"></span> </a>&nbsp; <a href="javascript:void(0)" class="delete"> <span class="glyphicon glyphicon-trash delete-activity delete-activity-{{id}}" activity="{{id}}" ></span> </a> </span> <div class="reply-txt reply-txt-{{id}}"> <p class="reply-msg left">Enter your Reply here</p><br> <textarea class="full m-tb-10" name="activity-comment-{{id}}" id="activity-comment-{{id}}" rows="2"></textarea> <div class="right m-b-10"> <input type="button" class="btn green-btn save-activity-reply" id="save-activity-reply-{{id}}" value="Post Reply"  activity="{{id}}"> <input type="button" class="btn cancel-activity-reply" value="Cancel"  activity="{{id}}"> </div> </div> </div> </div> <div class="alert-msg"> <div class="icon-close right"> <a href="#"  ><span class="glyphicon glyphicon-remove"></span></a> </div> Successfully deleted the message </div> </div>';

        SingleView.prototype.mixinTemplateHelpers = function(data) {
          var activity_date, date_recorded, date_recorded_date, date_recorded_time;
          data.NOAVATAR = NOAVATAR;
          activity_date = data.date_recorded;
          date_recorded = data.date_recorded.split(" ");
          date_recorded_date = date_recorded[0];
          date_recorded_time = date_recorded[1];
          activity_date = moment(date_recorded_date);
          data.activity_date = activity_date.format("MMM Do YY");
          data.activity_time = date_recorded_time;
          return data;
        };

        return SingleView;

      })(Marionette.ItemView);
      return Views.ShowPackage = (function(_super) {
        __extends(ShowPackage, _super);

        function ShowPackage() {
          return ShowPackage.__super__.constructor.apply(this, arguments);
        }

        ShowPackage.prototype.template = activityStreamTpl;

        ShowPackage.prototype.itemView = SingleView;

        ShowPackage.prototype.itemViewContainer = '#activity_container';

        ShowPackage.prototype.events = {
          'click #ajan-post-activity': function(e) {
            var data;
            e.preventDefault();
            console.log("click event");
            data = {
              content: $("#activity_content").val(),
              item_id: ajan_item_id
            };
            $(e.target).parent().append('<span class="throbber"></span>');
            $(e.target).hide();
            return this.trigger("save:new:activity", data);
          },
          'click .reply-activity': function(e) {
            $('.reply-txt-' + $(e.target).attr('activity')).show();
            return $('.reply-activity-' + $(e.target).attr('activity')).hide();
          },
          'click .cancel-activity-reply': function(e) {
            $('.reply-activity-' + $(e.target).attr('activity')).show();
            return $('.reply-txt-' + $(e.target).attr('activity')).hide();
          },
          'click .save-activity-reply': function(e) {
            var data;
            data = {
              content: $('#activity-comment-' + $(e.target).attr('activity')).val(),
              item_id: ajan_item_id,
              secondary_item_id: $(e.target).attr('activity')
            };
            $(e.target).parent().append('<span class="throbber"></span>');
            $(e.target).next().hide();
            $(e.target).hide();
            return this.trigger("save:new:comment", data);
          },
          'click .delete-activity': function(e) {
            $('.delete-activity-' + $(e.target).attr('activity')).parent().parent().append('<span class="throbber"></span>');
            $('.delete-activity-' + $(e.target).attr('activity')).parent().hide();
            return this.trigger("delete:activity", $(e.target).attr('activity'));
          },
          'click .delete-comment': function(e) {
            $('.delete-comment-' + $(e.target).attr('activity')).parent().parent().append('<span class="throbber"></span>');
            $('.delete-comment-' + $(e.target).attr('activity')).parent().hide();
            console.log("delete-comment");
            return this.trigger("delete:comment", $(e.target).attr('activity'));
          },
          'click .get-comments': function(e) {
            console.log($(e.target).attr('activity'));
            return this.trigger("fetch:all:comments");
          }
        };

        ShowPackage.prototype.onRender = function(collection) {
          this.trigger("get:user:info");
          return this.trigger("fetch:latest:comments");
        };

        ShowPackage.prototype.onItemAdded = function() {
          console.log("view onDomRefresh");
          $("#ajan-post-activity").show();
          $("#ajan-post-activity").parent().find(".throbber").remove();
          return this.trigger("get:user:info");
        };

        ShowPackage.prototype.onAddedActivityModel = function() {
          console.log("onNewActivityAdded");
          $("#ajan-post-activity").show();
          $("#ajan-post-activity").parent().find(".throbber").remove();
          return this.trigger("get:user:info");
        };

        ShowPackage.prototype.onChangeUserImage = function(n) {
          return _.each(n.models, function(model) {
            $(".ajan-user-pic-" + model.get("ID")).attr("src", model.get("profile_pic"));
            $(".ajan-user-role-" + model.get("ID")).html(model.get("user_role"));
            $(".ajan-user-name-" + model.get("ID")).html(model.get("name"));
            if (model.get("additional_info") !== "") {
              $(".ajan-user-additional-info-" + model.get("ID")).addClass("ajan-user-additional-info");
              $(".ajan-user-additional-info-" + model.get("ID")).html(model.get("additional_info"));
            }
          });
        };

        ShowPackage.prototype.onAddedCommentModel = function(model) {
          var activity_date, activity_time, date_recorded, date_recorded_date, date_recorded_time;
          console.log("onAddedCommentModel");
          console.log(model);
          $("#save-activity-reply-" + model.get("secondary_item_id")).show();
          $("#save-activity-reply-" + model.get("secondary_item_id")).next().show();
          $("#save-activity-reply-" + model.get("secondary_item_id")).parent().find(".throbber").remove();
          $("#save-activity-reply-" + model.get("secondary_item_id")).next().trigger('click');
          activity_date = model.get("date_recorded");
          date_recorded = activity_date.split(" ");
          date_recorded_date = date_recorded[0];
          date_recorded_time = date_recorded[1];
          activity_date = moment(date_recorded_date);
          activity_date = activity_date.format("MMM Do YY");
          activity_time = date_recorded_time;
          $(".activity-main-" + model.get("secondary_item_id")).append('<div class="avatar-box-1"> <div class="avatar left" href="#"> <img src="' + NOAVATAR + '" class="avatar-img ajan-user-pic-' + model.get("user_id") + '"> </div> <div class="avatar-content"> <h5 class="avatar-heading left">' + model.get("action") + '</h5> <p class="comment m-tb-5">' + model.get("content") + '</p> <div class="comment-info m-b-10"> <span class="comment-date left">' + activity_date + '</span> <span class="left">&nbsp;|&nbsp;</span> <span class="comment-time left">' + activity_time + '</span> <span class="right rep-del"> <a href="#" class="delete"> <span class="glyphicon glyphicon-trash"></span> </a> </span> </div> </div> </div>');
          return this.trigger("get:user:info");
        };

        ShowPackage.prototype.onActivityCommentsFetched = function(activity_comments) {
          console.log("collection of comments");
          _.each(activity_comments.models, function(model) {
            var activity_date, activity_time, date_recorded, date_recorded_date, date_recorded_time;
            activity_date = model.get("date_recorded");
            date_recorded = activity_date.split(" ");
            date_recorded_date = date_recorded[0];
            date_recorded_time = date_recorded[1];
            activity_date = moment(date_recorded_date);
            activity_date = activity_date.format("MMM Do YY");
            activity_time = date_recorded_time;
            return $(".activity-main-" + model.get("secondary_item_id")).append('<div class="avatar-box-1" id="activity-comment-container-' + model.get("id") + '"> <div class="avatar left" href="#"> <img src="' + NOAVATAR + '" class="avatar-img ajan-user-pic-' + model.get("user_id") + '"> </div> <div class="avatar-content"> <h5 class="avatar-heading left">' + model.get("action") + '</h5> <p class="comment m-tb-5">' + model.get("content") + '</p> <div class="comment-info m-b-10"> <span class="comment-date left">' + activity_date + '</span> <span class="left">&nbsp;|&nbsp;</span> <span class="comment-time left">' + activity_time + '</span> <span class="right rep-del"> <a href="javascript:void(0)" class="delete delete-comment delete-comment-' + model.get("id") + '" activity="' + model.get("id") + '"> <span class="glyphicon glyphicon-trash delete-comment delete-comment-' + model.get("id") + '" activity="' + model.get("id") + '"></span> </a> </span> </div> </div> </div>');
          });
          return this.trigger("get:user:info");
        };

        ShowPackage.prototype.onActivityCommentDeleted = function(activity) {
          console.log("onActivityCommentDeleted");
          return $('#activity-comment-container-' + activity).remove();
        };

        return ShowPackage;

      })(Marionette.CompositeView);
    });
  });

}).call(this);
