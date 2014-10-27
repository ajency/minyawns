// Generated by CoffeeScript 1.8.0
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  define(["startapp", "backbone", "marionette", "app/views/activity-stream-view", "app/controllers/region-controller"], function(App, Backbone, Marionette, ActivityStreamView, RegionController) {
    return App.module("ListActivity", function(ListActivity, App) {
      var activitystreamcontroller;
      activitystreamcontroller = (function(_super) {
        __extends(activitystreamcontroller, _super);

        function activitystreamcontroller() {
          return activitystreamcontroller.__super__.constructor.apply(this, arguments);
        }

        activitystreamcontroller.prototype.initialize = function() {
          var view;
          this.activityCollection = App.request("get:activity:collection");
          this.view = view = this._getView(this.activityCollection);
          this.listenTo(view, "new:user:info", this._getUsers);
          this.listenTo(view, "change:user:info", this._displayUserInfo);
          return App.execute("when:fetched", [this.activityCollection], (function(_this) {
            return function() {
              return _this.show(view);
            };
          })(this));
        };

        activitystreamcontroller.prototype._getView = function(activityCollection) {
          return new ListActivity.Views.ShowPackage({
            collection: activityCollection
          });
        };

        activitystreamcontroller.prototype._getUsers = function() {
          var user_ids;
          user_ids = this.activityCollection.pluck("user_id");
          user_ids = _.uniq(user_ids).join();
          this.userCollection = new App.Entities.User.UserCollection;
          return this.userCollection.fetch({
            data: {
              users: user_ids
            },
            success: function(c, y) {
              return this.view.triggerMethod("change:user:info", c);
            }
          });
        };

        activitystreamcontroller.prototype._displayUserInfo = function() {
          console.log("displayuserCollection");
          console.log(this.userCollection);
          return _.each(this.userCollection, function(property, index) {
            console.log("property");
            return console.log(property);
          });
        };

        return activitystreamcontroller;

      })(RegionController);
      return App.commands.setHandler("show:activity:package", function(opt) {
        if (opt == null) {
          opt = {};
        }
        return new activitystreamcontroller(opt);
      });
    });
  });

}).call(this);
