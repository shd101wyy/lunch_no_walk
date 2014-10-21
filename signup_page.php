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
        <!--<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>-->
    </head>
    
    <body>
        <!-- 注册界面 -->
        <div data-role="page" id="signup_page">
            <div data-role="header">
                <h1> 
                    New subscription <br>
                    注册页面
                </h1> 
            </div> 
            <div data-role="main" class="ui-content" id="signup_page_content">
                <!-- <h3> 请填写下面信息 </h3> -->
                <!-- 姓 -->
                <label for="signup_user_last_name"> Input Last name please: </label>
                <input type="text" id="signup_user_last_name" data-clear-btn="true">
                <!-- 名 --> 
                <label for="signup_user_first_name"> Input First name please: </label>
                <input type="text" id="signup_user_first_name" data-clear-btn="true">             
                <!-- <label for="signup_username">姓名:</label>
                <input type="text" id="signup_username" data-clear-btn="true"> -->
                <!-- 电话 -->
                <label for="signup_phonenumber"> Input your cellphone number please:</label>
                <input type="text" id="signup_phonenumber" data-clear-btn="true" name="signup_phonenumber">
                
                <!-- 下拉菜单 -->
                <fieldset class="ui-field-contain">
                    <label for="pickup_location"> Select one of the location most close to you: </label>
                    <select name="pickup_location" id="pickup_location">
                      <option value="MNTL">MNTL</option>
                      <option value="BIF">BIF</option>
                      <option value="RAL">RAL</option>
                    </select>
                </fieldset>
                <br>
                <button id="user_signup" data-inline="true">Sign Up!</button> 
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
        // 检查用户姓名
        var checkUsernameValid = function(user_name){
            return user_name.match(/^[a-zA-Z]+$/);
        }
        // 检查用户phonenumber
        var checkPhonenumberValid = function(phonenumber){
            return phonenumber.match(/^[0-9]+$/);
        }
        var wechatid = "<?php echo $wechatid; ?>"; // get wechatid
        if(wechatid[0] == "'" || wechatid[0] == '"')
            wechatid = wechatid.slice(1, wechatid.length - 1); // remove ''
        $(document).ready(function(){
            $("#user_signup").click(function(){
                var user_last_name = $("#signup_user_last_name").val();
                var user_first_name = $("#signup_user_first_name").val();
                var phonenumber = $("#signup_phonenumber").val();
                var pickup_location = $("#pickup_location option:selected").val();
                // 检查 用户名
                if(!checkUsernameValid(user_last_name)){
                    alert("Invalid last name: " + user_last_name);
                    return;
                }
                if(!checkUsernameValid(user_first_name)){
                    alert("Invalid first name: " + user_first_name);
                    return;
                }
                if(!checkPhonenumberValid(phonenumber)){
                    alert("Invalid phone number: " + phonenumber);
                    return;
                }


                // 发送到 signup_action.php
                $.ajax({
                    url: "signup_action.php",
                    async: false,
                    type: "POST",
                    // 下面是发送的信息
                    data:{last_name: user_last_name,
                          first_name: user_first_name,
                          phone: phonenumber,
                          pickup_location: pickup_location,
                          wechatid: wechatid}
                }).done(function(data){
                    $("#signup_page_content").html("<h3 align='center'> 注册成功 <br> Subscript Successfully</h3>")
                }).fail(function(data){
                    alert(data);
                })
            })
        })
    </script>
</html>