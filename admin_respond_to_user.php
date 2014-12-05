<?php
/*
    respond msg to user
*/
    $wechatid = $_POST["wechatid"];
    $message = $_POST["message"];
    $msg_id = uniqid();

    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "Failed";
        exit;
    }
    $query_content = "INSERT INTO admin_msg VALUES ( '$msg_id', 
                                                '$wechatid',
                                                '$message')";  
    mysqli_query($cons, $query_content);
    echo "Success";
?>