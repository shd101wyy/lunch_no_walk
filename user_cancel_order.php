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
    $order_id = $_POST['order_id'];

    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "Cannot connect to MySQL: " . mysqli_connect_error();
        exit;
    }
    $query_content = "DELETE FROM meal_order WHERE order_id='$order_id';";
    if(!mysqli_query($cons, $query_content)){
        echo "MySQL Error: " . mysqli_error($cons);
        exit;
    }
    echo "Cancel Order Successfully!";
?>