<?php
    include_once "databaseInfo.php";
    include_once "../User/USEROP.php";
class GMFC {


    /**************************对外开放的函数开始线*****************************/
    /**
     * 根据客户端提交上来的json字符串，把数据存到数据库里面
     * @param $jsonString 客户端提交的json字符串
     * @return array|null|resource 返回给客户端的消息
     */
    public function addData($jsonString){
        return $this->_addData($jsonString);
    }

    public function AccurateScarch($Uuid){
        return $this->_AccurateScarchResult($Uuid);
    }

    public function DetailedInformation($Name){
        return $this->_detailedInformation($Name);
    }

    public function FuzzySearch($tempPost){
        return $this->_FuzzySearch($tempPost);
    }

    public function exportExcel($tempPost){
        return $this->_exportExcel($tempPost);
    }

    public function getHourEveryDay(){
        return $this->_getHourEveryDay();
    }
    public function getDayEveryMonth(){
        return $this->_getDayEveryMonth();
    }

    public function getRepair($year,$mon,$day,$hour){
        return $this->_getRepair($year,$mon,$day,$hour);
    }

    public function getProjectRepair($year,$mon,$day,$hour){
        return $this->_getProjectRepair($year,$mon,$day,$hour);
    }
    /**************************对外开放的函数结束线*****************************/

    /************ 统计项目返修次数 *****************/
    private function _getProjectRepair($year,$mon,$day,$hour=null){
        global $databaseName,$tableName,$databaseUser,$databasePassword;
        if($hour == null){
            $cmd = "select * from ".$tableName." where Test_Dateyyyy='".$year."' AND Test_DateMM='".$mon."' AND Test_Datedd='".$day."'";
        }else{
            $cmd = "select * from ".$tableName." where Test_Dateyyyy='".$year."' AND Test_DateMM='".$mon."' AND Test_Datedd='".$day."' AND Test_TimeHH='".$hour."'";
        }
        $con = mysql_connect('localhost',$databaseUser,$databasePassword);
        if(!$con){
            return null;
        }
        mysql_select_db($databaseName,$con);
        $tmpresult = mysql_query($cmd);
        $number = mysql_num_rows($tmpresult);
        $Spk =0;$Hp=0;$Cam=0;$Rec=0;$TF=0;$USB=0;$Eth=0;$Wifi=0;$_4G=0;$GPS=0;$BT=0;$Scre=0;$TS=0;$_232=0;$_485=0;$GPIO=0;$RTC=0;
        if($number == 0){
            mysql_close($con);
            return array($Spk,$Hp,$Cam,$Rec,$TF,$USB,$Eth,$Wifi,$_4G,$GPS,$BT,$Scre,$TS,$_232,$_485,$GPIO,$RTC);
        }else{
            while ($resultArray = mysql_fetch_assoc($tmpresult)) {
                $Spk +=$resultArray['SpkNotPassTimes'];
                $Hp  +=$resultArray['HpNotPassTimes'];
                $Cam +=$resultArray['CameraNotPassTimes'];
                $Rec  +=$resultArray['RecordNotPassTimes'];
                $TF +=$resultArray['TFNotPassTimes'];
                $USB  +=$resultArray['USBNotPassTimes'];
                $Eth +=$resultArray['EthNotPassTimes'];
                $Wifi  +=$resultArray['WifiNotPassTimes'];
                $_4G  +=$resultArray['MobileNetNotPassTimes'];
                $GPS +=$resultArray['GPSNotPassTimes'];
                $BT +=$resultArray['BTNotPassTimes'];
                $Scre  +=$resultArray['ScreenNotPassTimes'];
                $TS +=$resultArray['TSNotPassTimes'];
                $_232  +=$resultArray['RS232NotPassTimes'];
                $_485  +=$resultArray['RS485NotPassTimes'];
                $GPIO +=$resultArray['GPIONotPassTimes'];
                $RTC  +=$resultArray['RTCNotPassTimes'];
            }
            mysql_close($con);
            return array($Spk,$Hp,$Cam,$Rec,$TF,$USB,$Eth,$Wifi,$_4G,$GPS,$BT,$Scre,$TS,$_232,$_485,$GPIO,$RTC);
        }
    }
    /************ 统计项目返修次数结束线 ***********/


