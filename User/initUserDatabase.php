<?php
    include_once "databaseInfo.php";

    function initUserDatabase(){
        echo "Connect DataBase";
        global  $userDatabaseUser, $userDatabasePassword , $userDatabaseName, $userTableName,$adminUserLevel,$normalUserLevel;
        $con = mysql_connect("localhost",$userDatabaseUser,$userDatabasePassword);
        if(!$con){
            echo "Could not connect ".mysql_error()."<br>";
            die("Could not connect ".mysql_error());
        }else{
            echo "connect data base sucessful<br>";
        }
        mysql_query("set names utf8");

        if(mysql_query("create database ".$userDatabaseName,$con)){
            echo "User database created<br>";
        }else{
            echo "Error creating database:".mysql_error()."<br>";
        }
        if(!mysql_select_db($userDatabaseName,$con))
            echo "Select database failed".mysql_error()."<br>";
        $sql = "create table ".$userTableName."(
          ID int  Not NULL  AUTO_INCREMENT,
          PRIMARY KEY(ID),
          User varchar(64),
          Password varchar(64),
          Level int,
          CreateDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ";
        if(!mysql_query($sql,$con)){
            echo "Error[create user]:".mysql_error()."<br>";
        }else {
            echo "create user table finished<br>";
        }
        $sql = "select * from ".$userTableName." Where User='HZMCT'";
        $res = mysql_query($sql);
        if(!mysql_num_rows($res)){
            $sql = "insert into ".$userTableName."(User, Password, Level) value('HZMCT','".md5('HZMCT123456')."',".$adminUserLevel.")";
            $res = mysql_query($sql);
            if(!$res){
                echo "Error[init op]:".mysql_error()."<br>";
            }else{
                echo "init op finished<br>";
            }
        }else {
            echo "op is exist<br>";
        }
        mysql_close($con);
    }
initUserDatabase();
?>