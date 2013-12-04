jQuery(document).ready(function($) {

//$('.minyawnslist').jscroll({
//    loadingHtml: '<img src="loading.gif" alt="Loading" /> Loading...',
//    padding: 20,
//    nextSelector: 'a.jscroll-next:last',
//    contentSelector: 'li',
//    debug:true,
//    autoTriggerUntil:true
//    
//    });



//$("#searchbox").fcbkcomplete({
//json_url: SITEURL + '/wp-content/themes/minyawns/libs/minyawndir.php/allminyawns',
//cache: true,
//filter_case: true,
//filter_hide: true,
//newel: true
//});

    fetch_minyawns_list();

//$("#searchbox").keyup(function(){
//    
//    searchString();
//    
//});


});


function fetch_minyawns_list() {

    
    
     var no_result = _.template($("#loader-image").html());
     jQuery(".minyawnslist").html(no_result);
     

    var first = getUrlVars()["filter"];

    var MinyawnsDir = Backbone.Collection.extend({
        // model: MDirModel,
        url: function() {

            return SITEURL + '/wp-content/themes/minyawns/libs/minyawndir.php/allminyawns'
        }
    });

    var _data = {
        'offset': 0,
    };
    if (typeof(first) !== 'undefined')
        _data.filter = first;



//     if (typeof(first) !== 'undefined')
//        _data.filter = first;

    window.verified_users = {};
    window.count = 0;
    window.total = 0;
    window.minyawndir = new MinyawnsDir();
    window.minyawndir.fetch({
        data: _data,
        reset: true,
        success: function(collection, response) {

            if (response.error !== '404') {
                var template = _.template(jQuery("#minyawn-directory-card").html());
                
             
                
                _.each(collection.models, function(model) {
                            
                    var html = template({result: model.toJSON()});
                    jQuery(".minyawnslist").append(html);

                    window.total = model.toJSON().total;

                    create_verified_array(model.toJSON());


                });

                if (window.total === window.minyawndir.length) {


                } else {
                    var load_more_template = _.template(jQuery("#load-more").html());
                    jQuery(".minyawns-grid1").append(load_more_template);
                }


            } else
            {

                var no_result = _.template($("#no-result-minyawn-dir").html());
                jQuery(".minyawnslist").append(no_result);

            }
              jQuery(".minyawns-grid1").find('.load_ajax_large').remove(); //remove loader after load more completes
        }
    });

}


function searchString()
{

    var MinyawnsSearch = Backbone.Collection.extend({
        // model: MDirModel,
        url: function() {

            return SITEURL + '/wp-content/themes/minyawns/libs/minyawndir.php/searchAllminyawns'
        }
    });


    var self = this;
    window.MinyawnsSearch.fetch({
        data: {
            // 'offset': self.offset,
            'term': $("#searchbox").val()
        },
        reset: true,
        success: function(model, response) {
            alert("heyup");
        },
        error: function(err) {
            //console.log(err);
        }

    });




}

function formSubmit()
{

    alert("form submited");

}


/*
 *  CLICK FOR LOAD MORE BUTTON 
 * 
 *  MINYAWN DIRECTORY
 */


$("#load_more").live('click', function() {
   
 var filter_loader_template = _.template(jQuery("#filters-loader-image").html());
   jQuery(".minyawns-grid1").append(filter_loader_template);
  
    var first = getUrlVars()["filter"];

    var _data = {
        'offset': window.minyawndir.models.length,
    };

    if (typeof(first) !== 'undefined')
        _data.filter = first;

   var counter=0;
    window.minyawndir.fetch({
        data: _data,
        remove: false,
        add: true,
        success: function(collection, response) {

            if (response.error !== '404') { //if no results returned
                var template = _.template(jQuery("#minyawn-directory-card").html());
                
                jQuery(".minyawnslist").empty();
                _.each(collection.models, function(model) {
                    console.log(collection.models);
                    var html = template({result: model.toJSON()});
   
                    jQuery(".minyawnslist").append(html);

                    window.total = model.toJSON().total;
                });

                //if(window.minyawndir.models.length === model.toJSON.)
                if (window.total === window.minyawndir.length) { //check to show load more button if total returned == model length hide the button

                    jQuery("#load_more").hide();
                } else {

                    //shwo the load more
                }


            } else
            {

                jQuery("#load_more").hide();

            }
        }

    });
    
  setTimeout(function(){ jQuery(".minyawns-grid1").find('#filters-loader').remove()},1000); //remove loader after load more completes

});

function remove_filter()
{
    window.location = siteurl + '/minyawns-directory/';

}

function create_verified_array(modelTojson)
{
    var user_id = '';

    $.each(modelTojson, function(index, value) {



        if (index == 'user_id') {
            user_id = value;

        }

        if (index === 'user_verified' && value === 'N') {
            window.count = window.count + 1;
            window.verified_users[user_id] = value;

        }


        // do your stuff here
    });




}


$(".checkbox").live('click', function() {

   


  var filter_loader_template = _.template(jQuery("#filters-loader-image").html());
   jQuery(".minyawns-grid1").append(filter_loader_template);
   

    if ($("#checkbox-verified").attr("checked") === 'checked')
    {
        $.each(window.verified_users, function(index, value) {

            $("#minyawn" + index).hide();
            
        });


    }
    else
    {
        $.each(window.verified_users, function(index, value) {

            $("#minyawn" + index).show();
           
        });
    }
    
   setTimeout(function(){ jQuery(".minyawns-grid1").find('#filters-loader').remove()},1000); 
    
     if (window.count === window.total)
    {
        var no_result = _.template($("#no-result-verfied-minyawn-dir").html());
        jQuery(".minyawnslist").append(no_result);
        return;
    }
});
