define(['underscore', 'jquery-1.8.3.min', 'backbone'],
        function(_, $, Backbone, ModalView) {

            var Manage = {};

            Manage.templates = {
            };



            /*
             *
             *   BACKBONE MODELS
             *
             *
             */
            Manage.User = Backbone.Model.extend({
                defaults: {
                    role_names: "",
                    total: ""
                },
                url: function() {

                    return  '../wp-content/themes/minyawns/templates/profile/api/index.php/users';
                }
            });

            Manage.UserCollection = Backbone.Collection.extend({
                model: Manage.User,
                url: function() {
                    return '../wp-content/themes/minyawns/templates/profile/api/index.php/users';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }

            });
            Manage.UserDetailsCollection = Backbone.Collection.extend({
                model: Manage.User,
                url: function() {
                    return '../wp-content/themes/minyawns/templates/profile/api/index.php/users';
                },
                parse: function(response) {

                    this.total = response.total;
                    return response.data;
                }

            });


            /*====================================================================================================================================
             END OF MODELS
             
             BEGIN VIEWS
             ====================================================================================================================================*/





            /*
             *
             *
             *    BACKBONE VIEWS
             *
             *
             *
             */
            Manage.ProfileContianerView = Backbone.View.extend({
                el: '#profile-view',
                initialize: function() {

                    _.bindAll(this, 'render', 'profile_edit');
                    this.userdetails = new Manage.UserDetailsCollection();
                }, events: {
                    'change #roles-drop-down': function(e) {
                        this.select_role(e);

                    },
                    'click #edit-profile': 'profile_edit'


                },
                render: function() {
                    var self = this;
                    $("#loader1").show();
                    var template = _.template($("#user-avatar").html());
                    var html = template();//response.toJSON()
                    $(self.el).append(html);
                   // $('#bread_link').children().remove();
                    $("#bread-crumbs-id").append("<a href='#profile'>" + self.options.breadcrumb + "</a>");
                    this.userdetails.fetch({
                        data: {
                            'action': 'fetch',
                            'user_id': $("#current_user").val()
                        },
                        reset: true,
                        success: function(model, response) {
                            var template = _.template($("#user-profile").html());
                            var html = template(response.data);//response.toJSON()
                            $(self.el).append(html);

                            /*
                             *  user votes
                             * 
                             */
                            var template = _.template($("#user-votes").html());
                            var html = template();//response.toJSON()
                            $(self.el).append(html);
                            $("#loader1").hide();
                            
                            /*
                             *  user history
                             * 
                             */
                            var template = _.template($("#history-row").html());
                           $("#no-more-tables").find('table tbody').append(template);
                           $("#loader1").hide();
                        }
                    });





                    


                }, profile_edit: function() {
                    var profile_edit_view = new Manage.ProfileEditContianerView({'breadcrumb': 'Edit Profile'});
                    profile_edit_view.render();
                }

            });

            Manage.ProfileEditContianerView = Backbone.View.extend({
                el: '#main-content',
                initialize: function() {

                    _.bindAll(this, 'render', 'save_user_details');
                    this.usercollection = new Manage.UserCollection();

                }, events: {
                    'click #update-profile-button': 'save_user_details'
                },
                render: function() {

                    var self = this;
                    $("#bread-crumbs-id").append("<a href='#edit'>" + self.options.breadcrumb + "</a>");
                    $(self.el).find("#profile-view").remove();
                    $(self.el).find("#my-history").remove();
                    var template = _.template($("#edit-profile").html());
                    var html = template();//response.toJSON()
                    $(self.el).append(html);
                }, save_user_details: function() {
                    alert("dave");
                    var self = this;
                    this.usercollection.fetch({
                        data: {
                            'first_name': $("#inputFirst").val(),
                            'last_name': $("#inputlast").val(),
                            'college': $("#inputcollege").val(),
                            'major': $("#inputmajor").val(),
                            'skill': $("#tagsinput").val(),
                            'body': $("#inputbody").val(),
                            'url': $("#LinkedIn").val(),
                            'current_user': $("#current_user").val()
                        },
                        reset: true,
                        success: function(model, response) {

                            if (response.status == "success")
                            {
                                $("#edit-user-profile").remove();
                                $('#main-content').append("<div id='profile-view' class='row-fluid min_profile'></div>");
                                var profile_view = new Manage.ProfileContianerView({'breadcrumb': 'My Profile'});
                                profile_view.render();
                                $("#main-content").append($("#user-history-table").html());
                            }


                            //self.create_pagination_useraccess(self.collection.total,self.offset);
                        },
                        error: function(err) {
                            //console.log(err);
                        }
                    });

                }
            });



            return Manage;

        });


