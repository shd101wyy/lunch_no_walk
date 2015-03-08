<?php
/*
 delete admin's response
*/
    $msg_id = $_POST["msg_id"];

    $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "Failed";
        exit;
    }
    $query_content = "DELETE FROM admin_msg WHERE msg_id='$msg_id'";  
    mysqli_query($cons, $query_content);
    echo "Success";
?>