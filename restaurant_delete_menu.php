<?php
    $delete_id = $_POST["id"];
    // try connect to sql
    $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库, connect to sql
    if (mysqli_connect_errno()){
        echo "Cannot connect to MySQL: " . mysqli_connect_error();
        exit;
    }
    $query_content = "UPDATE meals SET available=0 WHERE id='$delete_id'"; // delete that order, set as not available.
    mysqli_query($cons, $query_content);
    echo "Delete Successfully: " . $delete_id;

?>