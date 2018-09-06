<?php
/* 验证登录 */
include_once "../../User/USEROP.php";
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
    <link rel="stylesheet" type="text/css" href="../CSS/index.css">
</head>

<body>

<?php
include_once "menu.php";
showMenu();
?>

<div style="height: 40px;"></div>
<div id="div2Style">
    <h1 >更改密码</h1>
    <form action="changePassword.php" method="post">
        旧密码：<input type="password" name="oldPassword">
        新密码：<input type="password" name="newPassword">
        确认新密码：<input type="password" name="sureNewPassword">
        <input type="submit" value="确认">
    </form>
</div>

<?php
    include_once "../../User/USEROP.php";
    $_USEROP = new USEROP();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $oldPassword = htmlspecialchars($_POST["oldPassword"]);
        $newPassword = htmlspecialchars($_POST["newPassword"]);
        $sureNewPassword = htmlspecialchars($_POST["sureNewPassword"]);
        if(empty($oldPassword) || empty($newPassword) || empty($sureNewPassword)){
            echo "<p align='center'>请正确输入</p>";
        }else{
            if($newPassword != $sureNewPassword){
                echo "<p align='center'>两次密码输入不一致</p>";
            }else{
                $temp = $_USEROP->updateUserPassword($_SESSION['loginUser'],$oldPassword,$newPassword);
                if(0 == $temp){
                    echo "<p align='center'>密码更改成功</p>";
                }else if(-1 == $temp){
                    echo "<p align='center'>密码更改失败,旧密码验证不通过</p>";
                }else{
                    echo "<p align='center'>密码更改失败</p>";
                }
            }
        }
    }
?>
</body>
</html>
