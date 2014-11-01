// Generated by CoffeeScript 1.8.0
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  define(['startapp', 'backbone'], function(App) {
    return App.module("Entities.Activity", function(Activity, App) {
      var API, ActivityCollection, activityCollection, myarray;
      Activity = (function(_super) {
        __extends(Activity, _super);

        function Activity() {
          return Activity.__super__.constructor.apply(this, arguments);
        }

        Activity.prototype.defaults = {
          user_id: "",
          component: "",
          type: "",
          action: "",
          content: "",
          item_id: "",
          secondary_item_id: "",
          date_recorded: "",
          comment_count: "",
          nonce: ACTIVITY_NONCE_STRING
        };

        Activity.prototype.name = 'activity';

        Activity.prototype.urlRoot = SITEURL + ajan_post_activities_uri;

        return Activity;

      })(Backbone.Model);
      ActivityCollection = (function(_super) {
        __extends(ActivityCollection, _super);

        function ActivityCollection() {
          return ActivityCollection.__super__.constructor.apply(this, arguments);
        }

        ActivityCollection.prototype.model = Activity;

        ActivityCollection.prototype.url = function() {
          return SITEURL + ajan_get_activities_uri;
        };

        ActivityCollection.prototype.parse = function(response) {
          return response.collection;
        };

        return ActivityCollection;

      })(Backbone.Collection);
      activityCollection = new ActivityCollection;
      myarray = [];
      activityCollection.fetch();
      API = {
        getActivities: function() {
          return activityCollection;
        },
        saveActivity: function(data) {
          var activity, ajan_post_data;
          ajan_post_data = ajan_post_activities_uri;
          console.log("entity save activity");
          activity = new Activity(data);
          console.log(activity);
          return activity;
        },
        addActivity: function(model) {
          console.log("model add activity");
          return activityCollection.add(model);
        },
        getSingleActivity: function(ID) {
          var activityModel;
          return activityModel = activityCollection.get(ID);
        }
      };
      App.reqres.setHandler("get:activity:collection", function(data) {
        return API.getActivities();
      });
      App.reqres.setHandler("create:new:activity", function(data) {
        return API.saveActivity(data);
      });
      App.commands.setHandler("add:new:activity:model", function(model) {
        return API.addActivity(model);
      });
      return App.reqres.setHandler("get:activity:model", function(ID) {
        return API.getSingleActivity(ID);
      });
    });
  });

}).call(this);
