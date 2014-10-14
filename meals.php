<html>
    <?php 
        $wechatid = $_GET["wechatid"];
        $pickup_location = $_GET["pickup_location"];
    ?>
    <head>
        <title>
            Meals
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes"> <!-- iOS full screen -->
        <meta name="mobile-web-app-capable" content="yes"> <!-- android full screen -->
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css">
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
    </head>
    <body>
        <div data-role="page" id="meal_page">
            <!-- <div data-role="header">
                <h1>
                    Meal A
                </h1>
            </div> -->
            <div data-role="main" class="ui-content">
                <ul data-role="listview" data-inset="true">
                    <li>
                        <a href="#meal_A"><img src="images.jpeg">
                            <h2> Meal A</h2>
                            <p> 宫爆鸡丁， 蒜蓉生姜菜</p>
                        </a>
                    </li>
                    <li>
                        <a href="#meal_B"><img src="images.jpeg">
                            <h2> Meal B </h2>
                            <p>  孜然牛肉， 清炒芥兰 </p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div data-role="page" id="meal_A">
            <div data-role="header">
                <h1>
                    Meal A
                </h1>
            </div>   
            <div data-role="main" class="ui-content">
                <img src="images.jpeg">
                <p> 宫爆鸡丁， 蒜蓉生姜菜 </p>
                <!-- 下拉菜单 pickup location -->
                <fieldset class="ui-field-contain">
                    <label for="pickup_location"> Select one of the location most close to you: </label>
                    <select name="pickup_location" id="pickup_location">
                        <!-- Fill In later using JavaScript -->
                    </select>
                </fieldset>
                
                <!-- 下拉菜单 点餐数量 -->
                <!-- 下拉菜单 -->
                <fieldset class="ui-field-contain">
                    <label for="order_num"> Select how many meals you want to order: </label>
                    <select name="order_num" id="order_num">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </fieldset>
                
                <h4>Price: $5.00 </h4>
                <button> Submit </button>
            </div>
        </div>
        <div data-role="page" id="meal_B">
            <div data-role="header">
                <h1>
                    Meal B
                </h1>
            </div> 
            <div data-role="main" class="ui-content">
                <img src="images.jpeg">
                <p> 孜然牛肉， 清炒芥兰 </p>
            </div>
        </div>
    </body>
    
    <script>
        $(document).ready(function(){
            // set default pickup selection
            var pickup_location = "<?php echo $pickup_location; ?>"
            if(pickup_location[0] == "'" || pickup_location[0] == "\"")
                pickup_location = pickup_location.slice(1, pickup_location.length - 1);
            var pickup_location_selection_options = "";
            var locations = ["MNTL", "BIF", "RAL"];
            for(var i = 0; i < locations.length; i++){
                var l = locations[i];
                if(l == pickup_location){
                    pickup_location_selection_options += "<option selected='selected'>" + pickup_location + "</option>";
                }
                else{
                    pickup_location_selection_options += "<option>" + l + "</option>";
                }
            }
            $("#pickup_location").html(pickup_location_selection_options);
            
        })
    </script>
</html>