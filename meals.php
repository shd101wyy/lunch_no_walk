<html>
    <?php 
        $wechatid = $_GET["wechatid"];
        $pickup_location = $_GET["pickup_location"];
    ?>
    <head>
        <title>
            Meals
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes"> <!-- iOS full screen -->
        <meta name="mobile-web-app-capable" content="yes"> <!-- android full screen -->
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css">
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
    </head>
    <body>
        <div data-role="page" id="meal_page">
            <!-- <div data-role="header">
                <h1>
                    Meal A
                </h1>
            </div> -->
            <div data-role="main" class="ui-content">
                <h3 id="time"></h3>
                <ul data-role="listview" data-inset="true" id="menu_list">
                    <!-- Show menu information here -->
                </ul>
            </div>
            <!-- Footer -->
            <div data-role="footer"  data-position="fixed">	
                   <div data-role="navbar">
                      <ul>
                         <!-- <li><a href="#meal_page">Menus</a></li> -->
                         <li><a href="#order_history_page" data-transition="slidefade">My Orders</a></li>
                         <li><a href="#settings_page" data-transition="slidefade">Settings</a></li>
                      </ul>
                   </div><!-- /navbar -->
            </div><!-- /footer -->
            
        </div>
          
        
        <!-- Order History Page -->
        <div data-role="page" id="order_history_page">
            <div data-role="main" class="ui-content">
                <p> Show User's Order History Here <br>
                    Delete current orders
                </p>
            </div>
        </div>
        <!-- Personal Settings -->
        <div data-role="page" id="settings_page">
            <div data-role="main" class="ui-content">
                <p>
                    Allow User to change personal information, like pickup location.
                </p>
            </div>
        </div>
        
        
        <!-- Menu Information -->
        <div data-role="page" id="menu_info">
            <div data-role="header">
                <h1 id="menu_num">
                    Meal A
                </h1>
            </div>   
            <div data-role="main" class="ui-content">
                <img id="menu_pic" src="images.jpeg" width="40%", height="40%">
                <p> 宫爆鸡丁， 蒜蓉生姜菜 </p>
                <!-- 下拉菜单 pickup location -->
                <fieldset class="ui-field-contain">
                    <label for="pickup_location"> Select one of the location most close to you: </label>
                    <select name="pickup_location" id="pickup_location">
                        <!-- Fill In later using JavaScript -->
                    </select>
                </fieldset>
                
                <!-- 下拉菜单 点餐数量 -->
                <!-- 下拉菜单 -->
                <fieldset class="ui-field-contain">
                    <label for="order_num"> Select how many meals you want to order: </label>
                    <select name="order_num" id="order_num">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </fieldset>
                
                <h4 id="menu_price">Price: $5.00 </h4>
                <button> Submit </button>
            </div>
        </div>
    </body>
    
    <script>
        $(document).ready(function(){
            // setup time
            var d = new Date();
            var weekday = new Array(7);
            weekday[0]=  "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";
            var n = weekday[(d.getHours() >= 14) ? ((d.getDay() + 1) % 7) : d.getDay()];
            $("#time").html(n + "'s Menus: <br>")
            
            /*
            * 
            * use php to read menus from server(meals)
            *
            */
            
            <?php
                // calculate weekday.
                $current_hour = date("H"); // 24小时制。
                if($current_hour >= 14)
                    $current_weekday = date("l", strtotime("+1 day"));
                else
                    $current_weekday = date("l"); // 如果比14点往后，算下一天的。

                $RESULT = "";
                // retrieve data from database
                // try connect to sql
                $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
                if (mysqli_connect_errno()){
                    $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
                    echo $RESULT;
                    exit;
                }
                $query_content = "SELECT * FROM meals WHERE week_day='$current_weekday'";
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
            ?>
            console.log("Get Data");
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
            console.log(data);
            for(var i = 0; i < data.length; i++){
                var d = data[i];
                var pic = d.image_path;
                var intro = d.introduction;
                var price = d.price;
                var id = d.id;
                // begin to create dom
                /*
                 <li>
                        <a href="#meal_A"  data-transition="slidefade"><img src="images.jpeg">
                            <h2> Meal A</h2>
                            <p> 宫爆鸡丁， 蒜蓉生姜菜</p>
                        </a>
                    </li>
                */
                var content = 
            "<li>" + 
                "<a onclick=\"check_menu('Meal " + (1 + i) + "', '" + pic + "', " + price + ", '" + id + "')\" " + 
                    "href='#menu_info' data-transition='slidefade'><img src='" + pic + "'>" + 
                    "<h2>Meal " + (1 + i) + "</h2>" + 
                    "<p>" + intro + "</p>" + 
                    "<p>$" + price + "</p>" +
                "</a>"+
            "</li>";
                $("#menu_list").append(content);
            }
            

            
            // set default pickup selection
            var pickup_location = "<?php echo $pickup_location; ?>"
            if(pickup_location[0] == "'" || pickup_location[0] == "\"")
                pickup_location = pickup_location.slice(1, pickup_location.length - 1);
            var pickup_location_selection_options = "";
            var locations = ["MNTL", "BIF", "RAL"];
            for(var i = 0; i < locations.length; i++){
                var l = locations[i];
                if(l == pickup_location){
                    pickup_location_selection_options += "<option selected='selected'>" + pickup_location + "</option>";
                }
                else{
                    pickup_location_selection_options += "<option>" + l + "</option>";
                }
            }
            
            $("#pickup_location").html(pickup_location_selection_options);
            
            
            // refresh listview
            $('ul').listview('refresh');
        })
    // check menu information
    // customers can buy meal from it.
    var check_menu = function(menu_num, pic, price, id){
        alert("click");
        $("#menu_num").html(menu_num);
        $("#menu_pic").attr("src", pic);
        $("#menu_price").html(price);
        $("#menu_info").attr("menu_id", id);
    }    
    
    </script>
</html>