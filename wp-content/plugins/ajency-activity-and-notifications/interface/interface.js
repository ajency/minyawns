    

var ajan_activity_stream_container ;

var ajan_post_data;

var ajan_component ;

var ajan_item_id ; 

var ajan_get_activities_uri;  

var ajan_post_activities_uri;

var ajan_get_comments_uri;

jQuery(document).ready(function($) {

    if ($("#ajan-activity-stream-container").length >0){

        console.log("ajan-activity-stream-container found")

            loadActivityStream($("#ajan-activity-stream-container"));

        }




}) 
            


        function loadActivityStream(container){ 

            ajan_activity_stream_container = "#"+container.attr("id")

            ajan_component = container.attr("component")  

            ajan_item_id = container.attr("item-id")  

            ajan_get_activities_uri = "/api/activities?type=get"

            ajan_post_activities_uri = "/api/activities"

            ajan_get_comments_uri = "/api/activities?type=get"
 
            //if(ajan_component!="" && ajan_component != undefined){

               // ajan_get_activities_uri += "&component="+ajan_component
            //} 

 
            if(ajan_item_id!="" && ajan_item_id != undefined){

                ajan_get_activities_uri += "&item_id="+ajan_item_id
            } 

            filesToLoad = {
                
                // Require.js configuration file that is also loaded when in development mode
                "require-js": { "data-main": "js/app/config/activity-stream-config.js", "src": "js/libs/require.js" },  
            };

            file = filesToLoad["require-js"];

            var script = document.createElement("script");

            script.type = "text/javascript";

            if(((typeof file).toLowerCase()) === "object" && file["data-main"] !== undefined) {

                script.setAttribute("data-main", AJANPLUGINPATH+file["data-main"]);

                script.async = true;

                script.src = AJANPLUGINPATH+file.src;

            } else {

                script.src = AJANPLUGINPATH+file;

            }

            document.getElementsByTagName("head")[0].appendChild(script);

        }

        function arr_diff(a1, a2)
            {
              var a=[], diff=[];
              for(var i=0;i<a1.length;i++)
                a[a1[i]]=true;
              for(var i=0;i<a2.length;i++)
                if(a[a2[i]]) delete a[a2[i]];
                else a[a2[i]]=true;
              for(var k in a)
                diff.push(k);
              return diff;
            }
