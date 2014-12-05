<?php
/*
 delete admin's response
*/
    $wechatid = $_POST["wechatid"];

    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "Failed";
        exit;
    }
    // get admin response
    $query_content = "SELECT msg_id, msg FROM admin_msg WHERE wechat_id='$wechatid'";
    $query_result = mysqli_query($cons, $query_content);
    if($query_result){
        $ADMIN_RESPONSE = array();
        while($php_arr = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
            array_push($ADMIN_RESPONSE, $php_arr);
        }
        $ADMIN_RESPONSE = json_encode($ADMIN_RESPONSE);
    }
    else{
        $ADMIN_RESPONSE = "Cannot connect to MySQL";
        echo "Failed";
        exit;
    }

    // delete admin response 
    $query_content = "DELETE FROM admin_msg WHERE wechat_id='$wechatid'";
    mysqli_query($cons, $query_content);

    echo $ADMIN_RESPONSE;
?>