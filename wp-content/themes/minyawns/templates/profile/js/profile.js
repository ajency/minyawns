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
            Manage.UserRoles = Backbone.Model.extend({
                defaults: {
                    role_names: "",
                    total: ""
                },
                url: function() {

                    return  '../wp-content/themes/phoenix/templates/manage/api/index.php/roles';
                }
            });


            Manage.UserCapbGroup = Backbone.Model.extend({
                defaults: {
                    role_names: "",
                    total: ""
                },
                url: function() {

                    return  '../wp-content/themes/phoenix/templates/manage/api/index.php/capb-group/' + this.get('group_id');
                }
            });

            Manage.CheckCapbGroup = Backbone.Model.extend({
                defaults: {
                    role_names: "",
                    total: ""
                },
                url: function() {

                    return  '../wp-content/themes/phoenix/templates/manage/api/index.php/check-capb-group';
                }
            });

            Manage.OperationsCapbGroup = Backbone.Model.extend({
                defaults: {
                    role_names: "",
                    total: ""
                },
                url: function() {

                    return  '../wp-content/themes/phoenix/templates/manage/api/index.php/capb-operations';
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
                    this.userrolecollection = new Manage.CheckCapbGroup();
                }, events: {
                    'change #roles-drop-down': function(e) {
                        this.select_role(e);

                    },
                    'click #edit-profile': 'profile_edit'


                },
                render: function() {
                    var self = this;

                    var template = _.template($("#user-avatar").html());
                    var html = template();//response.toJSON()
                    $(self.el).append(html);

                    var template = _.template($("#user-profile").html());

                    //_.each(model.data, function(role, index) {
                    var html = template();//response.toJSON()
                    $(self.el).append(html);

                    var template = _.template($("#user-votes").html());

                    //_.each(model.data, function(role, index) {
                    var html = template();//response.toJSON()
                    $(self.el).append(html);


                    var template = _.template($("#history-row").html());
                    $("#no-more-tables").find('table tbody').append(template);


                }, profile_edit: function() {
                    var sel = this;
                    this.subview.render();
                }

            });

            Manage.ProfileEditContianerView = Backbone.View.extend({
                el: '#main-content',
                initialize: function() {

                    _.bindAll(this, 'render');

                },
                render: function() {
                    alert("render");
                    var self = this;
                    $(self.el).find("#profile-view").remove().find(".row-fluid").remove();
                    var template = _.template($("#edit-profile").html());
                    var html = template();//response.toJSON()
                    $(self.el).html(html);
                }
            });



            return Manage;

        });


