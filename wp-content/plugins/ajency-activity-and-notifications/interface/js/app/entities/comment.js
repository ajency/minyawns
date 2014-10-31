// Generated by CoffeeScript 1.8.0
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  define(['startapp', 'backbone'], function(App) {
    return App.module("Entities.Comment", function(Activity, App) {
      var API, Comment, CommentCollection, commentCollection, myarray;
      Comment = (function(_super) {
        __extends(Comment, _super);

        function Comment() {
          return Comment.__super__.constructor.apply(this, arguments);
        }

        Comment.prototype.idAttribute = 'ID';

        Comment.prototype.defaults = {
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

        Comment.prototype.name = 'comment';

        Comment.prototype.urlRoot = function() {
          return SITEURL + ajan_post_comments_uri;
        };

        return Comment;

      })(Backbone.Model);
      CommentCollection = (function(_super) {
        __extends(CommentCollection, _super);

        function CommentCollection() {
          return CommentCollection.__super__.constructor.apply(this, arguments);
        }

        CommentCollection.prototype.model = Comment;

        CommentCollection.prototype.url = function() {
          return SITEURL + ajan_get_comments_uri;
        };

        CommentCollection.prototype.parse = function(response) {
          return response.collection;
        };

        return CommentCollection;

      })(Backbone.Collection);
      commentCollection = new CommentCollection;
      myarray = [];
      commentCollection.fetch();
      API = {
        getComments: function(data) {
          console.log("data");
          console.log(data);
          return commentCollection.fetch({
            data: data
          });
        },
        saveComment: function(data) {
          var comment;
          console.log("entity save comment");
          comment = new Activity(data);
          console.log(comment);
          return comment;
        },
        addComment: function(model) {
          console.log("model add comment");
          return commentCollection.add(model);
        },
        getSingleComment: function(ID) {
          var commentModel;
          return commentModel = commentCollection.get(ID);
        }
      };
      App.reqres.setHandler("get:comment:collection", function(data) {
        return API.getComments(data);
      });
      App.reqres.setHandler("create:new:comment", function(data) {
        return API.saveComment(data);
      });
      App.commands.setHandler("add:new:comment:model", function(model) {
        return API.addComment(model);
      });
      return App.reqres.setHandler("get:comment:model", function(ID) {
        return API.getSingleComment(ID);
      });
    });
  });

}).call(this);
