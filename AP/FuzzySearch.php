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
    <h1 >模糊查找</h1>
    <form action="FuzzySearchResultShow.php" method="post">
        <TABLE align="center" border="1" cellspacing="0" width="50%">
            <caption>筛选列表</caption>
            <tr>
                <td >输入测试日期(YYYY-mm-dd)：</td>
                <td>
                    <input type="date" name="date">
                </td>
            </tr>

            <tr>
                <td>输入设备型号：</td>
                <td>
                    <select name="Type">
                        <option value="">可不选</option>
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

            <tr>
                <td>输入CPU型号：</td>
                <td>
                    <select name="CPUType">
                        <option value="">可不选</option>
                        <option value="H3">H3</option>
                        <option value="A33">A33</option>
                        <option value="RK3288">RK3288</option>
                        <option value="RK3368">RK3368</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>外放测试是否通过：</td>
                <td>
                    <select name="SpkEndResult" >
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>耳机测试是否通过：</td>
                <td>
                    <select name="HpEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>相机测试是否通过：</td>
                <td>
                    <select name="CameraEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>录音测试是否通过：</td>
                <td>
                    <select name="RecordEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>TF卡测试是否通过：</td>
                <td>
                    <select name="TFEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>USB测试是否通过：</td>
                <td>
                    <select name="USBEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>以太网测试是否通过：</td>
                <td>
                    <select name="EthEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>WIFI测试是否通过：</td>
                <td>
                    <select name="WifiEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>移动网络测试是否通过：</td>
                <td>
                    <select name="MobileNetEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>GPS测试是否通过：</td>
                <td>
                    <select name="GPSEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>蓝牙测试是否通过：</td>
                <td>
                    <select name="BTEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>屏幕显示测试是否通过：</td>
                <td>
                    <select name="ScreenEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>触摸测试是否通过：</td>
                <td>
                    <select name="TSEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>RS232串口测试是否通过：</td>
                <td>
                    <select name="RS232EndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>RS485串口测试是否通过：</td>
                <td>
                    <select name="RS485EndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>GPIO测试是否通过：</td>
                <td>
                    <select name="GPIOEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                        <option value=-1>不支持</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>RTC测试是否通过：</td>
                <td>
                    <select name="RTCEndResult">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>整机测试是否通过：</td>
                <td>
                    <select name="ISPass">
                        <option value="">可不选</option>
                        <option value=1>是</option>
                        <option value=0>否</option>
                    </select>
                </td>
            </tr>
        </TABLE>
        <input type="submit" value="开始搜索" align="center">
    </form>
</div>

</body>
</html>