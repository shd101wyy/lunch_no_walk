<html>
    <?php
        $RESULT = "";
        // retrieve data from database
        // try connect to sql
        $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
        if (mysqli_connect_errno()){
            $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
            echo $RESULT;
            exit;
        }
        $query_content = "SELECT * FROM meals";
        $query_result = mysqli_query($cons, $query_content);
        
        if($query_result){
            $my_array = array(); 
            while($php_arr = mysqli_fetch_array($query_result, /*MYSQLI_NUM*/MYSQLI_ASSOC)){
                array_push($my_array, $php_arr);
            }
            $js_array = json_encode($my_array);
            $RESULT = $js_array;
        }
        else{
            $RESULT = "Cannot connect to MySQL";
        }
        // echo $RESULT;
    ?>
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
        <style>
            .ui-input-text.ui-custom {
                border: none;
                box-shadow: none;
                font-weight: bold;
            }
        </style>
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
        
        <!-- Menu Settings Panel -->
        <div id="meal_settings_panel" data-role="page" data-dialog="true">
            <div data-role="main" class="ui-content">
                <h2> Menu Settings Panel </h2>
                <form id="post_form" action="change_meal_settings.php" method="post" data-ajax="false" enctype='multipart/form-data' onsubmit="return validateForm()">  
                    <!--<div class="ui-field-contain">-->
                        <input type="text" name="id" id="menu_id" style="display:none;" readonly>
                        <label for="week_day">Menu for: </label>
                        <input type="text" name="week_day" style="outline:none;" id="week_day" value="Monday" data-wrapper-class="ui-custom" readonly>
                        <label for="intro">Menu Introduction:</label>
                        <input type="text" name="intro" id="intro" value="西红柿炒鸡蛋, 土豆牛肉" data-clear-btn="true">
                        <br>
                        
                        <label for="uploadPics">Menu Picture:</label>
                        <input type="file"  name="uploadPics" accept="image/*" capture> 
                        <img id="meal_img" src="ichiban.png" width="80%" height="40%">
                        <br><br>
                        
                        <label for="price">Menu Price:</label>
                        <input type="text" name="price" id="price" value="6" data-clear-btn="true">
                    <!--</div>-->
                    <input type="submit" data-icon="check" data-iconpos="right" data-inline="true" style="background:#2E64FE;" value="Save"> 
                </form>

                <a id="delete_button" href="#confirm_delete" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-icon-check ui-btn-icon-left ui-btn-inline ui-mini ui-icon-delete" style="background:#DF0101;" data-rel="popup" name="used_to_save_delete_id"> Delete </a>
                <a href="#" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-inline ui-mini" data-rel="back">Cancel</a>
                
                <div data-role="popup" id="confirm_delete">
                    <p>Are u sure u want to delete this menu.</p>
                    <a onclick='delete_meal();' href="#confirm_delete" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-icon-check ui-btn-icon-left ui-btn-inline ui-mini ui-icon-delete" style="background:#DF0101;" name="used_to_save_delete_id">Yes, Delete</a>
                    <a href="#" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-inline ui-mini" data-rel="back"> No. </a>
                </div>
            </div>
        </div>
        
        
        
    </body>
    
    <script>
            
        $(document).ready(function(){
            var week_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
            var data = <?php echo $RESULT; ?>;
            /*
                data is like 
                [
                    Object
                    image_path: "uploads/ichiban.png"
                    introduction: "rice"
                    price: "7"
                    week_day: "Monday"
                    id: "..."
                    __proto__: Object
                , 
                    Object
                    image_path: "uploads/ichiban.png"
                    introduction: "gagagag"
                    price: "12"
                    week_day: "Monday"
                    id: "..."
                    __proto__: Object
                , 
                    Object
                    image_path: "uploads/ichiban.png"
                    introduction: ""
                    price: "0"
                    week_day: ""
                    id: "..."
                    __proto__: Object
                ]
            */
            console.log("显示");
            console.log(data);
            
            // initialize list-divisor from Monday to Sunday.
            for(var i = 0; i < week_days.length; i++){
                var li = "<li data-role='list-divider' id=\"" + week_days[i]  + "_divisor\"> " + 
                             "<div class='ui-grid-a'>" + 
                                "<div class='ui-block-a' style='margin-top:10px;'><h3>" + week_days[i] + "</h3></div>" +
                               "<div class='ui-block-b' style='text-align:right;'><a href='#meal_settings_panel' class='ui-btn ui-btn-inline ui-icon-plus ui-btn-icon-notext ui-corner-all ui-shadow' onclick='clickAddButton(\""+week_days[i]+"\");'>add</a></div>" +
                             "</div>" + 
                         "</li>";
                $("#administrator_page_content ul").append(li);    // append to list
            }
            
            // add data that we get from server
            for(var i = 0; i < data.length; i++){
                var d = data[i]; 
                /*
                    d is in format of :
                        image_path: "uploads/ichiban.png"
                        introduction: "rice"
                        price: "7"
                        week_day: "Monday"
                        id: "..."
                */
                var data_for_that_day = d.week_day;
                var intro = d.introduction;
                var pic = d.image_path;
                var price = d.price;
                var id = d.id;
                if(intro == "" || data_for_that_day == "" )
                    continue;
                console.log("Add data: " + data_for_that_day + " " + intro + " " + pic);
                
                // show brief information of that meal
                var li = "<li> <a href='#meal_settings_panel' data-transition='slidefade' onclick=\"clickEditButton('"+intro+"','"+pic+"',"+price+ ", '"  + id + "', '" + data_for_that_day +"');\"><p>" + intro + "</p></a>" +  
                             "</li>";
                $("#"+data_for_that_day+"_divisor").after(li);
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
        var clickAddButton = function(week_day){
            // set default values for panel.
            $("#week_day").val(week_day);
            $("#price").val("7");
            $("#intro").val("Enter Meal Introduction Here");
            $("#post_form").attr("action", "restaurant_add_menu.php");
            $("#delete_button").hide();
        }

        var clickEditButton = function(intro, pic, price, id, week_day){
            $("#week_day").val(week_day);
            $("#price").val(price);
            $("#intro").val(intro);
            $("#meal_img").attr("src", pic);
            $("#delete_button").show();
            $("#delete_button").attr("name", id);
            $("#menu_id").val(id); 
            $("#post_form").attr("action", "restaurant_update_menu.php");
        }
        var delete_meal = function(){
            var id = $("#delete_button").attr("name");
            // post to restaurant_delete_meal.php to delete meal
            $.ajax({
                    url: "./restaurant_delete_menu.php",
                    async: false,
                    type: "POST",
                    // 下面是发送的信息
                    data:{id: id} 
                }).done(function(data){
                    alert("Delete Successfully:");
                    location.reload();
                }).fail(function(data){
                    alert(data);
                })
        }
        
        // check content valid
        var validateForm = function(){
            
            // check intro is valid
            var intro = $("#intro").val();
            for(var i = 0; i < intro.length; i++){
                if(intro[i] == "'" || intro[i] == "\""){
                    alert("Menu Intro contains invalid character: " + intro[i]);
                    return false;
                }
            }
            // check price is numeric
            var price = $("#price").val();
            if(isNaN(price)){
                alert("Invalid price: " + price);
                return false;
            }
            return true;
        }
        
        
    </script>
</html>
