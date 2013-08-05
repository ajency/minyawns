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

                    _.bindAll(this, 'render');
                    this.userdetails = new Manage.UserDetailsCollection();
                }, events: {
                    'change #roles-drop-down': function(e) {
                        this.select_role(e);

                    },
                        },
                render: function() {
                    var self = this;
                    $("#loader1").show();
                    var template = _.template($("#user-avatar").html());
                    var html = template();//response.toJSON()
                    $(self.el).append(html);
                   $("#bread-crumbs-id").empty();
                    $("#bread-crumbs-id").append("<a href='#'>View All jobs</a><a href='#profile'>" + self.options.breadcrumb + "</a>");
                    this.userdetails.fetch({
                        data: {
                            'action': 'fetch',
                            'user_id': $("#current_user").val()
                        },
                        reset: true,
                        success: function(model, response) {
                            
                            var template = _.template($("#user-profile").html());
                            console.log(response.data);
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
                           //$("#my-history").show();
                            var template = _.template($("#history-row").html());
                           $("#no-more-tables").find('table tbody').html(template);
                           $("#loader1").hide();
                        },error:function(e)
                        {
                           
                        }
                    });
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
                    $(self.el).find("#profile-view").hide();
                    $(self.el).find("#my-history").hide();
                    
                    var template = _.template($("#edit-profile").html());
                    var html = template();//response.toJSON()
                    $(self.el).append(html);
                }, save_user_details: function() {
                   
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
                            'current_user': $("#current_user").val(),
                            'user_skills':$("#user_skills").val()
                        },
                        reset: true,
                        success: function(model, response) {

                            if (response.status == "success")
                            {
                                $("#edit-user-profile").remove();
                              
                            }
                     
                        },
                        error: function(err) {
                           
                        }
                    });

                }
            });



            return Manage;

        });


