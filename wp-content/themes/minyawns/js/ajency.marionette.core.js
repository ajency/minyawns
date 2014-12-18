
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