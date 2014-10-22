<?php
    /*
    * 通过 signup_page.php 得到了用户的姓名， 电话， wechatid。
    * 这里要把信息写到数据库里
    */ 
    $wechatid = $_POST["wechatid"];
    $last_name = $_POST["last_name"];
    $first_name = $_POST["first_name"];
    $phone = $_POST["phone"];
    $pickup_location = $_POST["pickup_location"];

    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "无法连接到MySQL数据库: " . mysqli_connect_error();
        exit;
    }
    $query_content = "INSERT INTO user VALUES ( '$wechatid', 
                                                '$last_name',
                                                '$first_name',
                                                '$phone',
                                                '$pickup_location',
                                                0)";
    mysqli_query($cons, $query_content);
    echo "Signup Successfully!";
?>