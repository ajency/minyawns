define  [
  "backbone"
  "marionette"
  "jquery"
  "jquerymobile"
  "hbs!templates/mobileHeader"],(Backbone, Marionette, $, jqm, template) ->
    return Backbone.Marionette.ItemView.extend
      template: template
        initialize:->
          _.bindAll(this)
        onRender:->
          @$el.navbar()
          return
