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
                
                <ul data-role="listview" data-inset="true" id="order_history_list">
                    <!-- Show user order here -->
                </ul>
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
                <img id="menu_pic" src="images.jpeg" width="100%", height="40%">
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
                
                <h4 id="menu_price">5.00 </h4>
                <button id="submit_button"> Submit </button>
            </div>
        </div>
    </body>
    
    <script>
        // global variable
        var wechatid = "<?php echo $wechatid; ?>"; // get wechatid
        if(wechatid[0] == "'" || wechatid[0] == '"') 
                wechatid = wechatid.slice(1, wechatid.length - 1); // remove ''
        var pickup_location = "<?php echo $pickup_location; ?>"
        if(pickup_location[0] == "'" || pickup_location[0] == "\"")
                pickup_location = pickup_location.slice(1, pickup_location.length - 1);
        var current_url = document.URL;
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
                // get menus today
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

                // get user order
                $query_content = "SELECT * FROM meal_order WHERE wechat_id='$wechatid'";
                $query_result = mysqli_query($cons, $query_content);
                if($query_result){
                    $my_array = array();
                    while($php_arr = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
                        $menu_id = $php_arr["menu_id"]; // get menu_id
                        // retrieve menu according to menu_id
                        
                        $query_for_menu = "SELECT * FROM meals WHERE id='$menu_id'";
                        $query_for_menu = mysqli_query($cons, $query_for_menu);
                        
                        $menu_data = mysqli_fetch_array($query_for_menu, MYSQLI_ASSOC);
                        
                        // add menu property to $php_arr.
                        $php_arr["menu"] = $menu_data;
                        array_push($my_array, $php_arr);
                    }
                    $js_array = json_encode($my_array);
                    $ORDER_HISTORY = $js_array;
                }
                else{
                    $ORDER_HISTORY = "Cannot connect to MySQL";
                }
            ?>
            console.log("Get Data");
            var data = <?php echo $RESULT; ?>;         // get menu data
            var order_history = <?php echo $ORDER_HISTORY; ?>;
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
            console.log(order_history);
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
            
            
            
            // set order history.  $("#order_history")
            for(var i = 0; i < order_history.length; i++){
                var o = order_history[i];
                /*
                * o is in format like:
                [Log] [ (meals.php, line 166)
                        Object
                            complete: "0"
                            menu: Object
                                id: "5445cf32b37da"
                                image_path: "uploads/ichiban.png"
                                introduction: "I am handsome"
                                price: "213"
                                week_day: "Wednesday"
                                __proto__: Object
                            menu_id: "5445cf32b37da"
                            order_id: "5446cb29cc3d9"
                            order_num: "1"
                            pickup_location: "MNTL"
                            wechat_id: "yiyi"
                            __proto__: Object
                        ]
                *
                */
                
                var complete = o.complete;
                var menu = o.menu;
                var order_id = o.order_id;
                var order_num = o.order_num;
                var pickup_location = o.pickup_location;
                var pic = menu.image_path;
                var intro = menu.introduction;
                var price = parseFloat(menu.price) * parseInt(order_num); // get total price.
                var content = 
            "<li>" + 
                "<h2> order id: " + order_id + "</h2>" + 
                "<p> menu: " + intro + "</p>" +  
                "<p> order num: " + order_num + "</p>" + 
                "<p> pickup location: " + pickup_location + "</p>" +
                "<p> total price: " + price + "</p>" + 
            "</li>";
                
                $("#order_history_list").append(content);
                
            }
            
            
            // refresh listview
            $('ul').listview('refresh');
        })
    // check menu information
    // customers can buy meal from it.
    var check_menu = function(menu_num, pic, price, id){
        $("#menu_num").html(menu_num);
        $("#menu_pic").attr("src", pic);
        $("#menu_price").html(" Price: $" + price);
        $("#menu_info").attr("menu_id", id);
    }    
    // clicked submit button
    // 下订单
    $("#submit_button").click(function(){ 
        var menu_id = $("#menu_info").attr("menu_id"); // get menu id  
        // var wechatid = wechatid; // get wechatid
        var pickup_location = $("#pickup_location option:selected").val(); // get pickup location
        var order_num = $("#order_num option:selected").val(); // get order num
        $.ajax({
                    url: "./submit_order.php",
                    async: false,
                    type: "POST",
                    // 下面是发送的信息
                    data:{menu_id: menu_id,
                          wechat_id: wechatid,
                          pickup_location: pickup_location,
                          order_num: order_num}
                }).done(function(data){
                    alert("Submit order successfully!: " + data);
                    window.location.replace(current_url); // reload page
                }).fail(function(data){
                    alert(data);
                });

    });
    
    
    
    </script>
</html>