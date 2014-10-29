<html>
    <?php 
        $wechatid = stripslashes($_GET["wechatid"]);
        if($wechatid[0] === "'"){
            $wechatid = substr($wechatid, 1, -1);
        }
       
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
            exit;
        }

        // get user order
        $query_content = "SELECT * FROM meal_order WHERE wechat_id='$wechatid' ORDER BY order_date DESC";
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
            exit;
        }

        // get user info according to wechat id 
        $query_content = "SELECT * FROM user WHERE wechatid='$wechatid'";
        $query_result = mysqli_query($cons, $query_content);
        if($query_result){
            $USER_INFO = json_encode(mysqli_fetch_array($query_result, MYSQLI_ASSOC));
        }
        else{
            $USER_INFO = "\"Cannot connect to MySQL\"" . $query_content;
        }
        
    ?>
    <head>
        <title>
            Menus
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
                    Menu A
                </h1>
            </div> -->
            <div data-role="main" class="ui-content">
                <h3 id="time"></h3>
                <h3 id="rest_money">0</h3>
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
                <p> You can check your orders here <br>
                    You can cancel order here by clicking crossing button.
                </p>
                
                <ul data-role="listview" data-inset="true" id="order_history_list_incomplete">
                    <!-- Show user incomplete order here -->
                </ul>
                <ul data-role="listview" data-inset="true" id="order_history_list_complete">
                    <!-- Show user completed order here -->
                </ul>
                
            </div>
        </div>
        <!-- Personal Settings -->
        <div data-role="page" id="settings_page">
            <div data-role="main" class="ui-content">
                <p>
                   You can update your profile information here.
                </p>
                <!-- <h3> 请填写下面信息 </h3>
                Change information
                -->
                <!-- 姓 -->
                <label for="signup_user_last_name"> Last name: </label>
                <input type="text" id="signup_user_last_name" data-clear-btn="true">
                <!-- 名 --> 
                <label for="signup_user_first_name"> First name: </label>
                <input type="text" id="signup_user_first_name" data-clear-btn="true">             
                <!-- <label for="signup_username">姓名:</label>
                <input type="text" id="signup_username" data-clear-btn="true"> -->
                <!-- 电话 -->
                <label for="signup_phonenumber"> Cellphone number:</label>
                <input type="text" id="signup_phonenumber" data-clear-btn="true" name="signup_phonenumber">
                
                <!-- 下拉菜单 -->
                <fieldset class="ui-field-contain">
                    <label for="signup_pickup_location"> Select one of the location most close to you: </label>
                    <select name="signup_pickup_location" id="signup_pickup_location">
                      <!-- Location selections here -->
                    </select>
                </fieldset>
                <br>
                <button id="change_user_profile" data-inline="true">Update Profile</button> 
            </div>
        </div>
        
        
        <!-- Menu Information -->
        <div data-role="page" id="menu_info">
            <div data-role="header">
                <h1 id="menu_num">
                    Menu A
                </h1>
            </div>   
            <div data-role="main" class="ui-content">
                <img id="menu_pic" src="images.jpeg" width="100%", height="40%">
                <b id="menu_intro"> 宫爆鸡丁， 蒜蓉生姜菜 </b>
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
        <!-- Cancel Order -->
        <div data-role="page" id="delete_order" data-dialog="true">
          <div data-role="main" class="ui-content">
          <h3>Cancel Order</h3>
            <p>Are you sure you want to cancel this order?</p>
            <a href="#" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-icon-check ui-btn-icon-left ui-btn-inline ui-mini" id='delete_order_button'>Delete</a>
            <a href="#" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-inline ui-mini" data-rel="back">Cancel</a>
          </div>
        </div> 
    </body>
    
    <script>
        // global variable
        var wechatid = "<?php echo $wechatid; ?>"; // get wechatid
        if(wechatid[0] === "'" || wechatid[0] === "\""){
            wechatid = wechatid.slice(1, wechatid.length - 1); // remove ''
        }
        
        /*
        * user_info is in format like:
        [Log] Object (meals.php, line 142)
                administrator: "1"
                first_name: "Yiyi"
                last_name: "Wang"
                phone: "2176499936"
                pickup_location: "BIF"
                wechatid: "owHwut4vD3-Gf3WvMKKMBS-LFLIk"
                __proto__: Object

        */
        var user_info = <?php echo $USER_INFO; ?>;
        var pickup_location = user_info.pickup_location;
        //console.log(wechatid);
        //console.log(pickup_location);
        //console.log(user_info);
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
            * 显示余额
            */ 
            
            $("#rest_money").html("Money in Account: $"+user_info.money);
            /*
            * 
            * use php to read menus from server(meals)
            *
            */

            // console.log("Get Data");
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
            //console.log(data);
            //console.log(order_history);
            // the code below is for debug use.
            // $("#order_history_page").append(JSON.stringify(order_history));
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
                            <h2> Menu A</h2>
                            <p> 宫爆鸡丁， 蒜蓉生姜菜</p>
                        </a>
                    </li>
                */
                var content = 
            "<li>" + 
                "<a onclick=\"check_menu('Menu " + (1 + i) + "', '" + pic + "', " + price + ", '" + id + "', '" + intro + "')\" " + 
                    "href='#menu_info' data-transition='slidefade'><img src='" + pic + "'>" + 
                    "<h2>Menu " + (1 + i) + "</h2>" + 
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
                if(l === pickup_location){
                    pickup_location_selection_options += "<option selected='selected'>" + pickup_location + "</option>";
                }
                else{
                    pickup_location_selection_options += "<option>" + l + "</option>";
                }
            }
            $("#pickup_location").html(pickup_location_selection_options);
            $("#signup_pickup_location").html(pickup_location_selection_options);
            
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
                var order_date = new Date(parseInt(o.order_date));  // change order date from timestamp to
                var order_id = o.order_id;
                var order_num = o.order_num;
                var pickup_location_ = o.pickup_location;
                var pic = menu.image_path;
                var intro = menu.introduction;
                var price = parseFloat(menu.price) * parseInt(order_num); // get total price.
                var content;
                if(complete == 1){ // completed order
                    content = 
          "<li data-theme='b'>" + 
                    "<a href='#'>"+
                    "<img src='"+pic+"'>" +
                    "<h2>Completed Order: "+order_id+"</h2>" +
                    "<p>menu: " + intro + " <br> order num: " + order_num + " <br> date: " + order_date.toString() + " <br> pickup location: " + pickup_location_ + " <br> total price: " + price +"</p>" +
                    "</a>" + 
            "</li>";
                    $("#order_history_list_complete").append(content);  
                }
                else{ // incomplete order
                    content = 
            "<li >" + 
                    "<a href='#'>"+
                    "<img src='"+pic+"'>" +
                    "<h2>Incomplete Order: "+order_id+"</h2>" +
                    "<p>menu: " + intro + " <br> order num: " + order_num + " <br> date: " + order_date.toString() + "<br> pickup location: " + pickup_location_ + " <br> total price: " + price +"</p>" +
                    "</a>" + 
                    "<a onclick=\"click_split_button_delete('" + order_id + "');\" href='#delete_order'' data-transition='pop'' data-icon='delete'>Delete </a>" +
            "</li>";
                    $("#order_history_list_incomplete").append(content);   
                }                
            }
            
            // setup change profile page.
            $("#signup_user_last_name").val(user_info.last_name);
            $("#signup_user_first_name").val(user_info.first_name);
            $("#signup_phonenumber").val(user_info.phone);
            
            // refresh listview
            $('ul').listview('refresh');
        })
    // check menu information
    // customers can buy meal from it.
    var check_menu = function(menu_num, pic, price, id, intro){
        $("#menu_num").html(menu_num);
        $("#menu_pic").attr("src", pic);
        $("#menu_price").html(" Price: $" + price);
        $("#menu_info").attr("menu_id", id);
        $("#menu_intro").html(intro);
    }    
    // clicked submit button
    // 下订单
    $("#submit_button").click(function(){ 
        var menu_id = $("#menu_info").attr("menu_id"); // get menu id  
        // var wechatid = wechatid; // get wechatid
        var pickup_location2 = $("#pickup_location option:selected").val(); // get pickup location
        var order_num = $("#order_num option:selected").val(); // get order num
        $.ajax({
                    url: "./submit_order.php",
                    async: false,
                    type: "POST",
                    // 下面是发送的信息
                    data:{menu_id: menu_id,
                          wechat_id: wechatid,
                          pickup_location: pickup_location2,
                          order_num: order_num,
                          order_date: (+new Date).toString()}
                }).done(function(data){
                    alert("Submit order successfully!: " + data);
                    window.location.replace(current_url); // reload page
                }).fail(function(data){
                    alert(data);
                });
    });
        
    // update user profile
    $("#change_user_profile").click(function(){
        var last_name = $("#signup_user_last_name").val();
        var first_name = $("#signup_user_first_name").val();
        var phone = $("#signup_phonenumber").val();
        var pickup_location3 = $("#signup_pickup_location option:selected").val();
        // var wechatid = wechatid;
        // 发送到 update_profile.php
        $.ajax({
            url: "update_profile.php",
            async: false,
            type: "POST",
            // 下面是发送的信息
            data:{last_name: last_name,
                  first_name: first_name,
                  phone: phone,
                  pickup_location: pickup_location3,
                  wechatid: wechatid}
        }).done(function(data){
            alert(data);
            window.location.replace(current_url); // reload page
        }).fail(function(data){
            alert(data);
        })
    })
    // when change order num, update price
    $("#order_num").bind("change", function(){
        var price = $("#menu_price").html();
        price = parseFloat(price.slice(price.indexOf("$") + 1));
        var num = parseInt($("#order_num option:selected").val());
        price = price * num;
        $("#menu_price").html(" Price: $" + price);
    })
    // click delete button right side of the list
    var click_split_button_delete = function(id){
        $("#delete_order").attr("delete_id", id); // save the id we want to delete
    }
    // delete order
    $("#delete_order_button").click(function(){
        var delete_id = $("#delete_order").attr("delete_id"); // get order id that we want to delete
        $.ajax({
            url: "user_cancel_order.php",
            async: false,
            type: "POST",
            // 下面是发送的信息
            data:{order_id: delete_id}
        }).done(function(data){
            alert(data);
            window.location.replace(current_url); // reload page
        }).fail(function(data){
            alert(data);
        })
        
    })
    
    </script>
</html>