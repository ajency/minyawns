# include the ajency core plugin
# this will hold some of global config for all apps
# and plugin. all plugins and projects must include this
# file right after marionette.js
# sequence:
# 1- underscore.js or lodash.js
# 2- jQuery.js
# 3- Backbone.js
# 4- Backbone.Marionette.js
# 5- ajency.marionette.core.js
# 6- module
# 7- app.js
# more file later...
require "./ajency.marionette.core.coffee"

# Vendors
Backbone = require "backbone"
Mustache = require "mustache"
Marionette = require "backbone.marionette"

# Local
AjNotificationModule = require "./aj-notification.coffee"

# app bootstrap
window.app = new Marionette.Application()
app.addRegions
	main : "#main-region"
	sideBar : "#sidebar-region"

app.module "aj-notification", AjNotificationModule
app.start()
Backbone.history.start()

module.exports = app
