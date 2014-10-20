<?php
    echo "Enter Here";
    // change meal settings
    // eg. change price, introduction, picture
    
    $intro = $_POST["intro"];
    echo "Introduction: " . $intro . "\n";
    $price = $_POST["price"];
    echo "Price: " . $price . "\n";
        
    $target_dir = "uploads/";
    $target_dir = $target_dir . basename( $_FILES["uploadPics"]["name"]);
    echo "target_dir: " . $target_dir;
    echo "tmp_name: " . $_FILES["uploadPics"]["tmp_name"];
    
    // upload picture to ./uploads folder.
    if (move_uploaded_file($_FILES["uploadPics"]["tmp_name"], $target_dir)) {
        echo "The file ". basename( $_FILES["uploadPics"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    
    echo "Done";    
?>