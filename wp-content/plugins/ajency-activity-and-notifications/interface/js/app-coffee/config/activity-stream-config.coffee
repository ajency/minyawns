console.log "Loading Activit Stream Config...."  
require.config

  urlArgs : "bust=" + BUST
  baseUrl: AJANPLUGINPATH + "js"
  
  # 3rd party script alias names (Easier to type "jquery" than "libs/jquery, etc")
  # probably a good idea to keep version numbers in the file names for updates checking
  paths:
    
    # Core Libraries
    jquery: "libs/jquery"
    jqueryui: "libs/jqueryui"
    backbonesyphon: 'libs/plugins/backbone.syphon'
    jquerymobile: "libs/jquery.mobile"
    underscore: "libs/underscore"
    underscorestring  : 'libs/underscorestring'
    backbone: "libs/backbone"
    mustache      : 'libs/plugins/Mustache'
    marionette: "libs/backbone.marionette"
    marionetteconfig: "app/config/marionette"
    backboneconfig: "app/config/backbone"
    handlebars: "libs/handlebars"
    text        : 'libs/text'
    i18nprecompile: "libs/i18nprecompile"
    json2: "libs/json2"
    jasmine: "libs/jasmine"
    jasmine_html: "libs/jasmine-html"
    entitiesloader : "app/entities/activity-stream-entities-loader"
    activitystreaminit : "app/init/activity-stream-init"
    # Plugins
    backbone_validateAll: "libs/plugins/Backbone.validateAll"
    bootstrap: "libs/plugins/bootstrap"
    text: "libs/plugins/text"
    jasminejquery: "libs/plugins/jasmine-jquery",
    startapp :'app/activity-stream-app'

  
  # Sets the configuration for your third party scripts that are not AMD compatible
  shim: 
    underscore:
      exports : '_'
    jquery    : ['underscore']
    jqueryui  : ['jquery']
    backbone:
      deps  : ['jquery','underscore']
      exports : 'Backbone'
    backbonesyphon:
      deps  : ['backbone']
    marionette :
      deps  : ['backbone']
      exports : 'Marionette'
    # Twitter Bootstrap jQuery plugins
    bootstrap: ["jquery"] 
    text  :
      deps  : ['mustache','handlebars']
    
        
    #Handlebars
    handlebars:
      exports: "Handlebars"

    
    # Backbone.validateAll plugin that depends on Backbone
    "backbone_validateAll": ["backbone"]
 

  
 
require ['startapp','marionetteconfig','backboneconfig','activitystreaminit','entitiesloader'], (App,marionetteconfig,backboneconfig)->
  try
    App.start()
    #$(ajan_activity_stream_container).append("<br>Loading Activity Stream App.....")
  catch err
    
    $(ajan_activity_stream_container).append("<br>Error (config):"+err.message)
  