var IView, NotificationView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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
