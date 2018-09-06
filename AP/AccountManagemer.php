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
        <?php
            include_once "../User/USEROP.php";
            global $adminUserLevel;
            $_USEROP = new USEROP();

            echo "<h1 >".$_SESSION['loginUser']."</h1>";
            echo "<a href='User/changePassword.php' style='text-align: center;color: blue; margin: 10px ; font-family: \"微软雅黑 Light\";font-style: inherit; font-size: 20px;'>更改密码</a><br>";
            if($_USEROP->getUserLevel($_SESSION['loginUser'],$_SESSION['loginPassword']) == $adminUserLevel ){
                echo "<a href='User/addAccount.php' style='text-align: center;color: blue; margin: 10px ; font-family: \"微软雅黑 Light\";font-style: inherit; font-size: 20px;'>添加用户</a><br>";
            }
            echo "<a href='User/logout.php' style='text-align: center;color: blue; margin: 10px ; font-family: \"微软雅黑 Light\";font-style: inherit; font-size: 20px;'>注销登录</a>";
        ?>
    </div>

</body>
</html>
