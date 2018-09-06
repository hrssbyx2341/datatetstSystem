<?php
    session_start();
    $_SESSION['loginUser']=null;
    $_SESSION['loginPassword']=null;
    session_unset($_SESSION['loginUser']);
    session_unset($_SESSION['loginPassword']);
    header("Location:/dataManagementSystem/AP/User/login.php");
?>