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
    <h1 >添加新用户</h1>
    <form action="addAccount.php" method="post">
        用户名：<input type="text" name="User">
        密码：<input type="password" name="Password">
        确认密码：<input type="password" name="surePassword">
        <input type="submit" value="确认">
    </form>
</div>

<?php
    include_once "../../User/USEROP.php";
    global $normalUserLevel;
    $_USEROP = new USEROP();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $User = htmlspecialchars($_POST["User"]);
        $newPassword = htmlspecialchars($_POST["Password"]);
        $sureNewPassword = htmlspecialchars($_POST["surePassword"]);
        if(empty($User) || empty($newPassword) || empty($sureNewPassword)){
            echo "<p align='center'>请正确输入</p>";
        }else{
            if($newPassword != $sureNewPassword){
                echo "<p align='center'>两次密码输入不一致</p>";
            }else{
                $temp = $_USEROP->addUser($User,$newPassword,$normalUserLevel);
                if(0 == $temp){
                    echo "<p align='center'>添加新用户成功</p>";
                }else if(-1 == $temp){
                    echo "<p align='center'>用户已存在</p>";
                }else{
                    echo "<p align='center'>用户添加失败</p>";
                }
            }
        }
    }
?>
</body>
</html>