    /************ 统计返修率 ********************/
    private function _getRepair($year,$mon,$day,$hour=null){
        global $databaseName,$tableName,$databaseUser,$databasePassword;
        if($hour == null){
            $cmd = "select * from ".$tableName." where Test_Dateyyyy='".$year."' AND Test_DateMM='".$mon."' AND Test_Datedd='".$day."'";
        }else{
            $cmd = "select * from ".$tableName." where Test_Dateyyyy='".$year."' AND Test_DateMM='".$mon."' AND Test_Datedd='".$day."' AND Test_TimeHH='".$hour."'";
        }
        $con = mysql_connect('localhost',$databaseUser,$databasePassword);
        if(!$con){
            return null;
        }
        mysql_select_db($databaseName,$con);
        $tmpresult = mysql_query($cmd);
        $number = mysql_num_rows($tmpresult);
        if($number == 0){
            mysql_close($con);
            return array(1,0);
        }else{
            $pass = 0;$repair = 0;
            while ($resultArray = mysql_fetch_assoc($tmpresult)) {
                $isRepair = false;
                foreach ($resultArray as $key=>$value) {
                    if(substr_count($key,"NotPassTimes") >= 1){
                        if($value > 0){
                            $isRepair = true;
                            break;
                        }
                    }
                }
                if($isRepair){
                    $repair++;
                }else{
                    $pass++;
                }
            }
            mysql_close($con);
            return array($pass,$repair);
        }
    }
    /************ 统计返修率结束 ********************/

    /************ 统计当月每天产能 ******************/
    private function _getDayEveryMonth($year = null,$mon = null){
        global $databaseName,$tableName,$databaseUser,$databasePassword;
        date_default_timezone_set('Asia/Shanghai');
        if($year == null || $mon == null ){
            $Year = date('Y');
            $Month = date('m');
        }else{
            $Year = $year;
            $Month = $mon;
        }

        $cmd = "select * from ".$tableName." where Test_Dateyyyy='".$Year."' AND Test_DateMM='".$Month."'";

        $con = mysql_connect('localhost',$databaseUser,$databasePassword);
        if(!$con){
            return null;
        }
        mysql_select_db($databaseName,$con);
        $tmpresult = mysql_query($cmd);
        $number = mysql_num_rows($tmpresult);

        if($number == 0){
            mysql_close($con);
            return array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        }else{
            $_1 = 0;
            $_2 = 0;
            $_3 = 0;
            $_4 = 0;
            $_5 = 0;
            $_6 = 0;
            $_7 = 0;
            $_8 = 0;
            $_9 = 0;
            $_10 = 0;
            $_11 = 0;
            $_12 = 0;
            $_13 = 0;
            $_14 = 0;
            $_15 = 0;
            $_16 = 0;
            $_17 = 0;
            $_18 = 0;
            $_19 = 0;
            $_20 = 0;
            $_21 = 0;
            $_22 = 0;
            $_23 = 0;
            $_24 = 0;
            $_25 = 0;
            $_26 = 0;
            $_27 = 0;
            $_28 = 0;
            $_29 = 0;
            $_30 = 0;
            $_31 = 0;
            while ($resultArray = mysql_fetch_assoc($tmpresult)) {
                switch ((int)$resultArray['Test_Datedd']) {
                    case 1:
                        $_1++;
                        break;
                    case 2:
                        $_2++;
                        break;
                    case 3:
                        $_3++;
                        break;
                    case 4:
                        $_4++;
                        break;
                    case 5:
                        $_5++;
                        break;
                    case 6:
                        $_6++;
                        break;
                    case 7:
                        $_7++;
                        break;
                    case 8:
                        $_8++;
                        break;
                    case 9:
                        $_9++;
                        break;
                    case 10:
                        $_10++;
                        break;
                    case 11:
                        $_11++;
                        break;
                    case 12:
                        $_12++;
                        break;
                    case 13:
                        $_13++;
                        break;
                    case 14:
                        $_14++;
                        break;
                    case 15:
                        $_15++;
                        break;
                    case 16:
                        $_16++;
                        break;
                    case 17:
                        $_17++;
                        break;
                    case 18:
                        $_18++;
                        break;
                    case 19:
                        $_19++;
                        break;
                    case 20:
                        $_20++;
                        break;
                    case 21:
                        $_21++;
                        break;
                    case 22:
                        $_22++;
                        break;
                    case 23:
                        $_23++;
                        break;
                    case 24:
                        $_24++;
                        break;
                    case 25:
                        $_25++;
                        break;
                    case 26:
                        $_26++;
                        break;
                    case 27:
                        $_27++;
                        break;
                    case 28:
                        $_28++;
                        break;
                    case 29:
                        $_29++;
                        break;
                    case 30:
                        $_30++;
                        break;
                    case 31:
                        $_31++;
                        break;
                }
            }
            $res = array( $_1, $_2, $_3, $_4, $_5, $_6, $_7, $_8, $_9, $_10, $_11, $_12, $_13, $_14, $_15, $_16, $_17, $_18, $_19, $_20, $_21, $_22, $_23,$_24,$_25,$_26,$_27,$_28,$_29,$_30,$_31);
            mysql_close($con);
            return $res;
        }
    }
    /************ 统计每天产能结束 **************/

