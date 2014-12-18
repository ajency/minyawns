var NotificationModel,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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
