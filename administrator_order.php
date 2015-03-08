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
        <style>
            .ui-input-text.ui-custom {
                border: none;
                box-shadow: none;
                font-weight: bold;
            }
        </style>
    </head>
    
    <body>
        <!-- order history -->
        <div id="orders" data-role="page">
            <div data-role="header">
                <h1>
                    Orders
                </h1>
            </div>  
            <div data-role="main" class="ui-content">
                <form class="ui-filterable">
                    <input id="myFilter1" data-type="search" placeholder="search">
                </form>
                <ul data-role="listview" data-inset="true" id="order_history_list_incomplete" data-filter="true" data-input="#myFilter1">
                    <!-- Show user incomplete order here -->
                </ul>
                <form class="ui-filterable">
                    <input id="myFilter2" data-type="search" placeholder="search">
                </form>
                <ul data-role="listview" data-inset="true" id="order_history_list_complete" data-filter="true" data-input="#myFilter2">
                    <!-- Show user completed order here -->
                </ul>
            </div>
        </div>
    </body>
    <script>
        var current_url = document.URL;
        $(document).ready(function(){
            $("input[type='checkbox']").on('change', function(){
                 $(this).closest('div').toggleClass('highlight');
            });
            // get orders
            <?php
                // try connect to sql
                $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库, connect to sql
                if (mysqli_connect_errno()){
                    $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
                    echo $RESULT;
                    exit;
                }
                // JOIN
                // get join meal_order and meals and user
                $query_content = "SELECT *
                                  FROM meal_order 
                                  INNER JOIN meals 
                                  ON meal_order.menu_id = meals.id
                                  INNER JOIN user 
                                  ON user.wechatid = meal_order.wechat_id
                                  ORDER BY meal_order.order_date DESC;";
                $query_result = mysqli_query($cons, $query_content);
                if($query_result){
                    $ORDER_HISTORY = array();
                    while($php_arr = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
                        array_push($ORDER_HISTORY, $php_arr);
                    }
                    $ORDER_HISTORY = json_encode($ORDER_HISTORY);
                }
                else{
                    echo "Failed";
                    exit;
                }
            ?>
            var Failed = "Failed";
            var order_history = <?php echo $ORDER_HISTORY; ?>;
            if(order_history === Failed){ // failed to connect to server
                alert("Failed to connect to server");
                return;
            }
            
// set order history.  $("#order_history")
            for(var i = 0; i < order_history.length; i++){
                var o = order_history[i];
                /*
                * o is in format like:
                     {"order_id":"5480cb3985be3",
                     "wechat_id":"owHwut3BntJ86quRSV3h-EVF8B5U",
                     "menu_id":"5480c6f528cbd",
                     "order_num":"10",
                     "complete":"0",
                     "pickup_location":"MNTL",
                     "order_date":"1417726780496",
                     "introduction":"Szechuan Broccoli",
                     "price":"5",
                     "image_path":"uploads\/5480c6f528c78431430_490834170943891_1796903915_n.jpg",
                     "week_day":"Friday",
                     "id":"5480c6f528cbd",
                     "available":"1",
                     "wechatid":"owHwut3BntJ86quRSV3h-EVF8B5U",
                     "last_name":"wei",
                     "first_name":"xin",
                     "phone":"2178192211",
                     "administrator":"0",
                     "money":"234"}
                *
                */
                var complete = o.complete;
                var order_date = new Date(parseInt(o.order_date)); // change order date from timestamp to human readable
                var order_id = o.order_id;
                var order_num = o.order_num;
                var pickup_location_ = o.pickup_location;
                var pic = o.image_path;
                var intro = o.introduction;
                var price = parseFloat(o.price) * parseInt(order_num); // get total price.
                var wechatid = o.wechat_id;
                var phone = o.phone;
                var content;
                if(complete == 1){ // completed order
                    content = 
          "<li data-theme='b'>" + 
                    "<a href='#'>"+
                    "<img src='"+pic+"'>" +
                    "<h2>Completed Order: "+order_id+"</h2>" +
                    "<h3> " + o.first_name + " " + o.last_name +"</h3>" +
                    "<p>" + phone + "</p>" +
                    "<p>menu: " + intro + " <br> order num: " + order_num + " <br> date: " + order_date + " <br> pickup location: " + pickup_location_ + " <br> total price: " + price +"</p>" + 
                    "<button id='btn"+i+"' order_id='"+o.order_id+"' complete='1' onclick=\"clickCheck('btn"+i+"', '"+wechatid+"', "+price+","+(o.money)+");\"> Revoke:Pay with Balance </button>"
                    "</a>" + 
            "</li>";
                    $("#order_history_list_complete").append(content);  
                }
                else{ // incomplete order
                    content = 
            "<li id='li"+i+"'>" + 
                    "<a href='#'>"+
                    "<img src='"+pic+"'>" +
                    "<h2>Incomplete Order: "+order_id+"</h2>" +
                    "<h3> " + o.first_name + " " + o.last_name +"</h3>" +
                    "<p>" + phone + "</p>" +
                    "<p>menu: " + intro + " <br> order num: " + order_num + " <br> date: " + order_date + "<br> pickup location: " + pickup_location_ + " <br> total price: " + price +"</p>" +
                    "<button id='btn"+i+"' order_id='"+o.order_id+"' complete='0' onclick=\"clickCheck('btn"+i+"', '"+wechatid+"', "+price+","+(o.money)+");\"> Pay with Balance </button><br>" +
                    "<button onclick=\"payWithcash('"+wechatid+"')\">Pay with Cash </button><br>" + 
                    "</a>" +
            "</li>";
                    $("#order_history_list_incomplete").append(content);  

                }                
            }
            // refresh listview
            $('ul').listview('refresh');
            //$("#checkbox_0").prop("checked", true).checkboxradio("refresh");
            //$("input[type='checkbox']").checkboxradio();
            //$("input[type='checkbox']").prop("checked", false).checkboxradio("refresh");      
        })
        var clickCheck = function(id, wechatid, price, user_money){
            
            if(user_money < 0){
                alert("User account less than 0$, please pay with cash\n账户余额不足，请现金充值支付");
                return;
            }            
            console.log("clickCheck: " + id + " " + wechatid);
            id = "#" + id;
            var complete = parseInt($(id).attr("complete"));
            var order_id = $(id).attr("order_id");
            console.log(complete + " wechatid:" + order_id + "  price:" + price);
            if(complete === 0){
                complete = 1;
            }
            else{
                complete = 0;
            }
            $.ajax({
                    url: "./admin_change_order_complete_status.php",
                    async: false,
                    type: "POST",
                    // 下面是发送的信息
                    data:{order_id : order_id, 
                          complete: complete,
                          wechatid: wechatid,
                          price: price}
                }).done(function(data){
                    console.log(data);
                    if(data == "Success")
                        window.location.replace(current_url); // reload page
                    else if (data == "Not enough money"){
                        alert(data);
                    }
                    else alert(data);
                }).fail(function(data){
                    alert(data);
                });
        }
        
        var payWithcash = function(wechatid){
            console.log(wechatid);
            var money = prompt("How much to pay?");
            money = parseFloat(money);
            console.log(money);
            $.ajax({
                    url: "./admin_pay_with_cash.php",
                    async: false,
                    type: "POST",
                    // 下面是发送的信息
                    data:{wechatid: wechatid,
                          money: money}
                }).done(function(data){
                    console.log(data);
                    if(data == "Success")
                        window.location.replace(current_url); // reload page
                    else alert(data);
                }).fail(function(data){
                    alert(data);
                });
        }
    </script>
</html>