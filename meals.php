<html>
    <?php 
        $wechatid = stripslashes($_GET["wechatid"]);
        if($wechatid[0] === "'"){
            $wechatid = substr($wechatid, 1, -1);
        } 
        if(isset($_GET["refresh"])){
            $refresh = 1;
        }
        else{
            $refresh = 0;
        }
    ?>
<head>
    <title>
        Menus
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- iOS full screen -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- android full screen -->
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
    <script src="jquery.qrcode-0.11.0.min.js"></script> <!-- qr code support -->
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
            <a href="#faq">FAQ 疑问解答</a> 
            <br>
            <a href="#leave_msg_page">Not in menu? Tell us what you want!</a>
            <br>

            <!-- 
                    link to official account 
                    链接到公众账号

                    
                    tutorial is here(教程在这个网站) http://jingyan.baidu.com/article/2d5afd69efd2cf85a3e28e6b.html
                -->
            <a href="http://mp.weixin.qq.com/s?__biz=MzA3MzI3NzEyMA==&mid=202312491&idx=1&sn=370c5053099f04bd33ac67b0e3c69b53#rd">About lunch no walk </a>


            <ul data-role="listview" data-inset="true" id="menu_list">
                <!-- Show menu information here -->
            </ul>
        </div>
        <!-- Footer -->
        <div data-role="footer" data-position="fixed">
            <div data-role="navbar">
                <ul>
                    <!-- <li><a href="#meal_page">Menus</a></li> -->
                    <li><a href="#order_history_page" data-transition="slidefade" style="text-align:center;">My Orders</a>
                    </li>
                    <li><a href="#settings_page" data-transition="slidefade" style="text-align:center;">Settings</a>
                    </li>
                </ul>
            </div>
            <!-- /navbar -->
        </div>
        <!-- /footer -->

    </div>


    <!-- Order History Page -->
    <div data-role="page" id="order_history_page">
        <div data-role="main" class="ui-content">
            <p>You can check your orders here
                <br>You can cancel order here by clicking crossing button.
            </p>
            
            <p id="qr_confirm_p">Quick Confirm</p>
            <div id="qr_code"></div> <!-- qr code here -->
            
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
            <label for="signup_user_last_name">Last name:</label>
            <input type="text" id="signup_user_last_name" data-clear-btn="true">
            <!-- 名 -->
            <label for="signup_user_first_name">First name:</label>
            <input type="text" id="signup_user_first_name" data-clear-btn="true">
            <!-- <label for="signup_username">姓名:</label>
                <input type="text" id="signup_username" data-clear-btn="true"> -->
            <!-- 电话 -->
            <label for="signup_phonenumber">Cellphone number:</label>
            <input type="text" id="signup_phonenumber" data-clear-btn="true" name="signup_phonenumber">

            <!-- 下拉菜单 -->
            <fieldset class="ui-field-contain">
                <label for="signup_pickup_location">Select one of the location most close to you:</label>
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
            <img id="menu_pic" src="images.jpeg" width="100%" , height="40%">
            <b id="menu_intro"> 宫爆鸡丁， 蒜蓉生姜菜 </b>
            <!-- 下拉菜单 pickup location -->
            <fieldset class="ui-field-contain">
                <label for="pickup_location">Select one of the location most close to you:</label>
                <select name="pickup_location" id="pickup_location">
                    <!-- Fill In later using JavaScript -->
                </select>
            </fieldset>

            <!-- 下拉菜单 点餐数量 -->
            <!-- 下拉菜单 -->
            <fieldset class="ui-field-contain">
                <label for="order_num">Select how many meals you want to order:</label>
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
            <button id="submit_button">Submit</button>
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
    
    <!-- 留言页 -->
    <div data-role="page" id="leave_msg_page">
        <div data-role="header">
            <h1>
                Tell us what you want
            </h1>
        </div>
        <div data-role="main" class="ui-content">
            <p>
                Leave your message here, we will send it to our restaurant
            </p>
            <textarea id="user_leave_msg_textarea" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset" placeholder="Enter your message here"></textarea>
            <button id="send_message_button"> Send </button>
        </div>
    </div>
    <!-- FAQ page -->
    <div data-role="page" id="faq">
        <div data-role="header">
            <h1>
                    FAQ 疑难解答
                </h1>
        </div>
        <div data-role="main" class="ui-content">
            <ul id="faq_ul">
                <li>
                    <strong>Q</strong> <p>If I ordered a meal, but I can not come, what should I do?</p>
                </li>
                <li>
                    <strong>A</strong> <p>Please ask your friend to help pick up the order.</p>
                </li>
                <br>
                <li>
                    <strong>Q</strong> <p> If I miss the deadline to order the food for today, what should I do?</p>
                </li>
                <li>
                    <strong>A</strong> <p>After the deadline of 10am, you can place order of the “Special of today” until 11:20am. After 11:20am, we’ll have limited supply, you can order until sold out.</p>
                </li>
                <br>
                <li>
                    <strong>Q</strong> <p>What if I forget to pick up the order?</p>
                </li>
                <li>
                    <strong>A</strong> <p>Please mark your calendar, be sure to come by and pick up. Otherwise you'll still be charged. You can find a friend to help pick up. You can cancel your order before 10am.</p>
                </li>
                <br>
                <li>
                    <strong>Q</strong> <p>How to pay?</p>
                </li>
                <li>
                    <strong>A</strong> <p>Users' orders will be processed if their balance is more or equal to $0 before the delivery date. You can recharge at the pick-up location. The system will automatically charge when ordering. Red warning pops up when balance is less than $15. Online payment: Put your user name\Name in the comment region. (Suggested minimum amount: $20) . Payment will be processed daily.</p>
                    <ol>
                        <li>
                            <p>Users can transfer the money to Paypal: lunchnowalk@gmail.com by personal from Paypal balance or bank(Not by credit) otherwise, the users will need to pay for the transaction fees. Users can send an email to lunchnowalk@gmail.com after sending money through Paypal.</p></li>
                        <li>
                            <p>Transfer money through Chasequickpay to jiangjing.36@gmail.com</p>
                        </li>
                    </ol>
                </li>
                <br>
                <br>
                <li>
                    <strong>Q</strong> <p>如果我今天订了餐，但是中午临时有事取不来菜怎么办？</p>
                </li>
                <li>
                    <strong>A</strong> <p>建议请同学帮忙去取菜，报上自己的名字。</p>
                </li>
                <br>
                <li>
                    <strong>Q</strong> <p>如果我今天错过了时间忘了订餐怎么办？</p>
                </li>
                <li>
                    <strong>A</strong> <p>错过10am的订餐截止日期，您还可以在11:20am之前订“今日特价”餐，在这个时间后，我们还会有少量供应，售完为止。</p>
                </li>
                <br>
                <li>
                    <strong>Q</strong> <p>忘了来取怎么办？</p>
                </li>
                <li>
                    <strong>A</strong> <p>请同学们给自己手机日历上面标记提醒，一定要过来取。否则照样扣款。可以找朋友帮忙来取。10点之前可以取消订单。</p>
                </li>
                <br>
                <li>
                    <strong>Q</strong> <p>支付方式是如何的呢？</p>
                </li>
                <li>
                    <strong>A</strong> <p>用户网上帐户是大于等于$0的时候，订单都会被处理。在领餐的时候可以充值。订餐时自动扣款。余额少于$15时，将会有提示信息～ 在线支付：请在注释区填写用户名\姓名 为了大家方便，建议每次最少充值$20. 每天固定时间处理。</p>
                    <ol>
                        <li>
                            <p>用户可以转钱到Paypal账户：lunchnowalk@gmail.com，通过“个人支付”，资金来源请勿选择信用卡。否则所有产生的交易费用由用户承担。用户最好在Paypal转钱后同时给lunchnowalk@gmail.com发邮件。</p>
                        </li>
                        <li>
                            <p>用Chasequickpay把充值金额转入jiangjing.36@gmail.com</p>
                        </li>
                    </ol>
                </li>
            </ul>
        </div>
    </div>
