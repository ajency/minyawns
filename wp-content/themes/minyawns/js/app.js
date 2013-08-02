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
        }, 'bootstrap-switch': {
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
    'bootstrap-switch',
    'flatui-checkbox',
    'flatui-radio',
    'jquery.tagsinput',
    'jquery.placeholder',
    'jquery.stacktable'

],
        function($, _, Backbone, Profile) {


            ProfileView = Backbone.Router.extend({
                routes: {
                    "": "profile",
                    "profile": "profile"

                }, profile: function(routes)
                {
                    $("#profile-view").empty();
                    $("#no-more-tables").find("tbody").empty();
                    $('#main-content').append("<div id='profile-view' class='row-fluid min_profile'><div id='loader1' class='modal_ajax'></div></div>");
                    var profile_view = new Profile.ProfileContianerView({'breadcrumb': 'My Profile'});
                    profile_view.render();
                    $("#loader1").hide();
                    $("#loader2").hide();

                }
            });
            $(function() {
                new ProfileView();
                Backbone.history.start();
            });



        });
