<?php
    $delete_id = $_POST["id"];
    // try connect to sql
    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
    if (mysqli_connect_errno()){
        echo "Cannot connect to MySQL: " . mysqli_connect_error();
        exit;
    }
    $query_content = "DELETE * FROM meals WHERE id='$delete_id'"; // delete that order.
    mysqli_query($cons, $query_content);
    echo "Delete Successfully";

?>