    /************ 统计每小时产能 ****************/
    private function _getHourEveryDay($year=null,$month=null,$day=null){
        global $databaseName,$tableName,$databaseUser,$databasePassword;
        date_default_timezone_set('Asia/Shanghai');
        if($year == null || $month == null || $day == null){
            $Year = date('Y');
            $Month = date('m');
            $Day = date('d');
        }else{
            $Year = $year;
            $Month = $month;
            $Day = $day;
        }

        $cmd = "select * from ".$tableName." where Test_Dateyyyy='".$Year."' AND Test_DateMM='".$Month."' AND Test_Datedd='".$Day."'";

        $con = mysql_connect('localhost',$databaseUser,$databasePassword);
        if(!$con){
            return null;
        }
        mysql_select_db($databaseName,$con);
        $tmpresult = mysql_query($cmd);
        $number = mysql_num_rows($tmpresult);
        if($number == 0){
            mysql_close($con);
            return array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        }else {
            $_0 = 0;
            $_1 = 0;
            $_2 = 0;
            $_3 = 0;
            $_4 = 0;
            $_5 = 0;
            $_6 = 0;
            $_7 = 0;
            $_8 = 0;
            $_9 = 0;
            $_10 = 0;
            $_11 = 0;
            $_12 = 0;
            $_13 = 0;
            $_14 = 0;
            $_15 = 0;
            $_16 = 0;
            $_17 = 0;
            $_18 = 0;
            $_19 = 0;
            $_20 = 0;
            $_21 = 0;
            $_22 = 0;
            $_23 = 0;

            while ($resultArray = mysql_fetch_assoc($tmpresult)) {
                switch ((int)$resultArray['Test_TimeHH']) {
                    case 0:
                        $_0++;
                        break;
                    case 1:
                        $_1++;
                        break;
                    case 2:
                        $_2++;
                        break;
                    case 3:
                        $_3++;
                        break;
                    case 4:
                        $_4++;
                        break;
                    case 5:
                        $_5++;
                        break;
                    case 6:
                        $_6++;
                        break;
                    case 7:
                        $_7++;
                        break;
                    case 8:
                        $_8++;
                        break;
                    case 9:
                        $_9++;
                        break;
                    case 10:
                        $_10++;
                        break;
                    case 11:
                        $_11++;
                        break;
                    case 12:
                        $_12++;
                        break;
                    case 13:
                        $_13++;
                        break;
                    case 14:
                        $_14++;
                        break;
                    case 15:
                        $_15++;
                        break;
                    case 16:
                        $_16++;
                        break;
                    case 17:
                        $_17++;
                        break;
                    case 18:
                        $_18++;
                        break;
                    case 19:
                        $_19++;
                        break;
                    case 20:
                        $_20++;
                        break;
                    case 21:
                        $_21++;
                        break;
                    case 22:
                        $_22++;
                        break;
                    case 23:
                        $_23++;
                        break;
                }
            }
            $res = array($_0, $_1, $_2, $_3, $_4, $_5, $_6, $_7, $_8, $_9, $_10, $_11, $_12, $_13, $_14, $_15, $_16, $_17, $_18, $_19, $_20, $_21, $_22, $_23);
            mysql_close($con);
            return $res;
        }
    }

