<html>
    <?php
        $wechatid = $_GET["wechatid"];  // get wechatid
    ?>
    <head>
        <title>
            注册
        </title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes"> <!-- iOS full screen -->
        <meta name="mobile-web-app-capable" content="yes"> <!-- android full screen -->
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css">
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    </head>
    
    <body>
        <!-- 注册界面 -->
        <div data-role="page" id="signup_page">
            <!--<div data-role="header">
              <h1> 注册页面 </h1>
            </div>-->
            <div data-role="main" class="ui-content" id="signup_page_content">
                <h3> 请填写下面信息 </h3>
                <!--<form id="signup_form" action="#"> -->
                <label for="signup_username">姓名:</label>
                <input type="text" id="signup_username" data-clear-btn="true">
                <label for="signup_phonenumber">联系电话:</label>
                <input type="text" id="signup_phonenumber" data-clear-btn="true" name="signup_phonenumber">
                <br>
                <button id="user_signup" data-inline="true">Sign Up!</button> 
              <!-- </form> -->
            </div>
        </div>
        <!--
        <div data-role="page" id="signup_success">
            <div data-role="main" class="ui-content">
                <h3 align="center">
                    注册成功
                </h3>
            </div>
        </div>
        -->
    </body>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#user_signup").click(function(){
                var wechatid = "<?php echo $wechatid; ?>"; // get wechatid
                wechatid = wechatid.slice(1, wechatid.length - 1); // remove ''
                var user_name = $("#signup_username").val();
                var phonenumber = $("#signup_phonenumber").val();
                // alert("user_name: " +user_name+ " phone: " + phonenumber);
                $.ajax({
                    url: "./signup_action.php",
                    async: false,
                    type: "POST",
                    data:{name: user_name,
                          phone: phonenumber,
                          wechatid: wechatid}
                }).done(function(data){
                    $("#signup_page_content").html("<h3 align='center'> 注册成功 </h3>")
                }).fail(function(data){
                    alert(data);
                })
            })
        })
    </script>
</html>