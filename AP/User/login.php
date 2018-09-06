<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>测试数据管理系统</title>
    <link rel="stylesheet" type="text/css" href="../CSS/index.css">
</head>

<body>


<div style="height: 40px;"></div>
<div id="div2Style">
    <h1 >用户登录</h1>
    <form action="login.php" method="post">
        用户名：<input type="text" name="User">
        密码：<input type="password" name="Password">
        <input type="submit" value="确认">
    </form>
</div>

    <?php
        include_once "../../User/USEROP.php";
        session_start();
        $_USEROP = new USEROP();
        $loginResult = $_USEROP->checkUser($_SESSION['loginUser'],$_SESSION['loginPassword']);
        if($loginResult == -1 || $loginResult == -2){

        }else{
            header("Location:/dataManagementSystem/AP/AccurateSearch.php");
        }
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(empty(htmlspecialchars($_POST['User']))){
                $UserErr = "请输入用户名";
                echo "<p align='center'>$UserErr<p>";
            }else{
                $User = htmlspecialchars($_POST['User']);
            }
            if(empty(htmlspecialchars($_POST['Password']))){
                $PasswordErr = "请输入密码";
                echo "<p align='center'>$PasswordErr<p>";
            }else{
                $Password = htmlspecialchars($_POST['Password']);
            }
            if(!empty($User) && !empty($Password)) {
                $loginResult = $_USEROP->checkUser($User, $Password);
                if($loginResult == -1 || $loginResult == -2){
                    echo "<p align='center'>登录失败<p>";
                }else{
                    $_SESSION['loginUser'] = $User;
                    $_SESSION['loginPassword'] = $Password;
                    header("Location:/dataManagementSystem/AP/debug.php");
                }
            }
        }
    ?>

</body>
</html>