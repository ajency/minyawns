var MessageBoardCtrl,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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
