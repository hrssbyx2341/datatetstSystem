<?php
    require_once("../../jpgraph/jpgraph.php");
    require_once("../../jpgraph/jpgraph_bar.php");
    require_once("../../BP/GMFC.php");

    $_GMFC = new GMFC();

    date_default_timezone_set('Asia/Shanghai');
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    $hour = date('H');

    $data = $_GMFC->getProjectRepair($year,$month,$day,null);

    $ydata = array("Spk","Hp","Cam","Rec","TF","USB","Eth","Wifi","4G","GPS","BT","Scre","TS","232","485","GPIO","RTC");

    $title = date('Y年m月d日')."项目返修统计图";
    $xName = "项目名称";
    $yName = "次数(次)";

    $graph = new Graph(500,400);  //创建新的Graph对象
    $graph->SetScale("textint");  //刻度样式
    $graph->SetShadow();          //设置阴影
    $graph->img->SetMargin(40,30,40,50); //设置边距

    $graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效

    $barplot = new BarPlot($data);  //创建BarPlot对象
    $barplot->SetFillColor('blue'); //设置颜色
    $barplot->value->Show(); //设置显示数字
    $graph->Add($barplot);  //将柱形图添加到图像中

    $graph->title->Set($title);
    $graph->xaxis->title->Set($xName); //设置标题和X-Y轴标题
    $graph->yaxis->title->Set($yName);
    $graph->title->SetColor("red");
    $graph->title->SetMargin(10);
    $graph->title->Align('left');
    $graph->xaxis->title->SetMargin(5);
    $graph->xaxis->SetTickLabels($ydata);

    $graph->title->SetFont(FF_SIMSUN,FS_BOLD);  //设置字体
    $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
    $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
    $graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);

    $graph->Stroke();
?>