</body>



<script>
    /*
        // hide wechat tool bar
        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
            WeixinJSBridge.call('hideToolbar');
            WeixinJSBridge.call('hideOptionMenu');
        });
        */
    // global variable
    var current_url = document.URL;
    var wechatid = "<?php echo $wechatid; ?>"; // get wechatid
    var refresh = "<?php echo $refresh;?>"; // get refresh
    if(parseInt(refresh) === 1){ // need to refresh current page
        window.location.href = current_url.slice(0, current_url.indexOf("&refresh")) + "#order_history_page";  // 解决 back button 不能更新 ajax 的问题  
    }
    if (wechatid[0] === "'" || wechatid[0] === "\"") {
        wechatid = wechatid.slice(1, wechatid.length - 1); // remove ''
    }

    var user_info = null;
    var data = null;
    var order_history = null;
    var pickup_location = null;
    var incomplete_order_num = 0;

    $(document).ready(function () {
        /*
         * get user_info order_history menu_data from server.
         * init page
         */
        $.ajax({
            url: "./init_meals.php",
            async: false,
            type: "POST",
            // 下面是发送的信息
            data: {
                wechatid: wechatid
            }
        }).done(function (v) {
            if (v === "Failed") {
                alert("Failed to connect to server");
            } else {
                v = JSON.parse(v);
                //alert(v[1] + "   " + wechatid);
                data = JSON.parse(v[0]);
                order_history = JSON.parse(v[1]);
                user_info = JSON.parse(v[2]);
                pickup_location = user_info.pickup_location;
                // setup time
                var d = new Date();
                var weekday = new Array(7);
                weekday[0] = "Sunday";
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

                $("#rest_money").html("Money in Account: $" + user_info.money);
                /*
                 *
                 * use php to read menus from server(meals)
                 *
                 */

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
                $("#faq_ul p").css("white-space", "normal");
                //console.log(data);
                //console.log(order_history);
                // the code below is for debug use.
                // $("#order_history_page").append(JSON.stringify(order_history));
                for (var i = 0; i < data.length; i++) {
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
                        "</a>" +
                        "</li>";
                    $("#menu_list").append(content);
                }

                /*
            $("#order_history_page").on("pagechange", function(){
                //alert("Page change");
            })
            $("#order_history_page").on("pagechangefailed", function(){
                //alert("Page change failed");
            })
            $("#order_history_page").on("pagecreate", function(){
                alert("Page create " + refresh_order_page + " asd");
                //alert("Fuck me");
                //window.location.reload(true);
            })
            $("#order_history_page").on("pagehide", function(){
                //alert("Page hide");
            })
            $("#order_history_page").on("pageinit", function(){
                $("ul").listview().listview("refresh");
            })
            */


                // set default pickup selection
                var pickup_location_selection_options = "";
                var locations = ["MNTL", "BIF", "RAL"];
                for (var i = 0; i < locations.length; i++) {
                    var l = locations[i];
                    if (l === pickup_location) {
                        pickup_location_selection_options += "<option selected='selected'>" + pickup_location + "</option>";
                    } else {
                        pickup_location_selection_options += "<option>" + l + "</option>";
                    }
                }
                $("#pickup_location").html(pickup_location_selection_options);
                $("#signup_pickup_location").html(pickup_location_selection_options);

                // set order history.  $("#order_history")
                for (var i = 0; i < order_history.length; i++) {
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
                    var order_date = new Date(parseInt(o.order_date)); // change order date from timestamp to
                    var order_id = o.order_id;
                    var order_num = o.order_num;
                    var pickup_location_ = o.pickup_location;
                    var pic = menu.image_path;
                    var intro = menu.introduction;
                    var price = parseFloat(menu.price) * parseInt(order_num); // get total price.
                    var content;
                    if (complete == 1) { // completed order
                        content =
                            "<li data-theme='b'>" +
                            "<a href='#'>" +
                            "<img src='" + pic + "'>" +
                            "<h2>Completed Order: " + order_id + "</h2>" +
                            "<p>menu: " + intro + " <br> order num: " + order_num + " <br> date: " + order_date.toString() + " <br> pickup location: " + pickup_location_ + " <br> total price: " + price + "</p>" +
                            "</a>" +
                            "</li>";
                        $("#order_history_list_complete").append(content);
                    } else { // incomplete order
                        content =
                            "<li >" +
                            "<a href='#'>" +
                            "<img src='" + pic + "'>" +
                            "<h2>Incomplete Order: " + order_id + "</h2>" +
                            "<p>menu: " + intro + " <br> order num: " + order_num + " <br> date: " + order_date.toString() + "<br> pickup location: " + pickup_location_ + " <br> total price: " + price + "</p>" +
                            "</a>" +
                            "<a onclick=\"click_split_button_delete('" + order_id + "', " + price + " );\" href='#delete_order' data-transition='pop' data-icon='delete'>Delete </a>" +
                            "</li>";
                        $("#order_history_list_incomplete").append(content);
                        incomplete_order_num++;
                    }
                }

                // setup change profile page.
                $("#signup_user_last_name").val(user_info.last_name);
                $("#signup_user_first_name").val(user_info.first_name);
                $("#signup_phonenumber").val(user_info.phone);

                // refresh listview
                //$("#order_history_list_complete").listview('refresh');
                //$('#order_history_list_incomplete').listview('refresh');
                $('ul').listview().listview('refresh');
                
                if(incomplete_order_num == 0){ // no incomplete order 
                    $("#qr_confirm_p").hide();
                    $("#qr_code").hide();
                }
                else{
                    // check user money 
                    if(user_info.money < 0){
                        $("#qr_code").text("Not enough money in your account, please pay with cash");
                    }
                    else{
                        $("#qr_code").qrcode({
                            render:"canvas",
                            text:"http://www.planetwalley.com/lunch_no_walk/confirm_order_from_user.php?wechatid="+wechatid,
                            size:128
                        });
                    }
                }
            }
        }).fail(function (data) {
            alert("Failed to connect to server");
        })
        /*
        console.log("menu data: ");
        console.log(data);
        console.log("order history: ");
        console.log(order_history);
        console.log("user info");
        console.log(user_info);
        */
    })


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
    //console.log(wechatid);
    //console.log(pickup_location);
    //console.log(user_info);

    // check menu information
    // customers can buy meal from it.
    var check_menu = function (menu_num, pic, price, id, intro) {
            $("#menu_num").html(menu_num);
            $("#menu_pic").attr("src", pic);
            $("#menu_price").html(" Price: $" + price);
            $("#menu_info").attr("menu_id", id);
            $("#menu_info").attr("menu_price", price);
            $("#menu_intro").html(intro);
        }
        // clicked submit button
        // 下订单
    $("#submit_button").click(function () {
        var menu_id = $("#menu_info").attr("menu_id"); // get menu id  
        var menu_price = $("#menu_info").attr("menu_price"); // get menu price


        // var wechatid = wechatid; // get wechatid
        var pickup_location2 = $("#pickup_location option:selected").val(); // get pickup location
        var order_num = $("#order_num option:selected").val(); // get order num

        var total_price = menu_price * order_num; // 订餐总共需要花费的金额
        var user_money = user_info.money; // user money

        if (user_money < 0) { // 余额不足, 不能订餐。
            alert("Not enough money in your account\n您的账户余额不足");
            return;
        }

        $.ajax({
            url: "./submit_order.php",
            async: false,
            type: "POST",
            // 下面是发送的信息
            data: {
                menu_id: menu_id,
                wechat_id: wechatid,
                pickup_location: pickup_location2,
                order_num: order_num,
                order_date: (+new Date).toString(),
                user_rest_money: user_money - total_price // 账户余额
            }
        }).done(function (data) {
            if (data === "Failed") return; // failed to upload data to mysql 
            alert("Submit Order Successfully");
            history.pushState({}, "", "meals.php?wechatid=" + wechatid)
            history.pushState({}, "", "meals.php?wechatid=" + wechatid+"&refresh=1"); // change browser history, set refresh option
            //history.replaceState({}, "", "meals.php?wechatid=" + wechatid + "#order_history_page"); // change browser history
            window.location.href = ("http://mp.weixin.qq.com/s?__biz=MzA3MzI3NzEyMA==&mid=202312491&idx=1&sn=370c5053099f04bd33ac67b0e3c69b53#rd");
        }).fail(function (data) {
            alert(data);
        });
    });
    // update user profile
    $("#change_user_profile").click(function () {
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
            data: {
                last_name: last_name,
                first_name: first_name,
                phone: phone,
                pickup_location: pickup_location3,
                wechatid: wechatid
            }
        }).done(function (data) {
            alert(data);
            window.location.replace(current_url); // reload page
        }).fail(function (data) {
            alert(data);
        })
    })
    // when change order num, update price
    $("#order_num").bind("change", function () {
        var price = $("#menu_price").html();
        price = parseFloat(price.slice(price.indexOf("$") + 1));
        var num = parseInt($("#order_num option:selected").val());
        price = price * num;
        $("#menu_price").html(" Price: $" + price);
    })
    // click delete button right side of the list
    var click_split_button_delete = function (id, total_price) {
            $("#delete_order").attr("delete_id", id); // save the id we want to delete
            $("#delete_order").attr("total_price", total_price); // save total price of that meal
        }
        // cancel order
    $("#delete_order_button").click(function () {
        var delete_id = $("#delete_order").attr("delete_id"); // get order id that we want to delete
        var total_price = $("#delete_order").attr("total_price");
        $.ajax({
            url: "user_cancel_order.php",
            async: false,
            type: "POST",
            // 下面是发送的信息
            data: {
                order_id: delete_id,
                wechatid: wechatid,
                add_money: total_price
            }
        }).done(function (data) {
            alert(data);
            current_url = "http://www.planetwalley.com/lunch_no_walk/meals.php?wechatid=" + wechatid;
            window.location.href = (current_url); // reload page
        }).fail(function (data) {
            alert(data);
        })
    })
    
    // user leave message
    $("#send_message_button").click(function(){
        var message = $("#user_leave_msg_textarea").val();
        $.ajax({
            url: "user_leave_message.php",
            async: false,
            type: "POST",
            // 下面是发送的信息
            data: {
                wechatid: wechatid,
                message: message
            }
        }).done(function (data) {
            alert("Message delivered! Thx ;)");
        }).fail(function (data) {
            alert(data);
        })
    })
</script>

</html>