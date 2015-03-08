<?php
/*
 send message to admin
*/
    $wechatid = $_POST["wechatid"];
    $message = $_POST["message"];
    $msg_id = uniqid();

    $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "Failed";
        exit;
    }
    $query_content = "INSERT INTO customer_msg VALUES ( '$msg_id', 
                                                '$wechatid',
                                                '$message',  
                                                0)";  
    mysqli_query($cons, $query_content);
    echo "Success";
?>