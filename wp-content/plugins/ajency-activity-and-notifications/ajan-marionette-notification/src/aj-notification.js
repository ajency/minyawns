var AjNotificationModule,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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
