<html>
<?php
    $wechatid = $_GET["wechatid"];
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
        <h3>Wechat id:</h3>
        <p><?php echo $wechatid?></p>
    </div>
</body>
<script>
    
</script>
</html>