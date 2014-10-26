<html>
    <head>
        <title>
            用户充值
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes"> <!-- iOS full screen -->
        <meta name="mobile-web-app-capable" content="yes"> <!-- android full screen -->
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css">
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
        <!--<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>-->
        <style>
            .ui-input-text.ui-custom {
                border: none;
                box-shadow: none;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header">
                <h1>
                    充值
                </h1>
            </div> 
            <div data-role="main" class="ui-content">
                <form class="ui-filterable">
                    <input id="myFilter1" data-type="search" placeholder="search">
                </form>
                <ul data-role="listview" data-inset="true" id="users_list" data-filter="true" data-input="#myFilter1">
                    <!-- Show user incomplete order here -->
                </ul>
            </div>
        </div>
        <!-- +/- money -->
        <div data-role="page" id="money_change" data-dialog="true">
          <div data-role="main" class="ui-content">
          <h3>充值/减值</h3>
            <p>输入正数充值，负数减值</p>
            <input type="text" placeholder="在这里输入金额" id="input_money">
            <a href="#" class="ui-btn ui-btn-inline ui-btn-b ui-shadow ui-corner-all ui-icon-check ui-btn-icon-left ui-btn-inline ui-mini" id='money_button'>Submit</a>
            <a href="#" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-inline ui-mini" data-rel="back">Cancel</a>
          </div>
        </div> 
    </body>
    
    <script>
        var current_url = document.URL;
        $(document).ready(function(){
            <?php
                // try connect to sql
                $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库, connect to sql
                if (mysqli_connect_errno()){
                    $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
                    echo $RESULT;
                    exit;
                }
                // get user order
                $query_content = "SELECT * FROM user ORDER BY last_name;";
                $query_result = mysqli_query($cons, $query_content);
                if($query_result){
                    $my_array = array();
                    while($php_arr = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
                        array_push($my_array, $php_arr);
                    }
                    $js_array = json_encode($my_array);
                    $USERS = $js_array;
                }
                else{
                    $USERS = "Cannot connect to MySQL";
                    exit;
                }
            ?>
            var users = <?php echo $USERS; ?>;
            console.log(users);

            for(var i = 0; i < users.length; i++){
                var user = users[i];
                var last_name = user.last_name;
                var first_name = user.first_name;
                var phone = user.phone;
                var money = user.money;
                var content = 
                "<li id='li"+i+"'>" + 
                        "<a href='#money_change' onclick=\"clickA('"+user.wechatid+"');\">"+
                        "<h2>Last Name:   " + last_name + "</h2>" +
                        "<h2>First Name:  " + first_name + "</h2>" +
                        "<p> Phone: " + phone + "</p>" + 
                        "<p> Money: " + money + "</p>" + 
                        "<p> 点击我充值 (正数充值， 负数减值) </p>" +
                        "</a>" +
                "</li>";
                $("#users_list").append(content);
            }
            // refresh listview
            $('ul').listview('refresh');
        })
        var clickA = function(id){
            console.log(id);
            $("#money_button").attr("wechatid", id); // save id to that button
        }
        $("#money_button").click(function(){
            var wechatid = $("#money_button").attr("wechatid");
            var money = parseFloat($("#input_money").val());
            console.log("to user: " + wechatid + "   money: " + money);
            $.ajax({
                    url: "./money_change.php",
                    async: false,
                    type: "POST",
                    // 下面是发送的信息
                    data:{wechatid : wechatid, 
                          money: money}
                }).done(function(data){
                    console.log(data);
                    if(data == "Success")
                        window.location.replace(current_url); // reload page
                    else alert(data);
                }).fail(function(data){
                    alert(data);
                });
        })
    </script>
    
</html>