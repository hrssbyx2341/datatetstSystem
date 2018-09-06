<?php
    include_once "../BP/GMFC.php";



    $json=file_get_contents("php://input");




    $GMFS_ = new GMFC();
    $result = $GMFS_->addData($json);
    echo $result;




?>