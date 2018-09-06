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
    <style>
        td{text-align: left}
    </style>
</head>

<body>

<?php
include_once "menu.php";
showMenu();
?>

<div style="height: 40px;"></div>

<div id="div2Style">
    <h1 >导出测试报告</h1>
    <form action="exportExcel.php" method="post">
        <TABLE align="center" border="1" cellspacing="0" width="50%">
            <caption>型号选择</caption>

            <tr>
                <td>输入设备型号：</td>
                <td>
                    <select name="Type">
                        <option value="Y5">Y5</option>
                        <option value="Y7">Y7</option>
                        <option value="Y8">Y8</option>
                        <option value="Y10">Y10</option>
                        <option value="K7">K7</option>
                        <option value="K10">K10</option>
                        <option value="B301">B301</option>
                        <option value="B301_LVDS">B301-LVDS</option>
                        <option value="B301D_ELE01">B301D-ELE01</option>
                        <option value="B601">B601</option>
                        <option value="B701">B701</option>
                    </select>
                </td>
            </tr>

        </TABLE>
        <br>
        <input type="submit" value="导出Excel" align="center">
    </form>
</div>

<?php
    include_once "../BP/GMFC.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST)){
            $_GMFC = new GMFC();
            $_GMFC->exportExcel($_POST);
        }
    }
?>

</body>
</html>