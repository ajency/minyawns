var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

(function(root, factory) {
  var Backbone, Marionette, _;
  Backbone = void 0;
  Marionette = void 0;
  _ = void 0;
  if (typeof define === "function" && define.amd) {
    return define(["backbone", "underscore", "backbone.marionette"], function(Backbone, _) {
      return root.AjNotificationModule = factory(root, Backbone, _);
    });
  } else if (typeof exports !== "undefined") {
    Backbone = require("backbone");
    _ = require("underscore");
    Marionette = require("backbone.marionette");
    return module.exports = factory(root, Backbone, _, Marionette);
  } else {
    return root.AjNotificationModule = factory(root, root.Backbone, root._, root.Marionette);
  }
})(this, function(root, Backbone, _, Marionette) {
  "use strict";
  var AjNotificationModule, IView, MessageBoardCtrl, NotificationModel, NotificationView;
  IView = (function(_super) {
    __extends(IView, _super);

    function IView() {
      return IView.__super__.constructor.apply(this, arguments);
    }

    IView.prototype.template = '{{ id }}<br /><div>{{ name }}</div>';

    IView.prototype.className = 'single-notification';

    return IView;

  })(Marionette.ItemView);
  NotificationView = (function(_super) {
    __extends(NotificationView, _super);

    function NotificationView() {
      return NotificationView.__super__.constructor.apply(this, arguments);
    }

    NotificationView.prototype.template = 'Some container needed<ul class="notification-container"></ul>';

    NotificationView.prototype.className = 'notification-class';

    NotificationView.prototype.childView = IView;

    NotificationView.prototype.childViewContainer = '.notification-container';

    return NotificationView;

  })(Marionette.CompositeView);
  MessageBoardCtrl = (function(_super) {
    __extends(MessageBoardCtrl, _super);

    function MessageBoardCtrl() {
      return MessageBoardCtrl.__super__.constructor.apply(this, arguments);
    }

    MessageBoardCtrl.prototype.initialize = function(options) {
      if (options == null) {
        options = {};
      }
      return options.region.show(new NotificationView({
        'template': '<h2>New template diana</h2>'
      }));
    };

    return MessageBoardCtrl;

  })(Marionette.Controller);
  Marionette._ctrl['MessageBoardCtrl'] = MessageBoardCtrl;
  NotificationModel = (function(_super) {
    __extends(NotificationModel, _super);

    function NotificationModel() {
      return NotificationModel.__super__.constructor.apply(this, arguments);
    }

    NotificationModel.prototype.defaults = function() {
      return {
        id: _.random(0, 100),
        name: 'NotificationModel' + _.random(0, 100)
      };
    };

    NotificationModel.prototype.save = function() {
      return console.log('Save locally');
    };

    return NotificationModel;

  })(Backbone.Model);
  AjNotificationModule = (function(_super) {
    __extends(AjNotificationModule, _super);

    function AjNotificationModule() {
      return AjNotificationModule.__super__.constructor.apply(this, arguments);
    }

    AjNotificationModule.prototype.initialize = function(options) {
      if (options == null) {
        options = {};
      }
      return AjNotificationModule.__super__.initialize.call(this, options);
    };

    return AjNotificationModule;

  })(Marionette.Module);
  return AjNotificationModule;
});
