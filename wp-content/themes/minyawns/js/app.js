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
            deps: ['jquery-1.8.3.min','bootstrap.min']
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
        }, 'bootstrap-switch': {
            deps: ['jquery-1.8.3.min']
        }, 'jquery.validate.min': {
            deps: ['jquery-1.8.3.min']
        },
        'awm-custom':{
            deps:['jquery-1.8.3.min','jquery.validate.min']
        }

    }
});
var ProfileView = {};
require([
    'jquery-1.8.3.min',
    'underscore',
    'backbone',
    '../templates/profile/js/profile',
    'jquery.validate.min',
    'awm-custom',
    'bootstrap.min',
    'bootstrap-select',
    'bootstrap-switch',
    'flatui-checkbox',
    'flatui-radio',
    'jquery.tagsinput',
    'jquery.placeholder',
    
  

],
        function($, _, Backbone, Profile) {


            ProfileView = Backbone.Router.extend({
                routes: {
                    "": "profile",
                    "profile": "profile",
                    "logout": "logout",
                    "edit": "edit",
                    "update": "profile"
                }, profile: function(routes)
                {
                    $("#profile-view").show();
                    $("#my-history").show();
                    $("#profile-view").empty();
                    //$("#my-history").empty();
                    $("#edit-user-profile").remove();


//                    $("#no-more-tables").find("tbody").empty();
                    //$('#main-content').append("<div id='profile-view' class='row-fluid min_profile'></div>");
                    var profile_view = new Profile.ProfileContianerView({'breadcrumb': 'My Profile'});
                    profile_view.render();

                    $("#loader1").hide();
                    $("#loader2").hide();

                }, edit: function()
                {
                    var profile_edit_view = new Profile.ProfileEditContianerView({'breadcrumb': 'Edit Profile'});
                    profile_edit_view.render();
                    $('#tags').tagsInput({
                        'defaultText': 'add a skill',
                        'onAddTag': onAddTag,
                        'onRemoveTag': onRemoveTag,
                    });
                    $("#tags_tag").width("80px");


                }, logout: function()
                {
                    alert("logged");
                    $.ajax({
                        url: "../wp-content/themes/minyawns/templates/profile/api/index.php/logout",
                        success: function() {

                        }});
                }
            });
            $(function() {
                new ProfileView();
                Backbone.history.start();


            });

            function onAddTag(tag) {/*adds tags from the hidden field*/
                var $keywords = $("#tags").siblings(".tagsinput").children(".tag");
                var tags = [];
                for (var i = $keywords.length; i--; ) {
                    tags.push($($keywords[i]).text().substring(0, $($keywords[i]).text().length - 1).trim());
                }

                /*Then if you only want the unique tags entered:*/
                var uniqueTags = $.unique(tags);

                $("#user_skills").val(uniqueTags);
            }
            function onRemoveTag(tag) { /*removes tags from the hidden field*/
                var $keywords = $("#tags").siblings(".tagsinput").children(".tag");
                var tags = [];
                for (var i = $keywords.length; i--; ) {
                    tags.push($($keywords[i]).text().substring(0, $($keywords[i]).text().length - 1).trim());
                }

                /*Then if you only want the unique tags entered:*/
                var uniqueTags = $.unique(tags);

                $("#user_skills").val(uniqueTags);
            }




        });
