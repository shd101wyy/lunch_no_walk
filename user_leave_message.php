<?php
    /*
    * 通过 signup_page.php 得到了用户的姓名， 电话， wechatid。
    * 这里要把信息写到数据库里
    */ 
    $wechatid = $_POST["wechatid"];
    $message = $_POST["message"];
    $msg_id = uniqid();

    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "Failed";
        exit;
    }
    $query_content = "INSERT INTO customer_msg VALUES ( '$msg_id', 
                                                '$wechatid',
                                                '$message',  
                                                0)";  
    mysqli_query($cons, $query_content);
    echo "Signup Successfully!";
?>