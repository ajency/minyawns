require.config({
	path    : '../../js/',
	urlArgs : "v=" + (new Date()).getTime(),
	shim : {
		'jquery' : {
			exports : "$"
		},
		'underscore' : {
			exports : "_"
		},
		'backbone' : {
			deps : [ 'underscore', 'jquery' ],
			exports : 'Backbone'
		},
		'bootstrap.min' : {
			deps : [ 'jquery' ]
		},
		'custom' : {
			deps : [ 'jquery' ]
		},
		'bootstrap-select' : {
			deps : [ 'jquery', 'bootstrap.min' ]
		},
		'flatui-checkbox' : {
			deps : [ 'jquery' ]
		},
		'flatui-radio' : {
			deps : [ 'jquery' ]
		},
		'jquery.tagsinput' : {
			deps : [ 'jquery' ]
		},
		'jquery.placeholder' : {
			deps : [ 'jquery' ]
		},
		'bootstrap-switch' : {
			deps : [ 'jquery' ]
		},
		'jquery.validate.min' : {
			deps : [ 'jquery' ]
		},
		'awm-custom' : {
			deps : [ 'jquery', 'jquery.validate.min' ]
		},
		'bootstrap-tagmanager' : {
			deps : [ 'jquery', 'bootstrap.min' ]
		}

	}
});
var ProfileView = {};
require([ 'jquery', 'underscore', 'backbone'], 
		function($, _, Backbone, Profile) {
			
			var Job = Backbone.Model.extend({
							
						url : function(){
							return SETURLHERE;
						},
			
						validate : function(attr){
							
							var errors = [];
							//perform validations here
							if(attr.title == '')
								errors.push("Please enter a title");
							//if(//other conditions)
							
							return errors;
							
						}	
				
					  });
			
			$('#add-job-submit').click(function(evt){
				
				evt.preventDefault();
				
				var data = {};
				
				//collect all form infomation
				data.title = $('#titlefield').val();
				//more fields
				
				
				var job = new Job();
				
				var errors = job.validate();
				
				if(errors.length > 0)
					//show error messages on form. 'errors' will hold all errors
				else
					job.save(data); //handle success of save to show success message
				
				
			});
			
	
		});
