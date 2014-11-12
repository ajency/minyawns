var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

(function(root, factory) {
  var Backbone, Marionette, _;
  Backbone = void 0;
  Marionette = void 0;
  _ = void 0;
  if (typeof define === "function" && define.amd) {
    return define(["backbone", "underscore", "backbone.marionette"], function(Backbone, _) {
      return root.AjActivityStreamModule = factory(root, Backbone, _);
    });
  } else if (typeof exports !== "undefined") {
    Backbone = require("backbone");
    _ = require("underscore");
    Marionette = require("backbone.marionette");
    return module.exports = factory(root, Backbone, _, Marionette);
  } else {
    return root.AjActivityStreamModule = factory(root, root.Backbone, root._, root.Marionette);
  }
})(this, function(root, Backbone, _, Marionette) {
  "use strict";
  var ActivityCollection, ActivityModel, ActivityStreamCtrl, AjActivityStreamModule, CommentCollection, CommentModel, ShowPackage, SingleView, UserCollection, UserModel, userCollection;
  ActivityModel = (function(_super) {
    __extends(ActivityModel, _super);

    function ActivityModel() {
      return ActivityModel.__super__.constructor.apply(this, arguments);
    }

    ActivityModel.prototype.defaults = {
      user_id: "",
      component: "",
      type: "",
      action: "",
      content: "",
      item_id: "",
      secondary_item_id: "",
      date_recorded: "",
      comment_count: ""
    };

    ActivityModel.prototype.name = 'activity';

    ActivityModel.prototype.urlRoot = AJANSITEURL + "/api/activities";

    ActivityModel.prototype.sync = function(method, model, options) {
      var allData, idAttr, onlyChanged, params, sendmethod, xhr, _action, _ref, _ref1;
      sendmethod = method;
      if (method === "create") {
        sendmethod = "POST";
      }
      if (!this.name) {
        throw new Error("'name' property not set for the model");
      }
      params = {
        type: sendmethod,
        dataType: "json",
        data: {}
      };
      console.log(model);
      if (method === "delete") {
        params.url = this.urlRoot + "/" + model.get("id");
      } else {
        params.url = this.urlRoot;
      }
      _action = "" + method + "-" + this.name;
      params.data['action'] = _action;
      switch (method) {
        case 'read':
          params.type = 'GET';
          idAttr = model['idAttribute'];
          params.data[idAttr] = model.get(idAttr);
          break;
        case 'create':
          params.data = _.defaults(model.toJSON(), params.data);
          break;
        case 'update':
          onlyChanged = (_ref = options.onlyChanged) != null ? _ref : false;
          if (onlyChanged) {
            if (model.hasChanged()) {
              params.data.changes = {};
              _.each(model.changed, function(property, index) {
                return params.data.changes[property] = this.get(property);
              }, this);
            }
          } else {
            params.data = _.defaults(model.toJSON(), params.data);
          }
          break;
        case 'delete':
          allData = (_ref1 = options.allData) != null ? _ref1 : true;
          if (allData) {
            params.data = _.defaults(model.toJSON(), params.data);
          } else {
            idAttr = model['idAttribute'];
            params.data[idAttr] = model.get(idAttr);
          }
      }
      xhr = options.xhr = Backbone.ajax(_.extend(params, options));
      model.trigger("request", model, xhr, options);
      if (method === 'read' || method === 'create') {
        model._fetch = xhr;
      }
      return xhr;
    };

    ActivityModel.prototype.parse = function(resp) {
      if (resp.code === 'OK') {
        console.log("response");
        console.log(resp);
        return resp.data;
      }
      return resp;
    };

    return ActivityModel;

  })(Backbone.Model);
  ActivityCollection = (function(_super) {
    __extends(ActivityCollection, _super);

    function ActivityCollection() {
      return ActivityCollection.__super__.constructor.apply(this, arguments);
    }

    ActivityCollection.prototype.model = ActivityModel;

    ActivityCollection.prototype.initialize = function(options) {
      console.log("activitycollection");
      console.log(options.options.item_id);
      return this.item_id = options.options.item_id;
    };

    ActivityCollection.prototype.url = function() {
      return AJANSITEURL + "/api/activities?type=get&item_id=" + this.item_id;
    };

    ActivityCollection.prototype.parse = function(response) {
      return response.collection;
    };

    return ActivityCollection;

  })(Backbone.Collection);
  UserModel = (function(_super) {
    __extends(UserModel, _super);

    function UserModel() {
      return UserModel.__super__.constructor.apply(this, arguments);
    }

    UserModel.prototype.idAttribute = 'ID';

    UserModel.prototype.defaults = {
      ID: "",
      name: "",
      profile_pic: "",
      profile_url: ""
    };

    UserModel.prototype.name = 'user';

    return UserModel;

  })(Backbone.Model);
  UserCollection = (function(_super) {
    __extends(UserCollection, _super);

    function UserCollection() {
      return UserCollection.__super__.constructor.apply(this, arguments);
    }

    UserCollection.prototype.model = UserModel;

    UserCollection.prototype.url = function() {
      return AJANSITEURL + '/api/users';
    };

    UserCollection.prototype.parse = function(response) {
      return response.collection;
    };

    return UserCollection;

  })(Backbone.Collection);
  userCollection = new UserCollection;
  CommentModel = (function(_super) {
    __extends(CommentModel, _super);

    function CommentModel() {
      return CommentModel.__super__.constructor.apply(this, arguments);
    }

    CommentModel.prototype.defaults = {
      user_id: "",
      component: "",
      type: "",
      action: "",
      content: "",
      item_id: "",
      secondary_item_id: "",
      date_recorded: "",
      comment_count: ""
    };

    CommentModel.prototype.name = 'comment';

    CommentModel.prototype.urlRoot = AJANSITEURL + "/api/activities";

    CommentModel.prototype.sync = function(method, model, options) {
      var allData, idAttr, onlyChanged, params, sendmethod, xhr, _action, _ref, _ref1;
      sendmethod = method;
      if (method === "create") {
        sendmethod = "POST";
      }
      if (!this.name) {
        throw new Error("'name' property not set for the model");
      }
      params = {
        type: sendmethod,
        dataType: "json",
        data: {}
      };
      console.log(model);
      if (method === "delete") {
        params.url = this.urlRoot + "/" + model.get("id");
      } else {
        params.url = this.urlRoot;
      }
      _action = "" + method + "-" + this.name;
      params.data['action'] = _action;
      switch (method) {
        case 'read':
          params.type = 'GET';
          idAttr = model['idAttribute'];
          params.data[idAttr] = model.get(idAttr);
          break;
        case 'create':
          params.data = _.defaults(model.toJSON(), params.data);
          break;
        case 'update':
          onlyChanged = (_ref = options.onlyChanged) != null ? _ref : false;
          if (onlyChanged) {
            if (model.hasChanged()) {
              params.data.changes = {};
              _.each(model.changed, function(property, index) {
                return params.data.changes[property] = this.get(property);
              }, this);
            }
          } else {
            params.data = _.defaults(model.toJSON(), params.data);
          }
          break;
        case 'delete':
          allData = (_ref1 = options.allData) != null ? _ref1 : true;
          if (allData) {
            params.data = _.defaults(model.toJSON(), params.data);
          } else {
            idAttr = model['idAttribute'];
            params.data[idAttr] = model.get(idAttr);
          }
      }
      xhr = options.xhr = Backbone.ajax(_.extend(params, options));
      model.trigger("request", model, xhr, options);
      if (method === 'read' || method === 'create') {
        model._fetch = xhr;
      }
      return xhr;
    };

    CommentModel.prototype.parse = function(resp) {
      if (resp.code === 'OK') {
        console.log("response");
        console.log(resp);
        return resp.data;
      }
      return resp;
    };

    return CommentModel;

  })(Backbone.Model);
  CommentCollection = (function(_super) {
    __extends(CommentCollection, _super);

    function CommentCollection() {
      return CommentCollection.__super__.constructor.apply(this, arguments);
    }

    CommentCollection.prototype.model = CommentModel;

    CommentCollection.prototype.url = function() {
      return AJANSITEURL + "/api/activities/comments";
    };

    CommentCollection.prototype.parse = function(response) {
      return response.collection;
    };

    return CommentCollection;

  })(Backbone.Collection);
  SingleView = (function(_super) {
    __extends(SingleView, _super);

    function SingleView() {
      return SingleView.__super__.constructor.apply(this, arguments);
    }

    SingleView.prototype.template = '<div class="avatar-box"> <div class="avatar left" href="#"> <img src="{{{NOAVATAR}}}" class="avatar-img ajan-user-pic-{{user_id}}"> </div> <div class="avatar-content activity-main-{{id}}"> <h5 class="avatar-heading left">{{{action}}} </h5> <div class="comment-info m-b-10"> <div class="comment-date-right"> <span class="comment-date right"> {{activity_date}} </span> <span class="right">&nbsp;,&nbsp;</span> <span class="comment-time right"> {{activity_time}} </span> </div> </div> <h5 class="avatar-heading left full-width"> <small class="ajan-user-name ajan-user-name-{{user_id}}"> Minyawn</small> <small class="ajan-user-role ajan-user-role-{{user_id}}"></small> <small class="ajan-user-additional-info-{{user_id}}"></small></h5> <p class="comment m-tb-5">{{content}}</p> <div class="comment-info m-b-10"> <div class="comment-date-left"> <span class="comment-date left"> {{activity_date}} </span> <span class="left">&nbsp;|&nbsp;</span> <span class="comment-time left"> {{activity_time}} </span> </div> <div class="activity-comment-actions-left"> <span class="left rep-del"> <a href="javascript:void(0)" class="reply get-comments" activity="{{id}}"> comments(<span id="comment_count_{{id}}">{{comment_count}}</span>) |</a> <a href="javascript:void(0)" class="reply reply-activity reply-activity-{{id}}"  activity="{{id}}"> reply |</a> <a href="javascript:void(0)" class="delete delete-activity delete-activity-{{id}}" activity="{{id}}"> delete </a> </span> </div> <div class="activity-comment-actions-right"> <span class="right rep-del"> <a href="javascript:void(0)" class="reply get-comments" activity="{{id}}"> comments(<span id="comment_count_{{id}}">{{comment_count}}</span>) </a>&nbsp; <a href="javascript:void(0)" class="reply reply-activity reply-activity-{{id}}"    activity="{{id}}"> <span class="glyphicon glyphicon-share-alt reply-activity reply-activity-{{id}}" activity="{{id}}"></span> </a>&nbsp; <a href="javascript:void(0)" class="delete"> <span class="glyphicon glyphicon-trash delete-activity delete-activity-{{id}}" activity="{{id}}" ></span> </a> </span> </div> <div class="reply-txt reply-txt-{{id}}"> <p class="reply-msg left">Enter your Reply here</p><br> <textarea class="full m-tb-10" name="activity-comment-{{id}}" id="activity-comment-{{id}}" rows="2"></textarea> <div class="right m-b-10"> <input type="button" class="btn green-btn save-activity-reply" id="save-activity-reply-{{id}}" value="Post Reply"  activity="{{id}}"> <input type="button" class="btn cancel-activity-reply" value="Cancel"  activity="{{id}}"> </div> </div> </div> </div> </div>';

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

    SingleView.prototype.modelEvents = {
      'change': 'modelChanged'
    };

    SingleView.prototype.modelChanged = function(model) {
      console.log("modellllll");
      console.log(model);
      console.log("#comment_count_" + model.get("id"));
      return $("#comment_count_" + model.get("id")).html(model.get("comment_count"));
    };

    return SingleView;

  })(Marionette.ItemView);
  ShowPackage = (function(_super) {
    __extends(ShowPackage, _super);

    function ShowPackage() {
      return ShowPackage.__super__.constructor.apply(this, arguments);
    }

    ShowPackage.prototype.initialize = function(options) {};

    ShowPackage.prototype.template = '<div class="msg-cover"> <div class="right"> Show: <select name="activity_filter" id="activity_filter" class="select-filter"> <option value="">Everything</option> </select> </div> <p class="msg left" >Enter your Message here</p><br> <textarea class="full m-b-10 clearfix" rows="3" name="content" id="activity_content"></textarea> <div class="right m-b-10"> <input type="submit" id="ajan-post-activity" class="btn green-btn" value="Post Message"> </div> <div class="avatar-container" id="activity_container"> </div> </div>';

    ShowPackage.prototype.childView = SingleView;

    ShowPackage.prototype.childViewContainer = '#activity_container';

    ShowPackage.prototype.events = {
      'click #ajan-post-activity': function(e) {
        var data;
        e.preventDefault();
        if ($("#activity_content").val() === "") {
          return $("#activity_content").after("<span class='error-message'>Mesage cannot be empty</span>");
        } else {
          data = {
            content: $("#activity_content").val()
          };
          $(e.target).parent().parent().append('<span class="right throbber-container"><span class="throbber"></span></span>');
          $(e.target).hide();
          return this.trigger("save:new:activity", data);
        }
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
        if ($('#activity-comment-' + $(e.target).attr('activity')).val() === "") {
          return alert("Mesage cannot be empty");
        } else {
          data = {
            content: $('#activity-comment-' + $(e.target).attr('activity')).val(),
            secondary_item_id: $(e.target).attr('activity')
          };
          $(e.target).parent().parent().append('<span class="right throbber-container"><span class="throbber"></span></span>');
          $(e.target).next().hide();
          $(e.target).hide();
          return this.trigger("save:new:comment", data);
        }
      },
      'click .delete-activity': function(e) {
        var check;
        check = confirm('Are you sure you want to delete this activity?');
        if (check === true) {
          $('.delete-activity-' + $(e.target).attr('activity')).parent().parent().append('<span class="throbber"></span>');
          $('.delete-activity-' + $(e.target).attr('activity')).parent().hide();
          return this.trigger("delete:activity", $(e.target).attr('activity'));
        }
      },
      'click .delete-comment': function(e) {
        var check;
        check = confirm('Are you sure you want to delete this activity comment?');
        if (check === true) {
          $('.delete-comment-' + $(e.target).attr('activity')).parent().append('<span class="throbber"></span>');
          $(e.target).parent().hide();
          return this.trigger("delete:comment", $(e.target).attr('activity'));
        }
      },
      'click .get-comments': function(e) {
        return this.trigger("fetch:all:comments", $(e.target).attr('activity'));
      },
      'focus #activity_filter': function(e) {
        return this.trigger("create:filters", $(e.target).val());
      },
      'change #activity_filter': function(e) {
        return this.trigger("filter:activity", $(e.target).val());
      }
    };

    ShowPackage.prototype.onRender = function(collection) {
      this.trigger("get:user:info");
      return this.trigger("fetch:latest:comments");
    };

    ShowPackage.prototype.onShow = function() {};

    ShowPackage.prototype.collectionEvents = {
      'reset': 'collectionReset'
    };

    ShowPackage.prototype.collectionReset = function(model) {
      return this.trigger("get:user:info");
    };

    ShowPackage.prototype.onAddedActivityModel = function() {
      $("#ajan-post-activity").show();
      $("#ajan-post-activity").parent().parent().find(".throbber-container").remove();
      $("#activity_content").val("");
      $("#activity_filter").trigger('change');
      return this.trigger("get:user:info");
    };

    ShowPackage.prototype.onChangeUserImage = function(n) {
      _.each(n.models, function(model) {
        $(".ajan-user-pic-" + model.get("ID")).attr("src", model.get("profile_pic"));
        $(".ajan-user-role-" + model.get("ID")).html(model.get("user_role"));
        $(".ajan-user-name-" + model.get("ID")).html(model.get("name"));
        if (model.get("additional_info") !== "") {
          $(".ajan-user-additional-info-" + model.get("ID")).addClass("ajan-user-additional-info");
          return $(".ajan-user-additional-info-" + model.get("ID")).html(model.get("additional_info"));
        }
      });
    };

    ShowPackage.prototype.onAddedCommentModel = function(model) {
      var activity_date, activity_time, date_recorded, date_recorded_date, date_recorded_time;
      $("#save-activity-reply-" + model.get("secondary_item_id")).show();
      $("#save-activity-reply-" + model.get("secondary_item_id")).next().show();
      $("#save-activity-reply-" + model.get("secondary_item_id")).parent().parent().find(".throbber-container").remove();
      $("#save-activity-reply-" + model.get("secondary_item_id")).next().trigger('click');
      $("#activity-comment-" + model.get("secondary_item_id")).val("");
      activity_date = model.get("date_recorded");
      date_recorded = activity_date.split(" ");
      date_recorded_date = date_recorded[0];
      date_recorded_time = date_recorded[1];
      activity_date = moment(date_recorded_date);
      activity_date = activity_date.format("MMM Do YY");
      activity_time = date_recorded_time;
      $(".activity-main-" + model.get("secondary_item_id")).append('<div class="avatar-box-1" id="activity-comment-container-' + model.get("id") + '"> <div class="avatar left" href="#"> <img src="' + NOAVATAR + '" class="avatar-img ajan-user-pic-' + model.get("user_id") + '"> </div> <div class="avatar-content"> <h5 class="avatar-heading left">' + model.get("action") + '</h5> <div class="comment-info m-b-10"> <div class="comment-date-right"> <span class="comment-date right">' + activity_date + '</span> <span class="right">,</span> <span class="comment-time right">' + activity_time + '</span> </div> </div> <p class="comment m-tb-5">' + model.get("content") + '</p> <div class="comment-info m-b-10"> <div class="comment-date-left"> <span class="comment-date left">' + activity_date + '</span> <span class="left">&nbsp;|&nbsp;</span> <span class="comment-time left">' + activity_time + '</span> </div> <span class="right rep-del"> <a href="javascript:void(0)" class="delete delete-comment-' + model.get("id") + '" activity="' + model.get("id") + '"> <span class="glyphicon glyphicon-trash delete-comment delete-comment-' + model.get("id") + '" activity="' + model.get("id") + '"></span> </a> </span> </div> </div> </div>');
      return this.trigger("get:user:info");
    };

    ShowPackage.prototype.onActivityCommentsFetched = function(activity_comments, activity) {
      console.log("onActivityCommentsFetched");
      $(".activity-main-" + activity).find('.avatar-box-1').remove();
      _.each(activity_comments.models, function(model) {
        var activity_date, activity_time, date_recorded, date_recorded_date, date_recorded_time;
        activity_date = model.get("date_recorded");
        date_recorded = activity_date.split(" ");
        date_recorded_date = date_recorded[0];
        date_recorded_time = date_recorded[1];
        activity_date = moment(date_recorded_date);
        activity_date = activity_date.format("MMM Do YY");
        activity_time = date_recorded_time;
        return $(".activity-main-" + model.get("secondary_item_id")).append('<div class="avatar-box-1" id="activity-comment-container-' + model.get("id") + '"> <div class="avatar left" href="#"> <img src="' + NOAVATAR + '" class="avatar-img ajan-user-pic-' + model.get("user_id") + '"> </div> <div class="avatar-content"> <h5 class="avatar-heading left">' + model.get("action") + '</h5> <div class="comment-info m-b-10"> <div class="comment-date-right"> <span class="comment-date right">' + activity_date + '</span> <span class="right">,</span> <span class="comment-time right">' + activity_time + '</span> </div> </div> <p class="comment m-tb-5">' + model.get("content") + '</p> <div class="comment-info m-b-10"> <div class="comment-date-left"> <span class="comment-date left">' + activity_date + '</span> <span class="left">&nbsp;|&nbsp;</span> <span class="comment-time left">' + activity_time + '</span> </div> <div class="activity-comment-actions-left"> <span class="left rep-del"> <a href="javascript:void(0)" class="delete delete-comment delete-comment-' + model.get("id") + '" activity="' + model.get("id") + '"> delete </a> </span> </div> <div class="activity-comment-actions-right"> <span class="right rep-del"> <a href="javascript:void(0)" class="delete  delete-comment-' + model.get("id") + '" activity="' + model.get("id") + '"> <span class="glyphicon glyphicon-trash delete-comment delete-comment-' + model.get("id") + '" activity="' + model.get("id") + '"></span> </a> </span> </div> </div> </div> </div>');
      });
      return this.trigger("get:user:info");
    };

    ShowPackage.prototype.onActivityCommentDeleted = function(activity) {
      return $('#activity-comment-container-' + activity).remove();
    };

    ShowPackage.prototype.onGenerateFilters = function(activityFilters, selectedFilter) {
      $("#activity_filter").empty();
      $('#lstCities option[value!="' + selectedFilter + '"]').remove();
      $("#activity_filter").append(new Option("Everything", ""));
      return _.each(activityFilters, function(val) {
        var displayVal;
        displayVal = val.replace("_", " ");
        displayVal = displayVal.charAt(0).toUpperCase() + displayVal.slice(1);
        return $("#activity_filter").append(new Option(displayVal, val));
      });
    };

    ShowPackage.prototype.onTriggerActivityFilter = function() {
      return this.trigger("filter:activity", $("#activity_filter").val());
    };

    return ShowPackage;

  })(Marionette.CompositeView);
  ActivityStreamCtrl = (function(_super) {
    __extends(ActivityStreamCtrl, _super);

    function ActivityStreamCtrl() {
      this._commentAdded = __bind(this._commentAdded, this);
      this._activityAdded = __bind(this._activityAdded, this);
      this.show = __bind(this.show, this);
      return ActivityStreamCtrl.__super__.constructor.apply(this, arguments);
    }

    ActivityStreamCtrl.prototype.initialize = function(options) {
      var view;
      this.options = options;
      this.currentActivityCollection = new ActivityCollection(options);
      this.activityCollection = new ActivityCollection(options);
      this.userCollection = new UserCollection(options);
      this.commentCollection = new CommentCollection(options);
      this.view = view = this._getView(this.currentActivityCollection);
      this.activityCollection.fetch({
        wait: true,
        data: {
          item_id: options.item_id
        },
        success: (function(_this) {
          return function(collection, response) {
            console.log("collectionshow");
            console.log(collection);
            _this.currentActivityCollection.reset(collection.toJSON());
            return _this.show(_this.view);
          };
        })(this)
      });
      this.listenTo(view, "get:user:info", this._getUsers);
      this.listenTo(view, "fetch:latest:comments", this._getLatestComments);
      this.listenTo(view, "create:filters", this._createFilters);
      this.listenTo(view, "fetch:all:comments", this._getAllComments);
      this.listenTo(view, "change:user:info", this._displayUserInfo);
      this.listenTo(view, "save:new:activity", this._saveActivity);
      this.listenTo(view, "save:new:comment", this._saveComment);
      this.listenTo(view, "delete:activity", this._deleteActivity);
      this.listenTo(view, "delete:comment", this._deleteComment);
      this.listenTo(view, "filter:activity", this._filterActivity);
      this.listenTo(view, "delete:comment", this._deleteComment);
      return this.listenTo(this.activityCollection, "add", this._triggerFilter);
    };

    ActivityStreamCtrl.prototype.show = function(view) {
      return this.options.region.show(this.view);
    };

    ActivityStreamCtrl.prototype._getView = function(activityCollection) {
      return new ShowPackage({
        collection: activityCollection
      });
    };

    ActivityStreamCtrl.prototype._getUsers = function() {
      var fetcheduser_ids, user_ids;
      user_ids = this.activityCollection.pluck("user_id");
      fetcheduser_ids = this.userCollection.pluck("ID");
      user_ids = _.difference(_.uniq(user_ids), fetcheduser_ids);
      user_ids = _.uniq(user_ids).join();
      return this.userCollection.fetch({
        data: {
          users: user_ids,
          item_id: this.options.item_id
        },
        success: (function(_this) {
          return function(collection, response) {
            return _this.view.triggerMethod("change:user:image", collection);
          };
        })(this)
      });
    };

    ActivityStreamCtrl.prototype._createFilters = function(selectedFilter) {
      var componentType;
      componentType = _.uniq(this.activityCollection.pluck("type"));
      return this.view.triggerMethod("generate:filters", componentType, selectedFilter);
    };

    ActivityStreamCtrl.prototype._saveActivity = function(data) {
      var activityModel;
      data.item_id = this.options.options.item_id;
      activityModel = new ActivityModel(data);
      return activityModel.save(null, {
        emulateJSON: true,
        wait: true,
        success: this._activityAdded
      });
    };

    ActivityStreamCtrl.prototype._saveComment = function(data) {
      var commentModel;
      data.item_id = this.options.options.item_id;
      commentModel = new CommentModel(data);
      return commentModel.save(null, {
        emulateJSON: true,
        wait: true,
        success: this._commentAdded
      });
    };

    ActivityStreamCtrl.prototype._activityAdded = function(model, response) {
      this.activityCollection.unshift(model);
      return this.view.triggerMethod("added:activity:model");
    };

    ActivityStreamCtrl.prototype._commentAdded = function(model, response) {
      var clonedParentModel, comment_count, parentModel, secondary_item_id;
      this.commentCollection.add(model);
      secondary_item_id = model.get("secondary_item_id");
      parentModel = this.activityCollection.get(secondary_item_id);
      clonedParentModel = this.currentActivityCollection.get(secondary_item_id);
      comment_count = parentModel.get("comment_count");
      parentModel.set("comment_count", comment_count + 1);
      clonedParentModel.set("comment_count", comment_count + 1);
      this.currentActivityCollection.add(clonedParentModel);
      this.activityCollection.add(parentModel);
      return this.view.triggerMethod("added:comment:model", model);
    };

    ActivityStreamCtrl.prototype._getLatestComments = function() {
      var activity_ids;
      console.log("_getLatestComments");
      activity_ids = this.activityCollection.pluck("id");
      activity_ids = activity_ids.join();
      return this.commentCollection.fetch({
        data: {
          activity_parent: activity_ids,
          item_id: this.options.item_id,
          records: 3
        },
        success: (function(_this) {
          return function(collection, response) {
            console.log("_getLatestComments fetched");
            return _this.view.triggerMethod("activity:comments:fetched", collection);
          };
        })(this)
      });
    };

    ActivityStreamCtrl.prototype._getAllComments = function(activity) {
      return this.commentCollection.fetch({
        data: {
          activity_parent: activity,
          item_id: this.options.item_id,
          records: ''
        },
        success: (function(_this) {
          return function(collection, response) {
            return _this.view.triggerMethod("activity:comments:fetched", collection, activity);
          };
        })(this)
      });
    };

    ActivityStreamCtrl.prototype._deleteActivity = function(activity) {
      var model;
      model = this.activityCollection.get(activity);
      return model.destroy({
        success: (function(_this) {
          return function(status, response) {
            console.log("status");
            return _this.currentActivityCollection.remove(model);
          };
        })(this)
      });
    };

    ActivityStreamCtrl.prototype._deleteComment = function(activity) {
      var model, secondary_item_id;
      model = this.commentCollection.get(activity);
      secondary_item_id = model.get("secondary_item_id");
      return model.destroy({
        success: (function(_this) {
          return function(status, response) {
            var clonedParentModel, comment_count, parentModel;
            parentModel = _this.activityCollection.get(secondary_item_id);
            clonedParentModel = _this.currentActivityCollection.get(secondary_item_id);
            comment_count = parentModel.get("comment_count");
            parentModel.set("comment_count", comment_count - 1);
            clonedParentModel.set("comment_count", comment_count - 1);
            _this.currentActivityCollection.add(clonedParentModel);
            _this.activityCollection.add(parentModel);
            return _this.view.triggerMethod("activity:comment:deleted", activity);
          };
        })(this)
      });
    };

    ActivityStreamCtrl.prototype._filterActivity = function(filterBy) {
      var filteredActivityCollection;
      if (filterBy === "") {
        return this.currentActivityCollection.reset(this.activityCollection.toJSON());
      } else {
        filteredActivityCollection = _.where(this.activityCollection.toJSON(), {
          type: filterBy
        });
        return this.currentActivityCollection.reset(filteredActivityCollection);
      }
    };

    ActivityStreamCtrl.prototype._triggerFilter = function() {
      return this.view.triggerMethod("trigger:activity:filter");
    };

    return ActivityStreamCtrl;

  })(Marionette.Controller);
  Marionette._ctrl['ActivityStreamCtrl'] = ActivityStreamCtrl;
  AjActivityStreamModule = (function(_super) {
    __extends(AjActivityStreamModule, _super);

    function AjActivityStreamModule() {
      return AjActivityStreamModule.__super__.constructor.apply(this, arguments);
    }

    AjActivityStreamModule.prototype.initialize = function(options) {
      if (options == null) {
        options = {};
      }
      return AjActivityStreamModule.__super__.initialize.call(this, options);
    };

    return AjActivityStreamModule;

  })(Marionette.Module);
  return AjActivityStreamModule;
});
