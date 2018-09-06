<?php
    require_once("../../jpgraph/jpgraph.php");
    require_once("../../jpgraph/jpgraph_line.php");
    require_once ("../../BP/GMFC.php");

    $S_GMFC = new GMFC();
    $data1 = $S_GMFC->getDayEveryMonth();

//    $data1 = array(523,634,371,278,685,587,490); //第一条曲线的数组

    $xSing = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
    date_default_timezone_set('Asia/Shanghai');
    $title = date('Y年m月')."产量统计图";
    $xTitle = '日期(日)';
    $yTitle = '数量(个)';




    $graph = new Graph(700,300);
    $graph->SetScale("textint");
    $graph->SetShadow();
    $graph->img->SetMargin(60,30,30,70); //设置图像边距

    $graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效


    $lineplot1=new LinePlot($data1); //创建设置两条曲线对象
    $lineplot1->value->SetColor("black");
    $lineplot1->SetColor('red');
    $lineplot1->value->SetAngle(1);
    $lineplot1->value->Show();
    $graph->Add($lineplot1);  //将曲线放置到图像上

    $graph->title->Set($title);   //设置图像标题
    $graph->xaxis->title->Set($xTitle); //设置坐标轴名称
    $graph->title->Align('left');
    $graph->yaxis->title->Set($yTitle);
    $graph->title->SetMargin(10);
    $graph->xaxis->title->SetMargin(10);
    $graph->yaxis->title->SetMargin(10);

    $graph->title->SetFont(FF_SIMSUN,FS_BOLD); //设置字体
    $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
    $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
    $graph->xaxis->SetTickLabels($xSing);

    $graph->Stroke();  //输出图像



?>