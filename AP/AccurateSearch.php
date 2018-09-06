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
    <meta charset="UTF-8">
    <title>测试数据管理系统</title>
    <link rel="stylesheet" type="text/css" href="CSS/index.css">
</head>

<body>

<?php
    include_once "menu.php";
    showMenu();
?>

<div style="height: 40px;"></div>
<div id="div2Style">
    <h1 >精准查找</h1>
    <form action="AccurateSearch.php" method="post">
        输入设备识别码：<input type="text" name="uuid" autofocus="autofocus">
        <input type="submit" value="确认">
    </form>
</div>

<?php
    include_once "../BP/GMFC.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $uuid = htmlspecialchars($_POST['uuid']);
        if(!empty($uuid)) {
            $GMFC_ = new GMFC();
            echo $GMFC_->AccurateScarch($uuid);
        }else{
            echo "<p align='center'>请输入识别码</p>";
        }
    }
?>
</body>
</html>