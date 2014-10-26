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
                $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
                if (mysqli_connect_errno()){
                    $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
                    echo $RESULT;
                    exit;
                }
                // get user order
                $query_content = "SELECT * FROM meal_order ORDER BY order_date DESC;";
                $query_result = mysqli_query($cons, $query_content);
                if($query_result){
                    $my_array = array();
                    while($php_arr = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
                        $menu_id = $php_arr["menu_id"]; // get menu_id
                        $wechat_id = $php_arr["wechat_id"]; // get wechat id
                        // retrieve menu according to menu_id
                        $query_for_menu = "SELECT * FROM meals WHERE id='$menu_id'";
                        $query_for_menu = mysqli_query($cons, $query_for_menu);
                        $menu_data = mysqli_fetch_array($query_for_menu, MYSQLI_ASSOC);
                        // add menu property to $php_arr.
                        $php_arr["menu"] = $menu_data;
                        
                        // retrieve user data 
                        $query_for_user = "SELECT * FROM user WHERE wechatid='$wechat_id'";
                        $query_for_user = mysqli_query($cons, $query_for_user);
                        $user_data = mysqli_fetch_array($query_for_user, MYSQLI_ASSOC);
                        // add user property to $php_arr
                        $php_arr["user"] = $user_data;
                        
                        array_push($my_array, $php_arr);
                    }
                    $js_array = json_encode($my_array);
                    $ORDER_HISTORY = $js_array;
                }
                else{
                    $ORDER_HISTORY = "Cannot connect to MySQL";
                    exit;
                }
            ?>
            var order_history = <?php echo $ORDER_HISTORY; ?>;
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
                console.log(o);
                var complete = o.complete;
                var menu = o.menu;
                var order_date = new Date(parseInt(o.order_date)); // change order date from timestamp to human readable
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
                    "<p>menu: " + intro + " <br> order num: " + order_num + " <br> date: " + order_date + " <br> pickup location: " + pickup_location_ + " <br> total price: " + price +"</p>" +
                    "<p> Last Name: <b>" + o.user.last_name + "</b> First Name: <b>" + o.user.first_name + "</b></p><br>" + 
                    "<button id='btn"+i+"' order_id='"+o.order_id+"' complete='1' onclick=\"clickCheck('btn"+i+"');\"> Check </button>"
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
                    "<p>menu: " + intro + " <br> order num: " + order_num + " <br> date: " + order_date + "<br> pickup location: " + pickup_location_ + " <br> total price: " + price +"</p>" +
                    "<p> Last Name: <b>" + o.user.last_name + "</b> First Name: <b>" + o.user.first_name + "</b></p><br>" + 
                    "<button id='btn"+i+"' order_id='"+o.order_id+"' complete='0' onclick=\"clickCheck('btn"+i+"');\"> Check </button>" +
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
        var clickCheck = function(id){
            id = "#" + id;
            var complete = parseInt($(id).attr("complete"));
            var order_id = $(id).attr("order_id");
            console.log(complete + " " + order_id);
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
                          complete: complete}
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