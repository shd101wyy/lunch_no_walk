<?php
    /*
    * 通过 meals.php 得到了用户的姓名， 电话， wechatid。
    * 这里要把信息写到数据库里
    */ 
    $wechatid = $_POST["wechatid"];
    $last_name = $_POST["last_name"];
    $first_name = $_POST["first_name"];
    $phone = $_POST["phone"];
    $pickup_location = $_POST["pickup_location"];

    $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "Cannot connect to MySQL: " . mysqli_connect_error();
        exit;
    }
    $query_content = "UPDATE user SET last_name='$last_name', 
                                      first_name='$first_name',
                                      phone='$phone',
                                      pickup_location='$pickup_location'
                                WHERE wechatid='$wechatid';";
    if(!mysqli_query($cons, $query_content)){
        echo mysqli_error($cons);
    }
    else{
        echo "Update Profile Successfully";
    }
?>