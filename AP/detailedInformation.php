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
    <h1>详细信息</h1>
</div>

<?php
    include_once "../BP/GMFC.php";
    $_GMFC = new GMFC();
    $_GMFC->DetailedInformation(htmlspecialchars($_GET['Name']));
?>

</body>
</html>
