<?php
include_once "databaseInfo.php";

function initTestDataBase()
{
    echo "Connect DateBase";
    global $databaseUser, $databasePassword, $databaseName, $tableName;
    $con = mysql_connect("localhost", $databaseUser, $databasePassword);
    if (!$con) {
        echo "Could not connect " . mysql_error() . "<br>";
        die("Could not connect " . mysql_error());
    } else {
        echo "connect date base sucessful" . "<br>";
    }
    mysql_query("set names utf8");

    if (mysql_query("create database " . $databaseName, $con)) {
        echo "Test data database created<br>";
    } else {
        echo "Error creating database:" . mysql_error() . "<br>";
    }
    mysql_select_db($databaseName, $con);
    $sql = "create table " . $tableName . "(
        ID  int  Not NULL  AUTO_INCREMENT,
        PRIMARY KEY(ID),
        Name VARCHAR(64) NOT NULL,
        Type VARCHAR (64) NOT NULL,
        CPUType VARCHAR (64) NOT NULL ,
        Uuid VARCHAR (64) NOT NULL,
        LastUpdateDate VARCHAR(64) NOT NULL,
        CpuSerial VARCHAR (64) ,

        SpkTestTimes int DEFAULT 0,
        SpkPassTimes int DEFAULT 0,
        SpkNotPassTimes int DEFAULT 0,
        SpkEndResult int DEFAULT -1,
        
        HpTestTimes int DEFAULT 0,
        HpPassTimes int DEFAULT 0,
        HpNotPassTimes int DEFAULT 0,
        HpEndResult int DEFAULT -1,
        
        CameraTestTimes int DEFAULT 0,
        CameraPassTimes int DEFAULT 0,
        CameraNotPassTimes int DEFAULT 0,
        CameraEndResult int DEFAULT -1,
        
        RecordTestTimes INT DEFAULT 0,
        RecordPassTimes INT DEFAULT 0,
        RecordNotPassTimes INT DEFAULT 0,
        RecordEndResult int DEFAULT -1,
        
        TFTestTimes INT DEFAULT  0,
        TFPassTimes INT DEFAULT 0,
        TFNotPassTimes INT DEFAULT 0,
        TFEndResult INT DEFAULT -1,
        
        USBTestTimes INT DEFAULT 0,
        USBPassTimes INT DEFAULT 0,
        USBNotPassTimes INT DEFAULT 0,
        USBEndResult INT DEFAULT -1,
        
        EthTestTimes INT DEFAULT 0,
        EthPassTimes INT DEFAULT 0,
        EthNotPassTimes INT DEFAULT 0,
        EthEndResult INT DEFAULT -1,
        
        WifiTestTimes INT DEFAULT 0,
        WifiPassTimes INT DEFAULT 0,
        WifiNotPassTimes INT DEFAULT 0,
        WifiEndResult INT DEFAULT -1,
        
        MobileNetTestTimes INT DEFAULT 0,
        MobileNetPassTimes INT DEFAULT 0,
        MobileNetNotPassTimes INT DEFAULT 0,
        MobileNetEndResult INT DEFAULT -1,
        
        GPSTestTimes INT DEFAULT 0,
        GPSPassTimes INT DEFAULT 0,
        GPSNotPassTimes INT DEFAULT 0,
        GPSEndResult INT DEFAULT -1,
        
        BTTestTimes  INT DEFAULT 0,
        BTPassTimes  INT DEFAULT 0,
        BTNotPassTimes  INT DEFAULT 0,
        BTEndResult  INT DEFAULT -1,
        
        ScreenTestTimes  INT DEFAULT 0,
        ScreenPassTimes  INT DEFAULT 0,
        ScreenNotPassTimes  INT DEFAULT 0,
        ScreenEndResult  INT DEFAULT -1,
        
        TSTestTimes  INT DEFAULT 0,
        TSPassTimes  INT DEFAULT 0,
        TSNotPassTimes INT DEFAULT 0,
        TSEndResult  INT DEFAULT -1,
        
        RS232TestTimes INT DEFAULT 0,
        RS232PassTimes INT DEFAULT 0,
        RS232NotPassTimes INT DEFAULT 0,
        RS232EndResult INT DEFAULT -1,
        
        RS485TestTimes INT DEFAULT 0,
        RS485PassTimes INT DEFAULT 0,
        RS485NotPassTimes INT DEFAULT 0,
        RS485EndResult INT DEFAULT -1,
        
        GPIOTestTimes INT DEFAULT 0,
        GPIOPassTimes INT DEFAULT 0,
        GPIONotPassTimes INT DEFAULT 0,
        GPIOEndResult INT DEFAULT -1,
        
        RTCTestTimes INT DEFAULT 0,
        RTCPassTimes INT DEFAULT 0,
        RTCNotPassTimes INT DEFAULT 0,
        RTCEndResult INT DEFAULT -1,
        
        ISPass INT DEFAULT 0,
        
        Test_Dateyyyy VARCHAR (4) NOT NULL,
        Test_DateMM VARCHAR (4) NOT NULL,
        Test_Datedd VARCHAR (4) NOT NULL,
        Test_TimeHH VARCHAR (2) NOT NULL,
        Test_Timemm VARCHAR (2) NOT NULL,
        Test_Timess VARCHAR (2) NOT NULL,
        UpLoadDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ";
    if (!mysql_query($sql, $con)) {
        echo "Error[create testdata]: " . mysql_error() . "<br>";
    } else {
        echo "create testdata_db table finished<br>";
    }

    mysql_close($con);
}
initTestDataBase();
?>