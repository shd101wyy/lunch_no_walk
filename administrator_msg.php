<html>
<?php
    // get user message
    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk"); // 连接到数据库
    if (mysqli_connect_errno()){
        echo "无法连接到MySQL数据库: " . mysqli_connect_error();
        exit;
    }
    $query_content = "SELECT user.last_name, user.first_name, user.wechatid, customer_msg.msg_id, customer_msg.msg, customer_msg.responded
                      FROM user 
                      INNER JOIN customer_msg
                          ON customer_msg.wechat_id = user.wechatid";
    $query_result = mysqli_query($cons, $query_content);
    if($query_result){
        $RESULT = array();
        while($php_arr = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
            array_push($RESULT, $php_arr);
        }
        $RESULT = json_encode($RESULT);
    }
    else{
        $RESULT = "Failed";
    }
?>
    <head>
        <title>
            Administrator Page
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
                    User Messages <br>
                </h1> 
            </div> 
            <div data-role="main" class="ui-content">
                <ul id="msg_ul" data-role="listview">
                </ul>
            </div>
        </div>
    </body>
    <script>
        var Failed = "Failed";
        var data = <?php echo $RESULT ?>;
        for(var i = 0; i < data.length; i++){
            var v = data[i];
            /*
             v is like 
             {"last_name":"Wang","first_name":"Yiyi","wechatid":"owHwut4vD3-Gf3WvMKKMBS-LFLIk","msg_id":"54811cbfb4582","msg":"I love u","responded":"0"}
            */
            var li = $(((v.responded === "0")?("<li> "):("<li data-theme='b'>"))+
                          "    <a href='#'>"+
                                    "<p>" + v.last_name + " " + v.first_name + "</p>" + 
                                    "<strong>" + v.msg +"</strong>" +
                               "</a>"+
                        +"</li>");
            li.v = v; // attach v object;
            li.click(function(){
                console.log(this.v);
            })
            $("#msg_ul").append(li);
        } 
        $('ul').listview().listview('refresh');
    </script>
</html>
