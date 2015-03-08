<?php
    /*
    * 通过 meals.php, 得到了:
    *
    menu_id: menu_id,
    wechat_id: wechatid,
    pickup_location: pickup_location,
    order_num: order_num
    * 这里要把信息写到数据库里
    */ 
    $menu_id = $_POST["menu_id"];
    $wechat_id = $_POST["wechat_id"];
    $pickup_location = $_POST["pickup_location"];
    $order_num = $_POST["order_num"];
    $processed = 0; // not processed, incomplete.
    $order_date = $_POST["order_date"];
    $user_rest_money = $_POST["user_rest_money"];
    $order_id = uniqid();

    $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库
    if (mysqli_connect_errno()){
        //echo "Cannot connect to MySQL: " . mysqli_connect_error();
        echo "Failed";
        exit;
    }
    // add meal order
    $query_content = "INSERT INTO meal_order VALUES('$order_id',
                                               '$wechat_id',
                                               '$menu_id',
                                               '$order_num',
                                               '$processed',
                                               '$pickup_location',
                                               '$order_date');";
    if(!mysqli_query($cons, $query_content)){
        //echo "MySQL Error: " . mysqli_error($cons);
        echo "Failed";
        exit;
    }

    // update user rest money
    $query_content = "UPDATE user SET money='$user_rest_money' 
                                  WHERE wechatid='$wechat_id'";

    if(!mysqli_query($cons, $query_content)){
        //echo "MySQL Error: " . mysqli_error($cons);
        echo "Failed";
        exit;
    }
    echo $order_id; // return order_id
?>