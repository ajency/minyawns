 var discussion_container ;
 
    function interface(discussion_container){
 
    

     }
 
        
    // Mobile/Desktop Detection script
            (function(ua, w, d, undefined) {



                    filesToLoad = {
                    // CSS file that is loaded when in development mode
                    "dev-css": "css/desktop.css",
                    // CSS file that is loaded when in production mode
                    "prod-css": "css/desktop.min.css",
                    // Require.js configuration file that is also loaded when in development mode
                    "dev-js": { "data-main": "js/app/config/config.js", "src": "js/libs/require.js" },
                    // JavaScript initialization file that is loaded when in development mode
                    "dev-init": "js/app/init/DesktopInit.js",
                    // JavaScript file that is loaded when in production mode
                    "prod-init": "js/app/init/DesktopInit.min.js",
                    "prod-js": { "data-main": "js/app/config/config.js", "src": "js/libs/require.js" }
                };

                file = filesToLoad["dev-js"];
                    var script = d.createElement("script");
                                script.type = "text/javascript";
                                if (script.readyState) {  // IE
                                    script.onreadystatechange = function() {
                                        if (script.readyState == "loaded" || script.readyState == "complete") {
                                            script.onreadystatechange = null;
                                           // callback();
                                           console.log('callback2')
                                        }
                                    };
                                } else {  // Other Browsers
                                    script.onload = function() {
                                        //callback();
                                        //laod the initital page on require load

                                        require([AJANPLUGINPATH+filesToLoad["dev-init"]]);
                                    };
                                }
                                if(((typeof file).toLowerCase()) === "object" && file["data-main"] !== undefined) {
                                    script.setAttribute("data-main", AJANPLUGINPATH+file["data-main"]);
                                    script.async = true;
                                    script.src = AJANPLUGINPATH+file.src;
                                } else {
                                    script.src = AJANPLUGINPATH+file;
                                }
                          
                                d.getElementsByTagName("head")[0].appendChild(script);
                               
                                
                 
               

            })(navigator.userAgent || navigator.vendor || window.opera, window, document);
     



