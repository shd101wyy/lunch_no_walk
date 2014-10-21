<html>
    <head>
        <title>
            Administrator Page
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes"> <!-- iOS full screen -->
        <meta name="mobile-web-app-capable" content="yes"> <!-- android full screen -->
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css">
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
        <!--<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>-->
    </head>
    
    <body>
        <div data-role="page" id="administrator_page">
            <div data-role="header">
                <h1>
                    Administrator
                </h1>
            </div>
            <div data-role="main" class="ui-content" id="administrator_page_content">
                <ul data-role="listview" data-inset="true" id="my-list">
                </ul> 
            </div>  
        </div>
        
        <!-- Meal Settings Panel -->
        <div id="meal_settings_panel" data-role="page" data-dialog="true">
            <div data-role="main" class="ui-content">
                <h2> Meal Settings Panel </h2>
                <h4>
                    Monday
                </h4>
                
                <form id="post_form" action="change_meal_settings.php" method="post" data-ajax="false" enctype='multipart/form-data'>  
                    <!--<div class="ui-field-contain">-->
                        <label for="week_day">Meal for: </label>
                        <input type="text" name="week_day" id="week_day" value="Monday" data-clear-btn="true">
                        <label for="intro">Meal Introduction:</label>
                        <input type="text" name="intro" id="intro" value="西红柿炒鸡蛋, 土豆牛肉" data-clear-btn="true">
                        <br>
                        
                        <label for="uploadPics">Meal Picture:</label>
                        <input type="file"  name="uploadPics" accept="image/*" capture> 
                        <img id="meal_img" src="ichiban.png" width="80%" height="40%">
                        <br><br>
                        
                        <label for="price">Meal Price:</label>
                        <input type="text" name="price" id="price" value="6" data-clear-btn="true">
                    <!--</div>-->
                    <input type="submit" data-icon="check" data-iconpos="right" data-inline="true" style="background:#2E64FE;" value="Save"> 
                </form>

                <a id="delete_button" href="#confirm_delete" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-icon-check ui-btn-icon-left ui-btn-inline ui-mini ui-icon-delete" style="background:#DF0101;" data-rel="popup"> Delete </a>
                <a href="#" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-inline ui-mini" data-rel="back">Cancel</a>
                
                <div data-role="popup" id="confirm_delete">
                    <p>Are u sure u want to delete this meal.</p>
                    <a href="#confirm_delete" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-icon-check ui-btn-icon-left ui-btn-inline ui-mini ui-icon-delete" style="background:#DF0101;">Yes, Delete</a>
                    <a href="#" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-inline ui-mini" data-rel="back"> No. </a>
                </div>
            </div>
        </div>
        
        
        
    </body>
    
    <script>
            
        $(document).ready(function(){
            var week_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
            /*
                Assume I have data in format like this:
            */
            var data = [
                {
                   date:"Monday",
                   meal_introductions: ["西红柿炒鸡蛋, 土豆牛肉", "红烧菜心, 芥兰牛"],
                   meal_pictures:     ["ichiban.png", "ichiban.png"],
                   prices: [6, 6]
                }, 
                {
                   date:"Tuesday",
                   meal_introductions: ["西红柿炒鸡蛋, 土豆牛肉", "红烧菜心, 芥兰牛"],
                   meal_pictures:     ["ichiban.png", "ichiban.png"],
                   prices: [6, 6]
                }, 
                {
                   date:"Wednesday",
                   meal_introductions: ["西红柿炒鸡蛋, 土豆牛肉", "红烧菜心, 芥兰牛"],
                   meal_pictures:     ["ichiban.png", "ichiban.png"],
                   prices: [6, 6]
                }, 
                {
                   date:"Thursday",
                   meal_introductions: ["西红柿炒鸡蛋, 土豆牛肉", "红烧菜心, 芥兰牛"],
                   meal_pictures:     ["ichiban.png", "ichiban.png"],
                   prices: [6, 6]
                }, 
                {
                   date:"Friday",
                   meal_introductions: ["西红柿炒鸡蛋, 土豆牛肉", "红烧菜心, 芥兰牛"],
                   meal_pictures:     ["ichiban.png", "ichiban.png"],
                   prices: [6, 6]
                }, 
                {
                   date:"Saturday",
                   meal_introductions: ["西红柿炒鸡蛋, 土豆牛肉", "红烧菜心, 芥兰牛"],
                   meal_pictures:     ["ichiban.png", "ichiban.png"],
                   prices: [6, 6]
                }, 
                {
                   date:"Sunday",
                   meal_introductions: ["西红柿炒鸡蛋, 土豆牛肉", "红烧菜心, 芥兰牛"],
                   meal_pictures:     ["ichiban.png", "ichiban.png"],
                   prices: [6, 6]
                }, 
                
            ]
            
            for(var i = 0; i < week_days.length; i++){
                var li = "<li data-role='list-divider'> " + 
                             "<div class='ui-grid-a'>" + 
                                "<div class='ui-block-a' style='margin-top:10px;'><h3>" + week_days[i] + "</h3></div>" +
                               "<div class='ui-block-b' style='text-align:right;'><a href='#meal_settings_panel' class='ui-btn ui-btn-inline ui-icon-plus ui-btn-icon-notext ui-corner-all ui-shadow' onclick='clickAddButton();'>add</a></div>" +
                             "</div>" + 
                         "</li>";
                $("#administrator_page_content ul").append(li);    // append to list
                
            
                var data_for_that_day = data[i]; 
                var meal_introductions = data_for_that_day.meal_introductions;
                var meal_pictures = data_for_that_day.meal_pictures;
                var meal_prices = data_for_that_day.prices;
                // iterate over meal_introduction and meal_pictures
                for(var j = 0; j < meal_introductions.length; j++){
                    var intro = meal_introductions[j];
                    var pic = meal_pictures[j];
                    var price = meal_prices[j];
                    
                    var page_id = week_days[i]+j+"_"+Math.random();
                
                    // show brief information of that meal
                    var li = "<li> <a href='#meal_settings_panel' data-transition='slidefade' onclick=\"clickEditButton('"+intro+"','"+pic+"',"+price+")\"><p>" + intro + "</p></a>" +  
                             "</li>";
                    $("#administrator_page_content ul").append(li);
                    
                    // create settings page for that day
                    var new_page = "<div data-role='page' id='"+page_id+"'>" +
                                    week_days[i] + 
                                    "</div>";
                    $("body").append(new_page);     
                }
            }
                                  
            // image upload refresh
            $("input[type=file]").change(function(){
                var file = $("input[type=file]")[0].files[0];
                alert(file.name + "\n" +
                      file.type + "\n" + 
                      file.size + "\n" + 
                      file.lastModifiedDate);
                reader = new FileReader();
                reader.onload = (function (theImg) {
                    return function (evt) {
                        theImg.src = evt.target.result;
                    };
                }(document.getElementById("meal_img")));
                reader.readAsDataURL(file);
            });
        
            $('ul').listview('refresh');

        });
         // clicked add button 
        var clickAddButton = function(){
            alert("You clicked me"); 
            // set default values for panel.
            $("#week_day").val("Monday");
            $("#price").val("7");
            $("#intro").val("Enter Meal Introduction Here");
            $("#post_form").attr("action", "restaurant_add_meal.php");
        }

        var clickEditButton = function(intro, pic, price){
            $("#price").val(price);
            $("#intro").val(intro);
            $("#meal_img").attr("src", pic);
        }
        
        
    </script>
</html>
