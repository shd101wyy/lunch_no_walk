<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div id="my_div">
            <h1>
                Please Wait While Uploading Data to Server.  <br>
                请稍等， 我们正在上传信息到服务器。
            </h1> 
        </div>
    </body>
    <?php 
        //echo "Restaurant add meal";
        $intro = $_POST["intro"];
        //echo "Introduction: " . $intro . "\n";
        $price = $_POST["price"];
        //echo "Price: " . $price . "\n";
        $week_day = $_POST["week_day"];
        //echo "Weekday: " . $week_day;

        $target_dir = "uploads/";
        $base = $_FILES["uploadPics"]["name"];
        $id = $_POST["id"];

        $update_file = 0; // keep track of whether update file
        //echo "base: " . basename( $_FILES["uploadPics"]["name"]);
        if(empty($base)){ // base is empty
            $update_file = 0;
        }
        else{
            /**
            *  TODO: check file already exist.
            **/
            $target_dir = $target_dir . $base;
            //echo "target_dir: " . $target_dir;
            //echo "tmp_name: " . $_FILES["uploadPics"]["tmp_name"];
            
            // upload picture to ./uploads folder.
            if (move_uploaded_file($_FILES["uploadPics"]["tmp_name"], $target_dir)) {
                echo "The file ". basename( $_FILES["uploadPics"]["name"]). " has been uploaded.";
                $update_file = 1;
            } else {
                echo "Sorry, there was an error uploading your file.";
                $target_dir = "uploads/ichiban.png"; // change target dir since we got error
                $update_file = 0;
            }
        }
        // try connect to sql
        $cons = mysqli_connect("localhost", "uiuccssa_lunch", "4rfv5tgb", "uiuccssa_IchibanFood"); // 连接到数据库, connect to sql
        if (mysqli_connect_errno()){
            echo "Cannot connect to MySQL: " . mysqli_connect_error();
            exit;
        }
        if($update_file){
            // update relation
            $query_content = "UPDATE meals SET introduction = '$intro', 
                                               price = '$price',
                                               week_day = '$week_day',
                                               image_path = '$target_dir'
                                           WHERE id = '$id'"; 
        }
        else{
            $query_content = "UPDATE meals SET introduction = '$intro', 
                                               price = '$price',
                                               week_day = '$week_day'
                                           WHERE id = '$id'"; 
        }
        mysqli_query($cons, $query_content);
        $RESULT = "Done";
    ?>
    <script>
        var result = "<?php echo $RESULT ?>";
        if(result == "Done")
            window.location.replace("http://planetwalley.com/lunch_no_walk/administrator.php"); // reload administrator.php page
        else{ // error
            document.getElementById("my_div").innerHTML = "<h1> Error, Failed to update menu </h1>";
        }
    </script>
</html>
