<?php
    $order_id = $_POST["order_id"];
    $complete = $_POST["complete"];
    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
    if (mysqli_connect_errno()){
                    $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
                    echo $RESULT;
                    exit;
    }
    $query = "UPDATE meal_order SET complete='$complete' 
                                WHERE order_id='$order_id'";
    $result = mysqli_query($cons, $query);
    if($result){
        echo "Success";
    }
    else{
        echo "Failed";
    }
?>