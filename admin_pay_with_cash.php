<?php
    $wechatid = $_POST["wechatid"];
    $money = $_POST["money"];


    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
    if (mysqli_connect_errno()){
        $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
        echo $RESULT;
        exit;
    }

    $query = "UPDATE user SET money=money+'$money' 
                          WHERE wechatid='$wechatid'";
    $result = mysqli_query($cons, $query);
    if($result){
        echo "Success";
    }
    else{
        echo "Failed";
    }   
?>