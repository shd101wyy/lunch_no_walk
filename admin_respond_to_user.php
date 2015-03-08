<?php
/*
    respond msg to user
*/
    $wechatid = $_POST["wechatid"];
    $message = $_POST["message"];
    $from_msg_id = $_POST["from_msg_id"];
    $msg_id = uniqid();

    $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "Failed";
        exit;
    }
    $query_content = "INSERT INTO admin_msg VALUES ( '$msg_id', 
                                                '$wechatid',
                                                '$message')";  
    mysqli_query($cons, $query_content);

    $query_content = "UPDATE customer_msg SET responded=1 WHERE msg_id='$from_msg_id'";
    mysqli_query($cons, $query_content);
    echo "Success";
?>