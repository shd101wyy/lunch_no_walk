<html>
<?php
    $wechatid = $_GET["wechatid"];
    // try connect to sql
    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
    if (mysqli_connect_errno()){
        $result = "Failed to connect to database";
        exit;
    }
    $query_content = "UPDATE meal_order SET complete=1 
                                    WHERE wechat_id='$wechatid'";
    $query_result = mysqli_query($cons, $query_content);
        
    if($query_result){
        $result = "Confirm orders successfully";
    }
    else{
        $result = "Failed to connect to database";
    }
?>
<head>
    <title>
        Menus
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- iOS full screen -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- android full screen -->
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
    <script src="jquery.qrcode-0.11.0.min.js"></script> <!-- qr code support -->
</head>
<body>
    <div>
        <h1>Quick Confirm Page</h1>
        <!--<h3>Wechat id:</h3>
        <p><?php echo $wechatid?></p>-->
        <h3>Confirm Result:</h3>
        <p><?php echo $result?></p>
    </div>
</body>
<script>
    
</script>
</html>