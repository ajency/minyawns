// Generated by CoffeeScript 1.8.0
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  define(['startapp', 'backbone'], function(App) {
    return App.module("Entities.User", function(User, App) {
      var API, userCollection;
      User = (function(_super) {
        __extends(User, _super);

        function User() {
          return User.__super__.constructor.apply(this, arguments);
        }

        User.prototype.idAttribute = 'ID';

        User.prototype.defaults = {
          ID: "",
          name: "",
          profile_pic: "",
          profile_url: ""
        };

        User.prototype.name = 'user';

        return User;

      })(Backbone.Model);
      User.UserCollection = (function(_super) {
        __extends(UserCollection, _super);

        function UserCollection() {
          return UserCollection.__super__.constructor.apply(this, arguments);
        }

        UserCollection.prototype.model = User;

        UserCollection.prototype.url = function() {
          return SITEURL + '/api/users';
        };

        UserCollection.prototype.parse = function(response) {
          return response.collection;
        };

        return UserCollection;

      })(Backbone.Collection);
      userCollection = new UserCollection;
      userCollection.fetch();
      API = {
        getUsers: function(opt) {
          userCollection.fetch({
            data: {
              users: opt.users
            }
          });
          return userCollection;
        }
      };
      return App.reqres.setHandler("get:user:collection", function(opt) {
        return API.getUsers(opt);
      });
    });
  });

}).call(this);
