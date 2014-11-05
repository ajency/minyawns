(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var AjNotificationModule, Backbone, Marionette, MessageBoardCtrl, NotificationModel, _,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

_ = require('underscore');

Marionette = require('backbone.marionette');

Backbone = require('backbone');

NotificationModel = require('./entities/notificationmodel.coffee');

MessageBoardCtrl = require('./controllers/messageboardctrl.coffee');

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

  AjNotificationModule.prototype.onStart = function() {
    return Marionette.run({
      region: this.app.sideBar,
      ctrl: 'MessageBoardCtrl',
      args: {
        objectId: 23,
        posttype: 'job',
        style: 'default'
      }
    });
  };

  return AjNotificationModule;

})(Marionette.Module);

module.exports = AjNotificationModule;



},{"./controllers/messageboardctrl.coffee":4,"./entities/notificationmodel.coffee":5,"backbone":"backbone","backbone.marionette":"backbone.marionette","underscore":"underscore"}],2:[function(require,module,exports){
var $, Backbone, Marionette, Mustache, _;

$ = require("jquery");

require("backbone").$ = $ || jQuery;

Backbone = require("backbone");

Mustache = require("mustache");

Marionette = require("backbone.marionette");

_ = require('underscore');

_.templateSettings = {
  evaluate: /\{\[([\s\S]+?)\]\}/g,
  interpolate: /\{\{([\s\S]+?)\}\}/g
};

Marionette._ctrl = {};

Marionette.run = function(options) {
  var CtrlClass;
  CtrlClass = Marionette._ctrl[options['ctrl']];
  return new CtrlClass({
    region: options['region'],
    options: options['args']
  });
};

Marionette.Renderer.render = function(template, data) {
  if (!template) {
    template = '';
  }
  if (typeof template === "function") {
    template = template();
  }
  return Mustache.to_html(template, data);
};



},{"backbone":"backbone","backbone.marionette":"backbone.marionette","jquery":"jquery","mustache":"mustache","underscore":"underscore"}],3:[function(require,module,exports){
var AjNotificationModule, Backbone, Marionette, Mustache;

require("./ajency.marionette.core.coffee");

Backbone = require("backbone");

Mustache = require("mustache");

Marionette = require("backbone.marionette");

AjNotificationModule = require("./aj-notification.coffee");

window.app = new Marionette.Application();

app.addRegions({
  main: "#main-region",
  sideBar: "#sidebar-region"
});

app.module("aj-notification", AjNotificationModule);

app.start();

Backbone.history.start();

module.exports = app;



},{"./aj-notification.coffee":1,"./ajency.marionette.core.coffee":2,"backbone":"backbone","backbone.marionette":"backbone.marionette","mustache":"mustache"}],4:[function(require,module,exports){
var Backbone, Marionette, MessageBoardCtrl, NotificationView, _,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

Backbone = require('backbone');

_ = require('underscore');

Marionette = require('backbone.marionette');

NotificationView = require('../views/notificationview.coffee');

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
      'template': '<h2>New templae</h2>'
    }));
  };

  return MessageBoardCtrl;

})(Marionette.Controller);

Marionette._ctrl['MessageBoardCtrl'] = MessageBoardCtrl;

module.exports = MessageBoardCtrl;



},{"../views/notificationview.coffee":6,"backbone":"backbone","backbone.marionette":"backbone.marionette","underscore":"underscore"}],5:[function(require,module,exports){
var Backbone, NotificationModel, _,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

Backbone = require('backbone');

_ = require('underscore');

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

module.exports = NotificationModel;



},{"backbone":"backbone","underscore":"underscore"}],6:[function(require,module,exports){
var IView, Marionette, NotificationView, _,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

Marionette = require('backbone.marionette');

_ = require('underscore');

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

module.exports = NotificationView;



},{"backbone.marionette":"backbone.marionette","underscore":"underscore"}]},{},[3]);
