<?php
    $wechatid = $_POST["wechatid"];
    $money = $_POST["money"];
    $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库, connect to sql
    if (mysqli_connect_errno()){
                    $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
                    echo $RESULT;
                    exit;
    }
    $query = "UPDATE user SET money='$money'+money 
                                WHERE wechatid='$wechatid'";
    $result = mysqli_query($cons, $query);
    if($result){
        echo "Success";
    }
    else{
        echo "Failed";
    }
?>