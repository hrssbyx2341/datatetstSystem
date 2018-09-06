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
    <h1 >模糊搜索结果</h1>
</div>

<?php
    include_once "../BP/GMFC.php";


    $tempPost = $_POST;
    if(!empty($_POST['date'])) {
        $longTime = strtotime(htmlspecialchars($_POST['date']));
        $yyyy = date('Y', $longTime);
        $MM = date('m', $longTime);
        $dd = date('d', $longTime);
        unset($tempPost['date']);
        $tempPost['Test_Dateyyyy'] = $yyyy;
        $tempPost['Test_DateMM'] = $MM;
        $tempPost['Test_Datedd'] = $dd;
    }




    $_GMFC = new GMFC();
    $_GMFC->FuzzySearch($tempPost);
?>

</body>
</html>