    /************ 统计每小时产能结束 ****************/


    /************ 导出Excel *******************/
    private function _exportExcel($tempPost){
        global $databaseName,$tableName,$databaseUser,$databasePassword;

        $cmd = "SELECT * FROM ".$tableName." WHERE ";
        foreach ($tempPost as $key=>$value){
            if($value != "") {
                $cmd .= $key . "=" . "'" . $value . "' AND ";
            }
        }
        $cmd .= " ID";


        $con = mysql_connect('localhost',$databaseUser,$databasePassword);
        if(!$con){
            return null;
        }
        mysql_select_db($databaseName,$con);
        $tmpresult = mysql_query($cmd);
        $number = mysql_num_rows($tmpresult);

        if($number == 0){
            echo "没有相关条目，无法导出表格";
        }else{
            $titleArray = array('ID','设备名','设备型号','设备识别码','镜像信息','外放测试结果','耳机孔测试结果',
                '相机测试结果','录音测试结果','TF卡测试结果','USB测试结果','以太网测试结果','WIFI测试结果','移动网络测试结果',
                'GPS测试结果','蓝牙测试结果','屏幕测试结果','触摸测试结果','RS232串口测试结果','RS485串口测试结果',
                'GPIO串口测试结果','RTC测试结果','整机测试结果','测试时间');
            $dataArrays = array(array());
            while($resultArray = mysql_fetch_assoc($tmpresult)){
                $testDateTime =$resultArray['Test_Dateyyyy']."/".$resultArray['Test_DateMM']."/".$resultArray['Test_Datedd']
                    ." ".$resultArray['Test_TimeHH']."-".$resultArray['Test_Timemm']."-".$resultArray['Test_Timess'];
                $dataArray = array();
                $dataArray[0] = $resultArray['ID'];
                array_push($dataArray,$resultArray['Name'],$resultArray['Type'],'"'.$resultArray['Uuid'].'"','"'.$resultArray['LastUpdateDate'].'"');
                if($resultArray['SpkEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['SpkEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['SpkEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['HpEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['HpEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['HpEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['CameraEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['CameraEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['CameraEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['RecordEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['RecordEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['RecordEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['TFEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['TFEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['TFEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['USBEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['USBEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['USBEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['EthEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['EthEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['EthEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['WifiEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['WifiEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['WifiEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['MobileNetEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['MobileNetEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['MobileNetEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['GPSEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['GPSEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['GPSEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['BTEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['BTEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['BTEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['ScreenEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['ScreenEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['ScreenEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['TSEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['TSEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['TSEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['RS232EndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['RS232EndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['RS232EndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['RS485EndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['RS485EndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['RS485EndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['GPIOEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['GPIOEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['GPIOEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['RTCEndResult'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['RTCEndResult'] == -1){
                    array_push($dataArray,'设备不支持');
                }else if($resultArray['RTCEndResult'] == 1){
                    array_push($dataArray,'测试通过');
                }
                if($resultArray['ISPass'] == 0){
                    array_push($dataArray,'测试不通过');
                }else if($resultArray['ISPass'] == 1){
                    array_push($dataArray,'设备通过');
                }
                array_push($dataArray,$testDateTime);
                if(empty($dataArrays)){
                    $dataArrays[0] = $dataArray;
                }else {
                    array_push($dataArrays, $dataArray);
                }
            }
            $excelName = 'AndroidMachine'.date('ymdhis').'.csv';
            var_dump($dataArray);
            $this->_exportToExcel($excelName,$titleArray,$dataArrays);

            header('location:'.$excelName);
        }

        mysql_close($con);

    }


    private function _exportToExcel($fileName,$titleArray=[],$dataArray=[]){
        ini_set('memory_limit','512M');
        ini_set('max_execution_time',0);
        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=".$fileName);
        $fp=fopen('php://output','w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp,$titleArray);
        $index = 0;
        foreach ($dataArray as $item){
            if($index==1000){
                $index=0;
                ob_flush();
                flush();
            }
            $index++;
            fputcsv($fp,$item);
        }
        ob_flush();
        flush();
        ob_end_clean();
    }

    /************ 导出Excel结束 *******************/

    /* 模糊搜索 */
    private function _FuzzySearch($tempPost){
        global $databaseName,$tableName,$databaseUser,$databasePassword;

        $cmd = "SELECT * FROM ".$tableName." WHERE ";
        foreach ($tempPost as $key=>$value){
            if($value != "") {
                $cmd .= $key . "=" . "'" . $value . "' AND ";
            }
        }
        $cmd .= " ID";

        $con = mysql_connect('localhost',$databaseUser,$databasePassword);
        if(!$con){
            return null;
        }
        mysql_select_db($databaseName,$con);
        $tmpresult = mysql_query($cmd);
        $number = mysql_num_rows($tmpresult);


        echo "<p align='center'> 搜索到\"$number\"条结果</p>";//这里显示搜索结果

        /* 测试简略数据显示 */
        echo "<table align='center' border='1' cellspacing='0' width='50%'>";
        echo "<tr>";
        echo "<th>设备名称</th>";
        echo "<th>测试结果</th>";
        echo "<th>测试时间</th>";
        echo "<th>数据上传时间</th>";
        echo "</tr>";

        while($resultArray = mysql_fetch_assoc($tmpresult)){
            $testDateTime =$resultArray['Test_Dateyyyy']."-".$resultArray['Test_DateMM']."-".$resultArray['Test_Datedd']
                ." ".$resultArray['Test_TimeHH'].":".$resultArray['Test_Timemm'].":".$resultArray['Test_Timess'];


            $tempName = $resultArray['Name'];
            $tempUploadDate = $resultArray['UpLoadDate'];
            //防止搜索到多条结果 unlikely
            echo "<tr>";

            echo "<td><a href='/dataManagementSystem/AP/detailedInformation.php?Name=$tempName'>$tempName</a></td>";

            if ($resultArray["ISPass"] == 1) {
                echo "<td>测试通过</td>";
            } else if ($resultArray["ISPass"] == 0) {
                echo "<td bgcolor='red'>测试不通过</td>";
            }
            echo "<td>$testDateTime</td>";
            echo "<td>$tempUploadDate</td>";

            echo "</tr>";

            /*显示数据结束*/
        }
        echo "</table>";



        mysql_close($con);
    }


    /**
     * 需要返回数据库操作后的结果语句的方法
     * @param $cmd 数据库操作语句
     * @return array|null array[0] 为行数， array[1]为结果
     */
    private function execMysqlForResult($cmd){
        global $databaseName,$tableName,$databaseUser,$databasePassword;

        $result = array($num=0,$arry=null);
        $con = mysql_connect('localhost',$databaseUser,$databasePassword);
        if(!$con){
            return null;
        }
        $Tresult = mysql_select_db($databaseName,$con);
        if(!$Tresult){
            mysql_close($con);
            return null;
        }
        $tmpresult = mysql_query($cmd);
        $result[0] = mysql_num_rows($tmpresult);
        $result[1] = mysql_fetch_array($tmpresult);
        mysql_close($con);
        return $result;
    }

    /**
     * 只需要返回执行是否成功的执行的方法
     * @param $cmd 数据库操作语句
     * @return array|null|resource
     */
    private function execMysqlSilence($cmd){
        global $databaseName,$tableName,$databaseUser,$databasePassword;

        $result = array($num=0,$arry=null);
        $con = mysql_connect('localhost',$databaseUser,$databasePassword);
        if(!$con){
            return null;
        }
        mysql_select_db($databaseName,$con);
        $result = mysql_query($cmd);
        mysql_close($con);
        return $result;
    }


    /**
     * 详细信息显示界面
     * @param $typeName
     */
    private function _detailedInformation($typeName){
        global $databaseName,$tableName;
        $sql = "select * from ".$tableName." WHERE Name='".$typeName."'";

        $temResult = $this->execMysqlForResult($sql);

        /* 详细信息显示 */
        echo "<table align='center' border='1' cellspacing='0' width='50%'>";
        echo "<caption>".$temResult[1]['Name']."测试数据</caption>";


        echo "<tr><td>ID</td><td colspan='2'>".$temResult[1]['ID']."</td></tr>";
        echo "<tr><td>设备名称</td><td colspan='2'>".$temResult[1]['Name']."</td></tr>";
        echo "<tr><td>设备型号</td><td colspan='2'>".$temResult[1]['Type']."</td></tr>";
        echo "<tr><td>CPU型号</td><td colspan='2'>".$temResult[1]['CPUType']."</td></tr>";
        echo "<tr><td>设备识别码</td><td colspan='2'>".$temResult[1]['Uuid']."</td></tr>";
        echo "<tr><td>镜像更新时间</td><td colspan='2'>".$temResult[1]['LastUpdateDate']."</td></tr>";
        echo "<tr><td>CPU串号</td><td colspan='2'>".$temResult[1]['CpuSerial']."</td></tr>";

        $this->showTestProjectResult("Spk","外放测试",$temResult);
        $this->showTestProjectResult("Hp","耳机测试",$temResult);
        $this->showTestProjectResult("Camera","相机测试",$temResult);
        $this->showTestProjectResult("Record","录音测试",$temResult);
        $this->showTestProjectResult("TF","TF卡测试",$temResult);
        $this->showTestProjectResult("USB","USB口测试",$temResult);
        $this->showTestProjectResult("Eth","以太网测试",$temResult);
        $this->showTestProjectResult("Wifi","WIFI测试",$temResult);
        $this->showTestProjectResult("MobileNet","移动网络测试",$temResult);
        $this->showTestProjectResult("GPS","GPS测试",$temResult);
        $this->showTestProjectResult("BT","蓝牙测试",$temResult);
        $this->showTestProjectResult("Screen","屏幕测试",$temResult);
        $this->showTestProjectResult("TS","触摸测试",$temResult);
        $this->showTestProjectResult("RS232","RS232串口测试",$temResult);
        $this->showTestProjectResult("RS485","RS485串口测试",$temResult);
        $this->showTestProjectResult("GPIO","GPIO测试",$temResult);
        $this->showTestProjectResult("RTC","RTC测试",$temResult);

        if($temResult[1]['ISPass'] == 1)
            echo "<tr><th>设备整体测试是否通过</th><th colspan='2'>测试通过</th></tr>";
        else if($temResult[1]['ISPass'] == 0)
            echo "<tr><th>设备整体测试是否通过</th><th colspan='2'bgcolor='red'>测试不通过</th></tr>";

        $tempTestTime = $temResult[1]['Test_Dateyyyy']."-".$temResult[1]['Test_DateMM']."-".$temResult[1]['Test_Datedd']
            ." ".$temResult[1]['Test_TimeHH'].":".$temResult[1]['Test_Timemm'].":".$temResult[1]['Test_Timess'];
        echo "<tr><td>测试时间</td><th colspan='2'>".$tempTestTime."</th></tr>";
        echo "<tr><td>数据上传时间</td><th colspan='2'>".$temResult[1]['UpLoadDate']."</th></tr>";

        echo "</table>";
        echo "<br><br>";
        /* 详细信息显示结束 */
    }

    private function showTestProjectResult($project,$projectShowName,$temResult){
        $projectTestTimes = $project."TestTimes";
        $projectTestPassTimes = $project."PassTimes";
        $projectTestNotPassTimes = $project."NotPassTimes";
        $projectEndResult = $project."EndResult";
        echo "<tr>";
        echo "<th rowspan='5'>".$projectShowName."</th>";
        echo "<tr><td>测试总次数</td><th>".$temResult[1][$projectTestTimes]."</th></tr>";
        echo "<tr><td>测试通过次数</td><th>".$temResult[1][$projectTestPassTimes]."</th></tr>";
        echo "<tr><td>测试不通过次数</td><th>".$temResult[1][$projectTestNotPassTimes]."</th></tr>";
        if($temResult[1][$projectEndResult] == 1)
            echo "<tr><td>最后测试是否通过</td><th>测试通过</th></tr>";
        else if($temResult[1][$projectEndResult] == 0)
            echo "<tr><td>最后测试是否通过</td><th bgcolor='red'>测试不通过</th></tr>";
        else if($temResult[1][$projectEndResult] == -1)
            echo "<tr><td>最后测试是否通过</td><th bgcolor='#7fff00'>设备不支持</th></tr>";
        echo "</tr>";
    }

    /**
     * 精确搜索 返回简略结果
     * @param $Uuid
     * @return string
     */
    private function _AccurateScarchResult($Uuid){
        global $databaseName, $tableName;
        $sql = "select * from ".$tableName." WHERE Uuid='".$Uuid."'";
        $temResult = $this->execMysqlForResult($sql);
        echo "<p align='center'> 搜索到\"$temResult[0]\"条结果</p>";//这里显示搜索结果

        $testDateTime = $temResult[1]['Test_Dateyyyy']."-".$temResult[1]['Test_DateMM']."-".$temResult[1]['Test_Datedd']
            ." ".$temResult[1]['Test_TimeHH'].":".$temResult[1]['Test_Timemm'].":".$temResult[1]['Test_Timess'];
        if($temResult[0] == 1) {
            /* 测试简略数据显示 */
            echo "<table align='center' border='1' cellspacing='0' width='50%'>";
            echo "<tr>";
            echo "<td>设备名称</td>";
            echo "<td>测试结果</td>";
            echo "<td>测试时间</td>";
            echo "<td>数据上传时间</td>";
            echo "</tr>";
            $tempName = $temResult[1]['Name'];
            $tempUploadDate = $temResult[1]['UpLoadDate'];
            //防止搜索到多条结果 unlikely
            echo "<tr>";

            echo "<td><a href='/dataManagementSystem/AP/detailedInformation.php?Name=$tempName'>$tempName</a></td>";

            if ($temResult[1]["ISPass"] == 1) {
                echo "<td>测试通过</td>";
            } else if ($temResult[1]["ISPass"] == 0) {
                echo "<td bgcolor='red'>测试不通过</td>";
            }
            echo "<td>$testDateTime</td>";
            echo "<td>$tempUploadDate</td>";

            echo "</tr>";

            echo "</table>";
            /*显示数据结束*/
        }
    }



    /*************** 添加数据开始 *******************/

    private  function _addData($jsonString)
    {
        global $databaseName, $tableName, $databaseUser, $databasePassword;
        $jsonArray = json_decode($jsonString, true);
        $title = '';
        $values = '';

        /*******权限验证*******/
        $USER = $jsonArray['USER'];
        $PASSWORD = $jsonArray['PASSWORD'];
        $_USEROP = new USEROP();
        if(5 != $_USEROP->getUserLevel($USER,$PASSWORD)){
            return -666;
        }
        /*****权限验证结束*****/

        /*判断数据是否已经存在*/
        $sql = "select * from " . $tableName . " where Uuid='" . $jsonArray['Uuid'] . "'";
        /*****数据库操作开始*******/
        $con = mysql_connect('localhost', $databaseUser, $databasePassword);
        if (!$con)
            return -111; //查询数据是否存在数据库无法连接
        $res = mysql_select_db($databaseName, $con);
        if (!$res){
            mysql_close($con);
            return -222; //查询数据是否存在数据库无法选择
        }
        $tmpresult = mysql_query($sql);
        $rowNum = mysql_num_rows($tmpresult);
        $resultArray = mysql_fetch_array($tmpresult);
        mysql_close($con);
        /*****数据库操作结束*******/


        $result = '';
        if ($rowNum == 1) {
            /* 这里是数据原先存在*/
            foreach ($jsonArray as $key => $value) {
                if (substr_count($key, "TestTimes") >= 1
                    || substr_count($key, "PassTimes") >= 1
                    || substr_count($key, "NotPassTimes") >= 1
                ) {
                    $values .= $key . "='" . ($resultArray[$key] + $value) . "',";
                } else {
                    if($key == "USER" || $key=="PASSWORD"){}else{
                        $values .= $key . "='" . $value . "',";
                    }
                }
            }
            $values = substr($values, 0, strlen($values) - 1);
            $title .= "where Uuid='" . $jsonArray['Uuid'] . "'";

            $result = "UPDATE " . $tableName . " SET " . $values . " " . $title;
        } else if ($rowNum == 0) {
            /* 这里是数据原先不存在*/
            foreach ($jsonArray as $key => $value) {
                if($key == "USER" || $key=="PASSWORD"){}else {
                    $title .= $key . ',';
                    $values .= "'" . $value . "'" . ',';
                }
            }
            $title = substr($title, 0, strlen($title) - 1);
            $values = substr($values, 0, strlen($values) - 1);
            $result = "insert into " . $tableName . " ($title) values ($values)";
        }


        /*****数据库操作开始*******/
        $con = mysql_connect('localhost', $databaseUser, $databasePassword);
        if (!$con)
            return -333; //添加数据连接数据库无法连接
        $res = mysql_select_db($databaseName, $con);
        if (!$res){
            mysql_close($con);
            return -555; //添加数据连接数据库无法选择
        }
        $tmpresult = mysql_query($result);
        $rowNum = mysql_num_rows($tmpresult);
        $resultArray = mysql_fetch_array($tmpresult);
        mysql_close($con);
        /*****数据库操作结束*******/
        return 0;
    }
    /*************** 添加数据结束 *******************/

    /**
     * 获取添加数据的数据库语句，同一个UUID只会覆盖
     * @param $jsonString 客户端提交过来的json字符串
     * @return bool|string 成功返回数据库语句，失败返回false
     */
    private function getAddDataCmd($jsonString){
        global $databaseName, $tableName;
        $jsonArray = json_decode($jsonString,true);
        $title = '';
        $values = '';

        /*判断数据是否已经存在*/
        $sql = "select * from ".$tableName." where Uuid='".$jsonArray['Uuid']."'";
        $tempRes = $this->execMysqlForResult($sql);
        if($tempRes == null){
            return false;
        }
        if($tempRes[0] == 1){
            /* 这里是数据原先存在*/
            foreach ($jsonArray as $key=>$value){
                if(substr_count($key,"TestTimes") >= 1
                    ||substr_count($key,"PassTimes") >= 1
                    ||substr_count($key,"NotPassTimes") >= 1){
                    $values .= $key."='".($tempRes[1][$key]+$value)."',";
                }else{
                    $values .= $key."='".$value."',";
                }
            }
            $values = substr($values,0,strlen($values)-1);
            $title .= "where Uuid='".$jsonArray['Uuid']."'";

            $result = "UPDATE ".$tableName." SET ".$values." ".$title;
            return $result;
        }else if($tempRes[0] == 0){
            /* 这里是数据原先不存在*/
            foreach ($jsonArray as $key=>$value){
                $title .= $key.',';
                $values .= "'".$value."'".',';
            }
            $title = substr($title,0,strlen($title)-1);
            $values = substr($values,0,strlen($values)-1);
            $result = "insert into ".$tableName." ($title) values ($values)";
            return $result;
        }
        return false;
    }

}


?>