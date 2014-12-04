<?php
    $order_id = $_POST["order_id"];
    $complete = $_POST["complete"];
    $wechatid = $_POST["wechatid"];
    $required_money = $_POST["price"];

    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
    if (mysqli_connect_errno()){
                    $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
                    echo $RESULT;
                    exit;
    }
    // 检查用户钱够吗。
/*
    $query = "SELECT * FROM user WHERE wechatid='$wechatid'";
    $result = mysqli_query($cons, $query);
    if(!$result){
        echo "ERROR";
        exit;
    }
    $php_arr = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $money = $php_arr["money"];
    if($complete){ // set to complete, check money enough
        if($money < $required_money){
            echo "Not enough money";
            exit;
        }
    }
*/
    $query = "UPDATE meal_order SET complete='$complete' 
                                    WHERE order_id='$order_id'";
    $result = mysqli_query($cons, $query);
    if($result){
    }
    else{
        echo "Failed";
        exit;
    }   
    // set to complete, No decrement user's money
    // as user money already decremented when submitting order.
    if($complete){  
        /*
        $query = "UPDATE user SET money=money-'$required_money'
                              WHERE wechatid='$wechatid'";
        $result = mysqli_query($cons, $query);
        if($result){
            echo "Success";
        }
        else{
            echo "Failed";
        } 
        */
        echo "Success";
    }
    else{ // increase user's money
        $query = "UPDATE user SET money=money+'$required_money'
                              WHERE wechatid='$wechatid'";
        $result = mysqli_query($cons, $query);
        if($result){
            echo "Success";
        }
        else{
            echo "Failed";
        }    
    }

?>