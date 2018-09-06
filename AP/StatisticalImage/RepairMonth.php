<?php
    require_once("../../jpgraph/jpgraph.php");
    require_once("../../jpgraph/jpgraph_pie.php");
    require_once("../../jpgraph/jpgraph_pie3d.php");
    require_once ("../../BP/GMFC.php");

    date_default_timezone_set('Asia/Shanghai');
    $title = date('Y年m月d日')."返修比例";
    $name = array("Pass","Repair");
    $year = date('Y');
    $month = date('m');
    $day = date('d');

    $_GMFS = new GMFC();
    $data = $_GMFS->getRepair($year,$month,$day,null);



    $graph = new PieGraph(180,400);
    $graph->SetShadow();
    $graph->title->Align('left');
    $graph->title->Set($title);
    $graph->title->SetFont(FF_SIMSUN,FS_BOLD);

    $pieplot = new PiePlot($data);  //创建PiePlot3D对象
    $pieplot->SetCenter(0.4, 0.5); //设置饼图中心的位置
    $pieplot->SetLegends($name); //设置图例

    $graph->Add($pieplot);
    $graph->Stroke();
?>