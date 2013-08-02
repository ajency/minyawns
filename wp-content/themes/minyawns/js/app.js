require.config({
    urlArgs: "v=" + (new Date()).getTime(),
    shim: {
        'jquery-1.8.3.min': {
            exports: "$"
        },
        'underscore': {
            exports: "_"
        },
        'backbone': {
            deps: ['underscore', 'jquery-1.8.3.min'],
            exports: 'Backbone'
        },
        'bootstrap.min': {
            deps: ['jquery-1.8.3.min']
        },
        'custom': {
            deps: ['jquery-1.8.3.min']
        },
        'bootstrap-select': {
            deps: ['jquery-1.8.3.min']
        },
        'flatui-checkbox': {
            deps: ['jquery-1.8.3.min']
        },
        'flatui-radio': {
            deps: ['jquery-1.8.3.min']
        },
        'jquery.tagsinput': {
            deps: ['jquery-1.8.3.min']
        },
        'jquery.placeholder': {
            deps: ['jquery-1.8.3.min']
        },
        'jquery.stacktable': {
            deps: ['jquery-1.8.3.min']
        }
    }
});
var ProfileView = {};
require([
    'jquery-1.8.3.min',
    'underscore',
    'backbone',
    '../templates/profile/js/profile',
    'bootstrap.min',
    'bootstrap-select',
    'flatui-checkbox',
    'flatui-radio',
    'jquery.tagsinput',
    'jquery.placeholder',
    'jquery.stacktable',
],
        function($, _, Backbone, Profile) {


            ProfileView = Backbone.Router.extend({
                routes: {
                    "": "roles", // #users
                    "profile": "profile"

                }, profile: function(routes)
                {
                    var profile_view = new Profile.ProfileContianerView({'breadcrumb': 'Dashboard'});
                    profile_view.render();

                }
            });
            $(function() {
                new ProfileView();
                Backbone.history.start();
            });



        });
