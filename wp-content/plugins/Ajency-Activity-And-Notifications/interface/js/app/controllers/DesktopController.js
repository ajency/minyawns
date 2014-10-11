define(['App', 'backbone', 'marionette', 'views/WelcomeView', 'views/DesktopHeaderView'],
    function (App, Backbone, Marionette, WelcomeView, DesktopHeaderView) {
    return Backbone.Marionette.Controller.extend({
        initialize:function (options) {
            alert('initilizn controller')
            App.headerRegion.show(new DesktopHeaderView());
        },
        //gets mapped to in AppRouter's appRoutes
        index:function () {
            App.discussionRegion.show(new WelcomeView());
        }
    });
});