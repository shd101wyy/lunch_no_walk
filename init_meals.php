    <?php 
        $wechatid = stripslashes($_POST["wechatid"]);
        if($wechatid[0] === "'"){
            $wechatid = substr($wechatid, 1, -1);
        }
       
        // calculate weekday.
        $current_hour = date("H"); // 24小时制。
        if($current_hour >= 14)
            $current_weekday = date("l", strtotime("+1 day"));
        else
            $current_weekday = date("l"); // 如果比14点往后，算下一天的。

        $RESULT = "";
        // retrieve data from database
        // try connect to sql
        $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库, connect to sql
        if (mysqli_connect_errno()){
            $RESULT = "Cannot connect to MySQL: " . mysqli_connect_error();
            echo "Failed";
            exit;
        }
        // get menus today
        $query_content = "SELECT * FROM meals WHERE week_day='$current_weekday'and available=1;";
        $query_result = mysqli_query($cons, $query_content);

        if($query_result){
            $my_array = array(); 
            while($php_arr = mysqli_fetch_array($query_result, /*MYSQLI_NUM*/MYSQLI_ASSOC)){
                array_push($my_array, $php_arr);
            }
            $js_array = json_encode($my_array);
            $RESULT = $js_array;
        }
        else{
            $RESULT = "Cannot connect to MySQL";
            echo "Failed";
            exit;
        }

        // get user order
        $query_content = "SELECT * FROM meal_order WHERE wechat_id='$wechatid' ORDER BY order_date DESC";
        $query_result = mysqli_query($cons, $query_content);
        if($query_result){
            $my_array = array();
            while($php_arr = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
                $menu_id = $php_arr["menu_id"]; // get menu_id
                // retrieve menu according to menu_id

                $query_for_menu = "SELECT * FROM meals WHERE id='$menu_id'";
                $query_for_menu = mysqli_query($cons, $query_for_menu);

                $menu_data = mysqli_fetch_array($query_for_menu, MYSQLI_ASSOC);

                // add menu property to $php_arr.
                $php_arr["menu"] = $menu_data;
                array_push($my_array, $php_arr);
            }
            $js_array = json_encode($my_array);
            $ORDER_HISTORY = $js_array;
        }
        else{
            $ORDER_HISTORY = "Cannot connect to MySQL";
            echo "Failed";
            exit;
        }

        // get user info according to wechat id 
        $query_content = "SELECT * FROM user WHERE wechatid='$wechatid'";
        $query_result = mysqli_query($cons, $query_content);
        if($query_result){
            $USER_INFO = json_encode(mysqli_fetch_array($query_result, MYSQLI_ASSOC));
        }
        else{
            $USER_INFO = "\"Cannot connect to MySQL\"" . $query_content;
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

        $output = array();
        array_push($output, $RESULT);
        array_push($output, $ORDER_HISTORY);
        array_push($output, $USER_INFO);
        array_push($output, $ADMIN_RESPONSE);
        $output = json_encode($output);
        echo $output;
    ?>