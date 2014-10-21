<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "fuck_my_life");

class wechatCallbackapiTest{
    public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
        	echo $echoStr;
        	//exit;
        }
    }

    public function responseMsg(){
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>"; 
				if(!empty( $keyword )){
              		$msgType = "text";
                    // try connect to MySQL
                    // change the $user, $password, $db_name later
                    $cons = mysqli_connect("localhost", "planetnd_yiyi", "4rfv5tgb", "planetnd_lunch_no_walk");
                    // check connect error
                    if (mysqli_connect_errno()){
                        $contentStr = "无法连接到MySQL数据库: " . mysqli_connect_error();
                        //$mysqli_close($cons);
                    }
                    else{
                        // echo "成功链接到服务器数据库";
                        // save user_name and email to MySQL
                        
                        // 检查用户是否存在
                        // 如果存在则显示菜单
                        // 否则给予用户一个链接，让用户填写相关信息
                        
                        $result = mysqli_query($cons, "SELECT * FROM user WHERE wechatid='$fromUsername'");
                        if($result){ // 成功 query
                            // 检查结果是否存在
                            if(mysqli_num_rows($result) > 0){ // 结果存在
                                //$contentStr = "欢迎使用 Lunch No Walk ;)\n";
                                //$contentStr = $contentStr . "菜单如下:\n";
                                $current_hour = date("H"); // 24小时制。
                                if($current_hour >= 14)
                                    $current_weekday = date("l", strtotime("+1 day"));
                                else
                                    $current_weekday = date("l"); // 如果比14点往后，算下一天的。
                                $arr = mysqli_fetch_array($result, MYSQLI_NUM);
                                $pickup_location = $arr[4];
                                $is_admin = $arr[5];
                                $textTpl = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <ArticleCount>1</ArticleCount>
                                <Articles>
                                <item>
                                <Title><![CDATA[%s]]></Title> 
                                <Description><![CDATA[%s]]></Description>
                                <PicUrl><![CDATA[%s]]></PicUrl>
                                <Url><![CDATA[%s]]></Url>
                                </item>
                                </Articles>
                                </xml>"; 
                                if($is_admin == 1 && $keyword == "admin"){ // is admin, not user
                                    $resultStr = sprintf($textTpl, 
                                                        $fromUsername, 
                                                        $toUsername, 
                                                        $time, 
                                                        "news", 
                                                        "Welcome Admin", 
                                                        "Click me to edit menu",               
                                                "http://www.planetwalley.com/lunch_no_walk/ichiban.png",                                                                                                    "http://www.planetwalley.com/lunch_no_walk/administrator.php");
                                    
                                }
                                else{ // it is admin
                                    $resultStr = sprintf($textTpl, 
                                                        $fromUsername, 
                                                        $toUsername, 
                                                        $time, 
                                                        "news", 
                                                        "Ichiban", 
                                                        "Lunch No Walk, Menu for " . $current_weekday . " " . $current_hour,               
                                                "http://www.planetwalley.com/lunch_no_walk/ichiban.png",                                                                                                   "http://www.planetwalley.com/lunch_no_walk/meals.php?wechatid='$fromUsername'&pickup_location='$pickup_location'");
                                    
                                }
                	           echo $resultStr;                                
                                
                                
                            }
                            else{ // 结果不存在
                                $contentStr = "欢迎使用 Lunch No Walk ;)\n" . 
                                              "请您点击以下连接进行注册\n" .
                                              "<a href=\"www.planetwalley.com/lunch_no_walk/signup_page.php?wechatid='$fromUsername'\">点击这里注册</a>"; 
                                // 测试
                                //$contentStr = $contentStr . "\n" . $fromUsername;
                                //$contentStr = $contentStr . "rows: " . mysqli_num_rows($result);
                                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	            echo $resultStr;
                            }
                        }
                        else{ // query 不成功
                            $contentStr = "无法连接到数据库" . mysqli_error($cons);
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	       echo $resultStr;
                        }
                    }
                }else{
                	echo "Input something...";
                }
        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature(){
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
            exit;
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
		if( $tmpStr == $signature ){
            return true;
	    	}else{
			return false;
		}
	}
}

$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

?>