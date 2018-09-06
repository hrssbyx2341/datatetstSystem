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
<?php

include_once "../BP/GMFC.php";

if(!empty($_POST)){
    $_GMFC = new GMFC();
    $_GMFC->exportExcel($_POST);
}

?>