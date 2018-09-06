<?php
/* 验证登录 */
    include_once "../User/USEROP.php";
    session_start();
    $_USEROP = new USEROP();
    $loginResult = $_USEROP->checkUser($_SESSION['loginUser'],$_SESSION['loginPassword']);
    if($loginResult == -1 || $loginResult == -2){
        header("Location:/dataManagementSystem/AP/User/login.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>图标测试页面</title>
    <meta charset="UTF-8" http-equiv="refresh" content="10" >
    <link rel="stylesheet" type="text/css" href="CSS/index.css">
<!--    <meta charset="UTF-8">-->

</head>
<body >

<?php
include_once "menu.php";
showMenu();
?>
<div style="height: 20px"></div>

<div align="center">
<div style="height: 50%;">
    <div style="width: 50%; float: left">
        <img src="StatisticalImage/CapactyHourEveryDay.php">
    </div>
    <div style="width: 50%; float: right">
        <img src="StatisticalImage/CapactyDayEveryWeek.php">
    </div>
</div>

<div style="height: 50%;">
    <div style="width: 50%; float: left">
        <div style="width: 30%; float: left">
            <img src="StatisticalImage/RepairDay.php">
        </div>
        <div style="width: 70%; float: right">
            <img src="StatisticalImage/ProjectRepairHour.php">
        </div>
    </div>
    <div style="width: 50%; float: left">
        <div style="width: 30%; float: left">
            <img src="StatisticalImage/RepairMonth.php">
        </div>
        <div style="width: 70%; float: right">
            <img src="StatisticalImage/ProjectRepairDay.php">
        </div>
    </div>
</div>
</div>

<?php
//    require_once("../BP/GMFC.php");
//
//    $_GMFC = new GMFC();
//
//    echo "1";
//    echo "<br>";
//date_default_timezone_set('Asia/Shanghai');
//    $year = date('Y');
//    $month = date('m');
//    $day = date('d');
//    $hour = date('H');
//
//echo $year.$month.$day.$hour;
//echo "<br>";
//
//    $data = $_GMFC->getProjectRepair($year,$month,$day,null);
//
//echo "3";
//echo "<br>";
//    var_dump($data);
//?>



</body>
</html>
